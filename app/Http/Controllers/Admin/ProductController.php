<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the students.
     */
    public function index(Request $request)
    {
        $products = Product::orderBy('sort')->paginate(20);
        return view('admin.products.index', compact('products'));
    }
    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $productCategory = Category::where('status', 1)->get();
        return view('admin.products.create', compact('productCategory')); // Return a view to create a
    }

    /**

     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'sort' => 'nullable|integer',
            'status' => 'boolean',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:6048',
            'image_alts' => 'array',
            'image_alts.*' => 'nullable|string|max:255',
            'sell_price' => 'required|numeric',
            'discount_price' => 'nullable|numeric',
            'slug' => 'nullable|string|unique:products,slug',
        ]);

        // Generate slug if not provided
        $slug = $request->input('slug');
        if (!$slug) {
            $slug = Str::slug($request->input('title'));
            // Ensure the slug is unique
            $count = Product::where('slug', 'LIKE', "{$slug}%")->count();
            $slug = $count ? "{$slug}-{$count}" : $slug;
        }

        $product = new Product($request->except('images', 'image_alts'));
        $product->slug = $slug;
        $product->save();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                $alt = $request->image_alts[$index] ?? null;
                $product->images()->create(['path' => $path, 'alt' => $alt]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }




    /**
     * Display the specified product.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id); // Fetch specific product
        return view('admin.products.show', compact('product')); // Return a view with product data
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id); // Fetch specific product to edit
        $productCategory = Category::where('status', 1)->get();
        return view('admin.products.edit', compact('product', 'productCategory')); // Return a view to edit product
    }

    /**
     * Update the specified product in storage.
     */ public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'sort' => 'nullable|integer',
            'status' => 'boolean',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:6048',
            'image_alts' => 'array',
            'image_alts.*' => 'nullable|string|max:255',
            'sell_price' => 'required|numeric',
            'discount_price' => 'nullable|numeric',
            'slug' => 'nullable|string|unique:products,slug,' . $id,
        ]);

        $product = Product::findOrFail($id);

        // Generate slug if not provided
        $slug = $request->input('slug');
        if (!$slug) {
            $slug = Str::slug($request->input('title'));
            // Ensure the slug is unique
            $count = Product::where('slug', 'LIKE', "{$slug}%")->where('id', '<>', $id)->count();
            $slug = $count ? "{$slug}-{$count}" : $slug;
        }

        $product->fill($request->except('images', 'image_alts'));
        $product->slug = $slug;
        $product->save();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'public');
                $alt = $request->image_alts[$index] ?? null;
                $product->images()->create(['path' => $path, 'alt' => $alt]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }



    /**
     * Remove the specified product from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    public function reorder(Request $request)
    {
        $order = $request->input('order');

        foreach ($order as $item) {
            $product = Product::find($item['id']);
            $product->sort = $item['sort']; // Make sure you have a 'position' field in your products table
            $product->save();
        }

        return response()->json(['success' => true]);
    }

    public function updateStatus(Request $request)
    {
        $product = Product::find($request->id);

        if ($product) {
            $product->status = $request->status;
            $product->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}
