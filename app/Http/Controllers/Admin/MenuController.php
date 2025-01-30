<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $search = '';
        $query = Menu::query();

        // Search functionality
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Pagination with sorting
        $menus = $query->orderBy('sort')->paginate(10); // Adjust the number per page as needed

        return view('admin.menu.index', compact('menus', 'search'));
    }


    public function create()
    {
        return view('admin.menu.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'link' => 'nullable',
            'sort' => 'nullable|numeric',
            'status' => 'required|boolean',
        ]);

        $menu = new Menu();
        $menu->name = $request->name;
        $menu->link = $request->link;
        $menu->sort = $request->sort;
        $menu->status = $request->status;
        $menu->save();

        return redirect()->route('admin.menu.index')->with('success', 'Menu created successfully');
    }

    public function edit(Menu $menu)
    {
        return view('admin.menu.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        $request->validate([
            'name' => 'required',
            'link' => 'nullable',
            'sort' => 'nullable|numeric',
            'status' => 'required|boolean',
        ]);

        $menu->name = $request->name;
        $menu->link = $request->link;
        $menu->sort = $request->sort;
        $menu->status = $request->status;
        $menu->save();

        return redirect()->route('admin.menu.index')->with('success', 'Menu updated successfully');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('admin.menu.index')->with('success', 'Menu deleted successfully.');
    }



    public function reorder(Request $request)
    {
        $order = $request->input('order');

        foreach ($order as $item) {
            $categories = Menu::find($item['id']);
            $categories->sort = $item['sort']; // Make sure you have a 'position' field in your products table
            $categories->save();
        }

        return response()->json(['success' => true]);
    }




    public function updateStatus(Request $request)
    {
        $menu = Menu::find($request->id);
        $menu->status = $request->status;
        $menu->save();

        return response()->json(['success' => true]);
    }
}
