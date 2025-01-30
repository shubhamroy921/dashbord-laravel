<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Razorpay\Api\Api;


class CartController extends Controller
{
    public function addToCart(Request $request, $productId)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'You need to login to add items to the wishlist.'], 401);
        }
        $user = Auth::user();
        $product = Product::findOrFail($productId); // Find the product
        $cartItem = Cart::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();
        if ($cartItem) {
            $cartItem->quantity += $request->input('quantity');
            $cartItem->save();
            $message = "Product quantity updated in your cart.";
        } else {
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'quantity' => $request->input('quantity'),
            ]);
            $message = "Product added to your cart.";
        }

        return response()->json(['message' => $message]);
    }

    public function getCartCount()
    {
        $cartCount = Cart::where('user_id', Auth::id())->count() ?? 0; // Sum of all quantities in the user's cart
        return response()->json(['cartCount' => $cartCount]);
    }

    public function showCart()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userId = Auth::id();
        $cartItems = Cart::with('product') // Eager load the product details
            ->where('user_id', $userId) // Filter by user
            ->get();
        $totalAmount = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity; // Multiply price by quantity
        });

        // Pass the cart items and total amount to the view
        return view('frontend.layouts.header.header', compact('cartItems', 'totalAmount'));
    }

    public function getCartItems()
    {
        $userId = Auth::id();
        $cartItems = Cart::with('product')->where('user_id', $userId)->get();
        $response = [
            'items' => $cartItems->map(function ($cartItem) {
                $productPrice = (float) ($cartItem->product->discount_price ?? 0);
                $quantity = $cartItem->quantity;
                $totalPrice = $productPrice * $quantity; // Calculate total for this product

                return [
                    'id' => $cartItem->id,
                    'image' => $cartItem->product->images->first()->path ?? asset('assets/default/pexels-photo-821651.jpeg'),
                    'alt' => $cartItem->product->images->first()->alt ?? 'Product Image',
                    'name' => $cartItem->product->title ?? 'Product not found',
                    'price' => $productPrice,
                    'quantity' => $quantity,
                    'total' => $totalPrice, // Send total price of the product
                ];
            }),
            'total' => $cartItems->sum(function ($cartItem) {
                return (float) optional($cartItem->product)->discount_price * $cartItem->quantity;
            }),
        ];

        return response()->json($response);
    }

    public function removeCartItem($id)
    {
        $userId = Auth::id();
        $cartItem = Cart::where('id', $id)->where('user_id', $userId)->first();
        if ($cartItem) {
            $cartItem->delete();
            return response()->json([
                'message' => 'Item removed from cart successfully.',
            ]);
        }
        return response()->json([
            'error' => 'Item not found.',
        ], 404);
    }

    public function proceedToCheckout(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'User not authenticated.'], 401);
        }

        $cartItems = Cart::where('user_id', $user->id)->get();
        if ($cartItems->isEmpty()) {
            return response()->json(['error' => 'Cart is empty.'], 400);
        }

        $totalAmount = 0;

        foreach ($cartItems as $item) {
            $product = $item->product;
            if (!$product) {
                return response()->json(['error' => 'Product not found for an item in your cart.'], 400);
            }

            if (!is_numeric($product->discount_price) || $product->discount_price <= 0) {
                return response()->json(['error' => 'Invalid product pricing for ' . $product->name . '.'], 400);
            }

            $totalAmount += $product->sell_price * $item->quantity;
        }

        // Define static values for savings, store pickup, and tax
        $savings = $cartItems->sum(function ($item) {
            return ($item->product->sell_price - $item->product->discount_price) * $item->quantity;
        });
        $storePickup = 36.00;
        $tax = 9.00;

        // Calculate the final total by adding store pickup and tax, subtracting savings
        $total = $totalAmount - $savings + $storePickup + $tax;

        // Ensure the total amount is valid
        if ($total <= 0) {
            return response()->json(['error' => 'Invalid total amount.'], 400);
        }

        // Generate a unique transaction ID
        $transactionId = 'ORD_' . time() . '_' . uniqid();

        // Create the order record
        $order = Order::create([
            'user_id' => $user->id,
            'total_amount' => $total,
            'status' => 'pending',
            'transaction_id' => $transactionId,
        ]);

        // Create the order items
        foreach ($cartItems as $item) {
            $order->items()->create([
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->discount_price,
                'images' => $item->product->images->first()->path ?? null,
            ]);
        }

        // Razorpay Payment Integration
        $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_SECRET_KEY'));
        $orderData = [
            'receipt'         => $transactionId,
            'amount'          => $total * 100, // amount in the smallest currency unit
            'currency'        => 'INR',
            'payment_capture' => 1 // auto capture
        ];

        try {
            $razorpayOrder = $api->order->create($orderData);

            // Store the payment record
            Payment::create([
                'amount' => $total * 100,
                'transaction_id' => $transactionId,
                'payment_status' => 'PAYMENT_PENDING',
                'response_msg' => json_encode($razorpayOrder),
                'providerReferenceId' => $razorpayOrder['id'],
            ]);

            return response()->json(['orderId' => $razorpayOrder['id'], 'amount' => $total * 100, 'currency' => 'INR']);
        } catch (\Exception $e) {
            // Log the exception for debugging
            Log::error('Razorpay Payment Exception', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'An error occurred while processing the payment. Please try again later.'], 500);
        }
    }

    public function paymentCallback(Request $request)
    {
        $data = $request->all();
        Log::info('Payment Callback Data', $data);

        if (empty($data['razorpay_payment_id']) || empty($data['razorpay_order_id'])) {
            return response()->json(['error' => 'Missing required fields.'], 400);
        }

        $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_SECRET_KEY'));

        try {
            $payment = $api->payment->fetch($data['razorpay_payment_id']);

            if ($payment['status'] == 'captured') {
                $order = Order::where('transaction_id', $payment['order_id'])->first();

                if (!$order) {
                    return response()->json(['error' => 'Order not found.'], 404);
                }

                DB::beginTransaction();

                $order->update(['status' => 'Paid']);

                Payment::create([
                    'transaction_id' => $payment['order_id'],
                    'payment_status' => 'SUCCESS',
                    'amount' => $payment['amount'],
                    'providerReferenceId' => $payment['id'],
                    'response_msg' => json_encode($payment),
                ]);

                // Remove cart items after successful payment
                // Cart::where('user_id', $order->user_id)->delete();

                DB::commit();
                return response()->json(['message' => 'Payment successful.']);
            } else {
                Log::error('Payment Failed', ['payment_id' => $data['razorpay_payment_id'], 'status' => $payment['status']]);
                return response()->json(['error' => 'Payment failed.'], 500);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Payment Callback Exception', ['message' => $e->getMessage()]);
            return response()->json(['error' => 'An error occurred while processing the payment callback.'], 500);
        }
    }

    public function showData()
    {
        // Ensure the user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userId = Auth::id();

        // Get the user's cart items along with the related product details (Eloquent)
        $cartItems = Cart::with('product.images') // Eager load the product details
            ->where('user_id', $userId) // Filter by user
            ->get();

        // Define static values for savings, store pickup, and tax
        $savings = $cartItems->sum(function ($item) {
            return ($item->product->sell_price - $item->product->discount_price) * $item->quantity;
        });
        $storePickup = 36.00;
        $tax = 9.00;

        // Calculate total amount using Eloquent
        $totalAmount = $cartItems->sum(function ($item) {
            return $item->product->sell_price * $item->quantity; // Multiply price by quantity
        });
        $total = $totalAmount - $savings + $storePickup + $tax;
        return view('frontend.pages.cart', compact('cartItems', 'totalAmount', 'savings', 'storePickup', 'tax', 'total'));
    }


    // Increment quantity
    public function incrementQuantity(Request $request, $cartId)
    {
        $cartItem = Cart::findOrFail($cartId);

        // Increment the quantity
        $cartItem->quantity += 1;
        $cartItem->save();

        return response()->json([
            'success' => true,
            'message' => 'Quantity increased successfully.',
        ]);
    }

    // Decrement quantity
    public function decrementQuantity(Request $request, $cartId)
    {
        $cartItem = Cart::findOrFail($cartId);

        // Decrement the quantity
        $cartItem->quantity -= 1;

        if ($cartItem->quantity <= 0) {
            $cartItem->delete();

            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart.',
            ]);
        }

        $cartItem->save();

        return response()->json([
            'success' => true,
            'message' => 'Quantity decreased successfully.',
        ]);
    }
}
