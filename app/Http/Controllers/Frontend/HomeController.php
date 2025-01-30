<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function home()
    {
        $products = Product::where('status', 1)
            ->with('category', 'images')
            ->orderBy('sort', 'asc')
            ->get();

        // If the user is logged in, get their wishlist
        $wishlistProductIds = [];
        if (Auth::check()) {
            $wishlistProductIds = Wishlist::where('user_id', Auth::id())->pluck('product_id')->toArray();
        }
        $pages = Page::where('status', 1)->get();

        return view('frontend.pages.home', compact('products','wishlistProductIds','pages'));
    }
    public function showFrontend($slug)
    {
        // Find the page by slug or fail if not found
        $page = Page::where('slug', $slug)->firstOrFail();

        // Decode the blocks JSON into an array, defaulting to an empty array if empty
        $blocks = json_decode($page->blocks, true) ?? [];

        // Return the view with the page and blocks data
        return view('frontend.pages.pages', compact('page', 'blocks'));
    }

}
