<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Menu;
use App\Models\Product;

class GlobalController extends Controller
{
    public function productDetails($id)
    {
        $product = Product::with('images')->findOrFail($id);
        return view('frontend.pages.productdetails', compact( 'product',));
    }
}
