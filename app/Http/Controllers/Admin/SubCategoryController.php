<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of sub categories
     */
    public function index()
    {
        $subCategories = SubCategory::with(['category'])->orderBy('name')->paginate(10);
        return view('admin.sub-categories.index', compact('subCategories'));
    }

    /**
     * Show the form for creating a new sub category
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.sub-categories.create', compact('categories'));
    }

    /**
     * Store a newly created sub category
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'image_url' => 'nullable|string|max:500',
        ]);

        SubCategory::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'image_url' => $request->image_url,
        ]);

        return redirect()->route('admin.sub-categories.index')
            ->with('success', 'Sub category created successfully.');
    }

    /**
     * Display the specified sub category
     */
    public function show(SubCategory $subCategory)
    {
        $subCategory->load(['category', 'products']);
        return view('admin.sub-categories.show', compact('subCategory'));
    }

    /**
     * Show the form for editing the specified sub category
     */
    public function edit(SubCategory $subCategory)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.sub-categories.edit', compact('subCategory', 'categories'));
    }

    /**
     * Update the specified sub category
     */
    public function update(Request $request, SubCategory $subCategory)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'image_url' => 'nullable|string|max:500',
        ]);

        $subCategory->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'image_url' => $request->image_url,
        ]);

        return redirect()->route('admin.sub-categories.index')
            ->with('success', 'Sub category updated successfully.');
    }

    /**
     * Remove the specified sub category
     */
    public function destroy(SubCategory $subCategory)
    {
        // Check if sub category has products
        if ($subCategory->products()->count() > 0) {
            return redirect()->route('admin.sub-categories.index')
                ->with('error', 'Cannot delete sub category. It has associated products.');
        }

        $subCategory->delete();

        return redirect()->route('admin.sub-categories.index')
            ->with('success', 'Sub category deleted successfully.');
    }
}
