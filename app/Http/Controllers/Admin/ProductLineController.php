<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductLine;
use App\Models\DoorStyle;
use App\Models\DoorColor;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductLineController extends Controller
{
    /**
     * Display a listing of product lines
     */
    public function index()
    {
        $productLines = ProductLine::with(['doorStyle', 'doorColor', 'categories'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('admin.product-lines.index', compact('productLines'));
    }

    /**
     * Show the form for creating a new product line
     */
    public function create()
    {
        $doorStyles = DoorStyle::orderBy('name')->get();
        $doorColors = DoorColor::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        return view('admin.product-lines.create', compact('doorStyles', 'doorColors', 'categories'));
    }

    /**
     * Store a newly created product line
     */
    public function store(Request $request)
    {
        $request->validate([
            'door_style_id' => 'required|exists:door_styles,id',
            'door_color_id' => 'required|exists:door_colors,id',
            'categories' => 'array',
            'categories.*' => 'exists:categories,id',
        ]);

        $productLine = ProductLine::create([
            'door_style_id' => $request->door_style_id,
            'door_color_id' => $request->door_color_id,
        ]);

        if ($request->has('categories')) {
            $productLine->categories()->attach($request->categories);
        }

        return redirect()->route('admin.product-lines.index')
            ->with('success', 'Product line created successfully.');
    }

    /**
     * Display the specified product line
     */
    public function show(ProductLine $productLine)
    {
        $productLine->load(['doorStyle', 'doorColor', 'categories', 'products']);
        return view('admin.product-lines.show', compact('productLine'));
    }

    /**
     * Show the form for editing the specified product line
     */
    public function edit(ProductLine $productLine)
    {
        $doorStyles = DoorStyle::orderBy('name')->get();
        $doorColors = DoorColor::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $productLine->load('categories');
        return view('admin.product-lines.edit', compact('productLine', 'doorStyles', 'doorColors', 'categories'));
    }

    /**
     * Update the specified product line
     */
    public function update(Request $request, ProductLine $productLine)
    {
        $request->validate([
            'door_style_id' => 'required|exists:door_styles,id',
            'door_color_id' => 'required|exists:door_colors,id',
            'categories' => 'array',
            'categories.*' => 'exists:categories,id',
        ]);

        $productLine->update([
            'door_style_id' => $request->door_style_id,
            'door_color_id' => $request->door_color_id,
        ]);

        $productLine->categories()->sync($request->categories ?? []);

        return redirect()->route('admin.product-lines.index')
            ->with('success', 'Product line updated successfully.');
    }

    /**
     * Remove the specified product line
     */
    public function destroy(ProductLine $productLine)
    {
        // Check if product line has products
        if ($productLine->products()->count() > 0) {
            return redirect()->route('admin.product-lines.index')
                ->with('error', 'Cannot delete product line. It has associated products.');
        }

        $productLine->delete();

        return redirect()->route('admin.product-lines.index')
            ->with('success', 'Product line deleted successfully.');
    }
}
