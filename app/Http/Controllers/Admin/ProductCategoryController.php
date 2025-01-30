<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class ProductCategoryController extends Controller
{
    public function index(Request $request)
    {
        // Check if a search term exists
        $search = $request->input('search');
        $categories = Category::when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%');
        })->orderBy('sort')->paginate(10);

        // Return view with the filtered categories
        return view('admin.products.category.index', compact('categories', 'search'));
    }


    public function create()
    {
        return view('admin.products.category.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:6048',
            'name' => 'required|nullable',
            'status' => 'nullable|in:0,1',
            'sort' => 'nullable|numeric',
        ]);

        try {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('categories', 'public');
            }
            $category = new Category();
            $category->name = $request->input('name');
            $category->sort = $request->input('sort');
            $category->image = $imagePath;
            $category->status = $request->input('status', 0);
            $category->save();

            return redirect()->route('admin.categories.index')->with('success', 'Category added successfully!');
        } catch (\Exception $e) {
            \Log::error('Category Store Error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return redirect()->route('admin.categories.index')->with('error', 'Category not found.');
        }

        return view('admin.products.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:6048',
            'name' => 'required|string|max:100',
            'status' => 'nullable|boolean',
            'sort' => 'nullable|numeric',
        ]);

        $category = Category::find($id);

        if (!$category) {
            return redirect()->route('admin.categories.index')->with('error', 'Category not found.');
        }

        try {
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('categories', 'public');
                $category->image = $imagePath;
            }

            $category->update([
                'name' => $request->name,
                'status' => $request->status,
                'sort' => $request->sort,
            ]);

            return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully!');
        } catch (\Exception $e) {
            \Log::error('Category Update Error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return redirect()->route('admin.categories.index')->with('error', 'Category not found.');
        }

        try {
            // Check if the category has an image and if the image exists
            if ($category->image && File::exists(public_path('storage/' . $category->image))) {
                // Delete the image file
                File::delete(public_path('storage/' . $category->image));
            }

            // Delete the category from the database
            $category->delete();

            return redirect()->route('admin.categories.index')->with('success', 'Category and its image deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Category Delete Error: ' . $e->getMessage());
            return back()->with('error', 'An error occurred: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request)
    {
        $categories = Category::find($request->id);

        if ($categories) {
            $categories->status = $request->status;
            $categories->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    public function reorder(Request $request)
    {
        $order = $request->input('order');

        foreach ($order as $item) {
            $categories = Category::find($item['id']);
            $categories->sort = $item['sort']; // Make sure you have a 'position' field in your products table
            $categories->save();
        }

        return response()->json(['success' => true]);
    }

}
