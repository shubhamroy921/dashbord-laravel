<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class SubCategoryController extends Controller
{
    public function index(Request $request, Category $category)
    {
        $search = $request->input('search', '');

        // Filter by category_id in addition to search term
        $subcategory = SubCategory::where('category_id', $category->id)
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('url', 'like', "%{$search}%");
            })
            ->orderBy('sort')
            ->paginate(20);

        return view('admin.products.category.sub-category.index', compact('category', 'subcategory', 'search'));
    }



    public function create(Category $category)
    {
        return view('admin.products.category.sub-category.create', compact('category'));
    }
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'url' => 'required|string|unique:sub_categories,url|max:255',
            'sort' => 'nullable|integer|min:0',
            'status' => 'nullable|boolean',
        ]);

        try {
            // Create the subcategory
            SubCategory::create([
                'category_id' => $validatedData['category_id'],
                'name' => $validatedData['name'],
                'url' => $validatedData['url'],
                'sort' => $validatedData['sort'] ?? 0, // Default to 0 if not provided
                'status' => $validatedData['status'] ?? 0, // Default to inactive if not provided
            ]);

            // Find the category using the category_id
            $category = Category::findOrFail($validatedData['category_id']);
            // Redirect back with a success message
            return redirect()
                ->route('admin.subcategory.index', ['category' => $category])
                ->with('success', 'Subcategory added successfully.');
        } catch (\Exception $e) {
            // Handle exceptions and return an error message
            return redirect()
                ->back()
                ->with('error', 'An error occurred while adding the subcategory: ' . $e->getMessage())
                ->withInput();
        }
    }
    // public function edit(Category $category, SubCategory $subcategory)
    // {
    //     return view('admin.products.category.sub-category.edit', compact('subcategory', 'category'));
    // }

    public function edit(Category $category, SubCategory $subcategory)
    {
        $allCategories = Category::all(); // Adjust this as per your model structure
        return view('admin.products.category.sub-category.edit', [
            'subcategory' => $subcategory,  
            'category' => $category,
            'allCategories' => $allCategories,
        ]);
    }



    public function update(Request $request, SubCategory $subcategory)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'url' => 'required|string|max:255|unique:sub_categories,url,' . $subcategory->id,
            'sort' => 'nullable|integer|min:0',
            'status' => 'nullable|boolean',
        ]);

        try {
            // Update the subcategory
            $subcategory->update([
                'name' => $validatedData['name'],
                'url' => $validatedData['url'],
                'sort' => $validatedData['sort'] ?? 0, // Default to 0 if not provided
                'status' => $validatedData['status'] ?? 0, // Default to inactive if not provided
            ]);

            // Find the category using the category_id
            $category = Category::findOrFail($subcategory->category_id);
            // Redirect back with a success message
            return redirect()
                ->route('admin.subcategory.index', ['category' => $category])
                ->with('success', 'Subcategory updated successfully.');
        } catch (\Exception $e) {
            // Handle exceptions and return an error message
            return redirect()
                ->back()
                ->with('error', 'An error occurred while updating the subcategory: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(SubCategory $subcategory)
    {
        try {
            // Delete the subcategory
            $subcategory->delete();

            // Redirect back with a success message
            return redirect()
                ->back()
                ->with('success', 'Subcategory deleted successfully.');
        } catch (\Exception $e) {
            // Handle exceptions and return an error message
            return redirect()
                ->back()
                ->with('error', 'An error occurred while deleting the subcategory: ' . $e->getMessage());
        }
    }


    public function updateStatus(Request $request)
    {
        $subcategory = SubCategory::find($request->id);

        if ($subcategory) {
            $subcategory->status = $request->status;
            $subcategory->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
    public function reorder(Request $request)
    {
        $order = $request->input('order');

        foreach ($order as $item) {
            $subcategory = SubCategory::find($item['id']);
            $subcategory->sort = $item['sort']; // Make sure you have a 'position' field in your products table
            $subcategory->save();
        }

        return response()->json(['success' => true]);
    }


}
