<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Str;

class PageBuilderController extends Controller
{

    public function index(Request $request)
    {
        $search = '';
        $query = Page::query();

        // Search functionality
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('title', 'like', '%' . $search . '%');
        }

        // Pagination with sorting
        $pages = $query->paginate(10); // Adjust the number per page as needed

        return view('admin.pages.index', compact('pages', 'search'));
    }

    public function create()
    {

        return view('admin.pages.create');
    }



    public function store(Request $request)
    {
        // Validate the basic page fields
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|unique:pages,slug|max:555',
            'description' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);

        // Generate a slug from the title if not provided
        $slug = $validated['slug'] ?? Str::slug($validated['title']);

        // Store the basic page data
        $page = new Page();
        $page->title = $validated['title'];
        $page->slug = strtolower(str_replace(' ', '-', $slug));
        $page->description = $validated['description'];
        $page->status = $validated['status'] ?? 0;

        // Prepare blocks data as JSON
        $blocks = [];

        if ($request->has('block_type')) {
            $blockTitles = $request->input('block_title', []);
            $blockDescriptions = $request->input('block_description', []);
            $blockLinks = $request->input('block_link', []);
            $blockTypes = $request->input('block_type', []);
            $blockImages = $request->file('block_image', []);
            $blockGalleries = $request->file('block_gallery', []);

            foreach ($blockTypes as $index => $type) {
                $blockId = Str::uuid();
                $blockData = [
                    'id' => $blockId,
                    'type' => $type,
                    'title' => $blockTitles[$index] ?? null,
                    'description' => $blockDescriptions[$index] ?? null,
                    'link' => $blockLinks[$index] ?? null,
                ];

                // Handle Image Block
                if ($type === 'image' && isset($blockImages[$index])) {
                    $path = $blockImages[$index]->store('block_images', 'public');
                    $blockData['image_path'] = $path;
                }

                // Handle Gallery Block
                if ($type === 'gallery' && isset($blockGalleries[$index])) {
                    $galleryPaths = [];
                    foreach ($blockGalleries[$index] as $galleryImage) {
                        $path = $galleryImage->store('block_gallery', 'public');
                        $galleryPaths[] = $path;
                    }
                    $blockData['gallery_paths'] = $galleryPaths;
                }

                // Handle Hero Section Block
                if ($type === 'hero-section') {
                    $blockData['hero_section_title'] = $request->input('hero_section_title')[$index] ?? null;
                    $blockData['hero_section_description'] = $request->input('hero_section_description')[$index] ?? null;

                    if ($request->hasFile("hero_section_image.$index")) {
                        $path = $request->file("hero_section_image.$index")->store('hero_section', 'public');
                        $blockData['hero_section_image'] = $path;
                    }
                }

                // Handle Split with Image Block
                if ($type === 'splitwithimage') {
                    $blockData['split_with_image_title'] = $request->input('split_with_image_title')[$index] ?? null;
                    $blockData['split_with_image_description'] = $request->input('split_with_image_description')[$index] ?? null;
                    $blockData['split_with_image_button_text'] = $request->input('split_with_image_button_text')[$index] ?? null;
                    $blockData['split_with_image_button_link'] = $request->input('split_with_image_button_link')[$index] ?? null;
                    $blockData['split_with_image_button_target'] = $request->input('split_with_image_button_target')[$index] ?? '_self';
                    $blockData['split_with_image_image_align'] = $request->input('split_with_image_image_align')[$index] ?? 'left';

                    if ($request->hasFile("split_with_image_image.$index")) {
                        $path = $request->file("split_with_image_image.$index")->store('split_with_image', 'public');
                        $blockData['split_with_image_image'] = $path;
                    }
                }

                // Handle Three Columns Block
                if ($type === 'threecolumns') {
                    $threeColumnItems = [];
                    if ($request->has("three_column_titles")) {
                        foreach ($request->input("three_column_titles") as $colIndex => $colTitle) {
                            $threeColumnItem = [
                                'id' => Str::uuid(),
                                'title' => $colTitle,
                                'description' => $request->input("three_column_descriptions")[$colIndex] ?? null,
                                'button_text' => $request->input("three_column_button_texts")[$colIndex] ?? null,
                                'button_link' => $request->input("three_column_links")[$colIndex] ?? null,
                                'target' => $request->input("three_column_targets")[$colIndex] ?? '_self',
                            ];

                            if ($request->hasFile("three_column_images.$colIndex")) {
                                $path = $request->file("three_column_images.$colIndex")->store('three_columns', 'public');
                                $threeColumnItem['image_path'] = $path;
                            }

                            $threeColumnItems[] = $threeColumnItem;
                        }
                    }
                    $blockData['three_column_items'] = $threeColumnItems;
                }

                $blocks[] = $blockData;
            }
        }

       // dd($blocks);
        $page->blocks = json_encode($blocks);
        $page->save();
        return redirect()->route('admin.pages.index')->with('success', 'Page created successfully!');
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|unique:pages,slug,' . $id . '|max:555',  // Ensure unique slug excluding current page
            'description' => 'nullable|string',
            'status' => 'nullable|boolean',
        ]);
        $page = Page::findOrFail($id);
        $slug = $validated['slug'] ?? Str::slug($validated['title']);
        $page->title = $validated['title'];
        $page->slug = strtolower(str_replace(' ', '-', $slug));
        $page->description = $validated['description'];
        $page->status = $validated['status'] ?? 0;
        $blocks = [];

        if ($request->has('block_type')) {
            $blockTitles = $request->input('block_title', []);
            $blockDescriptions = $request->input('block_description', []);
            $blockLinks = $request->input('block_link', []);
            $blockTypes = $request->input('block_type', []);
            $blockImages = $request->file('block_image', []);
            $blockGalleries = $request->file('block_gallery', []);

            foreach ($blockTypes as $index => $type) {
                $blockId = Str::uuid();
                $blockData = [
                    'id' => $blockId,
                    'type' => $type,
                    'title' => $blockTitles[$index] ?? null,
                    'description' => $blockDescriptions[$index] ?? null,
                    'link' => $blockLinks[$index] ?? null,
                ];

                // Handle Image Block
                if ($type === 'image') {
                    if (isset($blockImages[$index])) {
                        if (!empty($page->blocks[$index]['image_path'])) {
                            Storage::delete('public/' . $page->blocks[$index]['image_path']);
                        }
                        $path = $blockImages[$index]->store('block_images', 'public');
                        $blockData['image_path'] = $path;
                    } else {
                        $blockData['image_path'] = $page->blocks[$index]['image_path'] ?? null;
                    }
                }
                if ($type === 'gallery') {
                    if (isset($blockGalleries[$index])) {
                        $galleryPaths = [];
                        foreach ($blockGalleries[$index] as $galleryImage) {
                            $path = $galleryImage->store('block_gallery', 'public');
                            $galleryPaths[] = $path;
                        }
                        $blockData['gallery_paths'] = $galleryPaths;
                    } else {
                        $blockData['gallery_paths'] = $page->blocks[$index]['gallery_paths'] ?? [];
                    }
                }
                if ($type === 'hero-section') {
                    $blockData['hero_section_title'] = $request->input('hero_section_title')[$index] ?? null;
                    $blockData['hero_section_description'] = $request->input('hero_section_description')[$index] ?? null;

                    if ($request->hasFile("hero_section_image.$index")) {
                        $path = $request->file("hero_section_image.$index")->store('hero_section', 'public');
                        $blockData['hero_section_image'] = $path;
                    } else {
                        $blockData['hero_section_image'] = $page->blocks[$index]['hero_section_image'] ?? null;
                    }
                }
                if ($type === 'splitwithimage') {
                    $blockData['split_with_image_title'] = $request->input('split_with_image_title')[$index] ?? null;
                    $blockData['split_with_image_description'] = $request->input('split_with_image_description')[$index] ?? null;
                    $blockData['split_with_image_button_text'] = $request->input('split_with_image_button_text')[$index] ?? null;
                    $blockData['split_with_image_button_link'] = $request->input('split_with_image_button_link')[$index] ?? null;
                    $blockData['split_with_image_button_target'] = $request->input('split_with_image_button_target')[$index] ?? '_self';
                    $blockData['split_with_image_image_align'] = $request->input('split_with_image_image_align')[$index] ?? 'left';

                    if ($request->hasFile("split_with_image_image.$index")) {
                        $path = $request->file("split_with_image_image.$index")->store('split_with_image', 'public');
                        $blockData['split_with_image_image'] = $path;
                    } else {
                        $blockData['split_with_image_image'] = $page->blocks[$index]['split_with_image_image'] ?? null;
                    }
                }
                if ($type === 'threecolumns') {
                    $threeColumnItems = [];
                    if ($request->has("three_column_titles")) {
                        foreach ($request->input("three_column_titles") as $colIndex => $colTitle) {
                            $threeColumnItem = [
                                'id' => Str::uuid(),
                                'title' => $colTitle,
                                'description' => $request->input("three_column_descriptions")[$colIndex] ?? null,
                                'button_text' => $request->input("three_column_button_texts")[$colIndex] ?? null,
                                'button_link' => $request->input("three_column_links")[$colIndex] ?? null,
                                'target' => $request->input("three_column_targets")[$colIndex] ?? '_self',
                            ];

                            if ($request->hasFile("three_column_images.$colIndex")) {
                                $path = $request->file("three_column_images.$colIndex")->store('three_columns', 'public');
                                $threeColumnItem['image_path'] = $path;
                            } else {
                                $threeColumnItem['image_path'] = $page->blocks[$index]['three_column_items'][$colIndex]['image_path'] ?? null;
                            }

                            $threeColumnItems[] = $threeColumnItem;
                        }
                    }
                    $blockData['three_column_items'] = $threeColumnItems;
                }

                $blocks[] = $blockData;
            }
        }
        ($blocks);
       // dd($blocks);

        $page->blocks = json_encode($blocks);
        $page->save();
        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully!');
    }



    public function edit($id)
    {
        // Retrieve the page record by ID
        $page = Page::findOrFail($id);

        // Pass the page to the edit view
        return view('admin.pages.edit', compact('page'));
    }

    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();
        return redirect()->route('admin.pages.index')->with('success', 'Page Deleted Successful');
    }
    public function updateStatus(Request $request)
    {
        $page = Page::find($request->id);
        if ($page) {
            $page->status = $request->status;
            $page->save();

            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false]);
    }

    public function show($id)
    {
        // Fetch the page from the database
        $page = Page::findOrFail($id);

        // Decode the blocks JSON data
        $blocks = json_decode($page->blocks, true);

        // Pass the data to the view
        return view('admin.pages.show', compact('page', 'blocks'));
    }
}
