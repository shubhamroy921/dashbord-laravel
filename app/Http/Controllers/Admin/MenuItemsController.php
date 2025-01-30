<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItems;
use Illuminate\Http\Request;

class MenuItemsController extends Controller
{
    public function index(Request $request, Menu $menu)
    {
        $search = $request->input('search', '');

        // Filter by category_id in addition to search term
        $menuitems = MenuItems::where('menu_id', $menu->id)
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhere('link', 'like', "%{$search}%");
            })
            ->orderBy('sort')
            ->paginate(20);


        return view('admin.menu.menuitems.index', compact('menu', 'menuitems', 'search'));
    }
    public function create(Menu $menu)
    {
        return view('admin.menu.menuitems.create', compact('menu'));
    }
    public function store(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'menu_id' => 'required',
            'name' => 'required',
            'link' => 'nullable',
            'sort' => 'nullable|numeric',
            'status' => 'required|boolean',
        ]);

        // Create a new MenuItems instance and save it
        $menuitems = new MenuItems();
        $menuitems->menu_id = $validatedData['menu_id'];
        $menuitems->name = $validatedData['name'];
        $menuitems->link = $validatedData['link'];
        $menuitems->sort = $validatedData['sort'];
        $menuitems->status = $validatedData['status'];
        $menuitems->save();

        // Find the related menu
        $menu = Menu::findOrFail($validatedData['menu_id']);

        // Redirect with success message
        return redirect()->route('admin.menuitems.index', ['menu' => $menu])
            ->with('success', 'Items created successfully');
    }


    public function edit(Menu $menu, MenuItems $menuitems)
    {
        return view('admin.menu.menuitems.edit', compact('menu', 'menuitems'));
    }

    public function update(Request $request, MenuItems $menuitems)
    {
        $request->validate([
            'name' => 'required',
            'link' => 'nullable',
            'sort' => 'nullable|numeric',
            'status' => 'required|boolean',
        ]);

        $menuitems->name = $request->name;
        $menuitems->link = $request->link;
        $menuitems->sort = $request->sort;
        $menuitems->status = $request->status;
        $menuitems->save();

        // Find the category using the category_id
        $menu = Menu::findOrFail($menuitems->menu_id);

        return redirect()->route('admin.menuitems.index', ['menu' => $menu])->with('success', 'Items updated successfully');
    }

    public function destroy(MenuItems $menuitems)
    {
        $menuitems->delete();

        return redirect()->back()->with('success', 'Items deleted successfully');
    }

    // public function reorder(Request $request)

    public function reorder(Request $request)
    {
        $order = $request->input('order');

        foreach ($order as $item) {
            $menuitems = MenuItems::find($item['id']);
            $menuitems->sort = $item['sort']; // Make sure you have a 'position' field in your products table
            $menuitems->save();
        }

        return response()->json(['success' => true]);
    }

    public function updateStatus(Request $request)
    {
        $menuitems = MenuItems::find($request->id);

        if ($menuitems) {
            $menuitems->status = $request->status;
            $menuitems->save();

            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}
