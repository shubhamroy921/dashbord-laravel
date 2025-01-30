<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function addToWishlist(Request $request, $productId)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'You need to login to add items to the wishlist.'], 401);
        }
        $user = Auth::user();
        $product = Product::findOrFail($productId);
        $wishlistItem = Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();
        if ($wishlistItem) {
            return response()->json(['message' => 'Product is already in your wishlist.']);
        }
        Wishlist::create([
            'user_id' => $user->id,
            'product_id' => $productId,  // Corrected line
        ]);
        return response()->json(['message' => 'Product added to your wishlist.']);
    }
    public function getWishlistItems()
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'You need to login to view your wishlist.'], 401);
        }
        $user = Auth::user();
        $wishlistItems = Wishlist::where('user_id', $user->id)
            ->with('product.images')
            ->get();
        return view('frontend.pages.wishlist', compact('wishlistItems'));
    }

    public function remove($id)
    {
        $wishlistItem = Wishlist::where('product_id', $id)->first();
        if ($wishlistItem) {
            $wishlistItem->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }
    // In your controller
    public function toggleWishlist($productId)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('success', 'You need to login to add items to the wishlist.');
        }

        $user = auth()->user();
        $product = Product::findOrFail($productId);

        $wishlistItem = $user->wishlist()->where('product_id', $product->id)->exists();

        if ($wishlistItem) {
            // Remove from wishlist
            $user->wishlist()->detach($product->id);
            return response()->json(['success' => true, 'message' => 'Product removed from wishlist']);
        } else {
            // Add to wishlist
            $user->wishlist()->attach($product->id);
            return response()->json(['success' => true, 'message' => 'Product added to wishlist']);
        }
    }
}
