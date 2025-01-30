<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Auth\InfoUserController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetController;
use App\Http\Controllers\Auth\SessionsController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\GlobalController;
use App\Http\Controllers\Frontend\NewsletterController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', [HomeController::class, 'home']);
Route::post('/newsletter/subscribe', [NewsletterController::class, 'storeEmail'])->name('newsletter.subscribe');
Route::get('product/{id}', [GlobalController::class, 'productDetails'])->name('product.name');

Route::get('/pages/{slug}', [HomeController::class, 'showFrontend'])->name('showFrontend.page');


//PAYMENT FORM
Route::get('payment', [\App\Http\Controllers\PaymentController::class, 'index'])->name('payment');
Route::post('pay-now', [\App\Http\Controllers\PaymentController::class, 'submitPaymentForm'])->name('pay-with-phonepe');
Route::get('confirm', [\App\Http\Controllers\PaymentController::class, 'confirmPayment'])->name('confirm');


# User Auth
Route::post('/add-to-cart/{productId}', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart/count', [CartController::class, 'getCartCount'])->name('cart.count');
Route::post('/wishlist/add/{productId}', [WishlistController::class, 'addToWishlist']);
Route::get('/wishlist/items', [WishlistController::class, 'getWishlistItems'])->name('wishlist.items');
Route::post('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');
Route::post('/wishlist/toggle/{productId}', [WishlistController::class, 'toggleWishlist'])->name('wishlist.toggle');
Route::get('cart/items', [CartController::class, 'getCartItems']);
Route::delete('/cart/items/{id}', [CartController::class, 'removeCartItem']);
Route::post('/checkout', [CartController::class, 'proceedToCheckout'])->name('checkout');
// Route::post('/payment/callback', [CartController::class, 'paymentCallback'])->name('payment.callback');

Route::any('/phonepe/callback', 'CartController@paymentCallback')->name('payment.callback');
Route::post('/payment/callback', [CartController::class, 'paymentCallback'])->name('payment.callback');
Route::get('shopping/cart', [CartController::class, 'showData'])->name('cart.showData');

Route::post('/cart/increment/{cartId}', [CartController::class, 'incrementQuantity'])->name('cart.increment');
Route::post('/cart/decrement/{cartId}', [CartController::class, 'decrementQuantity'])->name('cart.decrement');

Route::middleware('auth')->get('/cart', [CartController::class, 'showCart'])->name('cart.show');

Route::get('/order/success', function () {
    return view('frontend.pages.order-success');
})->name('order.success');


Route::group(['middleware' => 'admin'], function () {

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('profile', function () {
        return view('profile');
    })->name('profile');



    Route::get('tables', function () {
        return view('tables');
    })->name('tables');


    Route::get('/logout', [SessionsController::class, 'destroy']);
    Route::get('/user-profile', [InfoUserController::class, 'create']);
    Route::post('/user-profile', [InfoUserController::class, 'store']);
    Route::get('/login', function () {
        return view('dashboard');
    })->name('sign-up');
});



Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [SessionsController::class, 'create']);
    Route::post('/session', [SessionsController::class, 'store']);
    Route::get('/login/forgot-password', [ResetController::class, 'create']);
    Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
    Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
    Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');
});



Route::get('/login', function () {
    if (Auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('session/login-session');
})->name('login');
