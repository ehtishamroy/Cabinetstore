<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductLine;
use App\Models\SubCategory;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of products
     */
    public function index()
    {
        $products = Product::with(['productLine.doorStyle', 'productLine.doorColor', 'subCategory', 'categories', 'subCategories.category'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product
     */
    public function create()
    {
        $productLines = ProductLine::with(['doorStyle', 'doorColor'])->get();
        $categories = Category::all();
        $subCategories = SubCategory::with('category')->get();
        return view('admin.products.create', compact('productLines', 'categories', 'subCategories'));
    }

    /**
     * Store a newly created product
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_line_id' => 'required|exists:product_lines,id',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'sub_categories' => 'required|array|min:1',
            'sub_categories.*' => 'exists:sub_categories,id',
            'sku' => 'required|string|max:255|unique:products',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'assembly_cost' => 'nullable|numeric|min:0',
            'hinge_type' => 'required|string|max:255',
            'is_modifiable' => 'boolean',
        ]);

        $product = Product::create([
            'product_line_id' => $request->product_line_id,
            'sub_category_id' => $request->sub_categories[0], // Keep the original relationship for backward compatibility
            'sku' => $request->sku,
            'name' => $request->name,
            'price' => $request->price,
            'assembly_cost' => $request->assembly_cost ?? 0,
            'hinge_type' => $request->hinge_type,
            'is_modifiable' => $request->boolean('is_modifiable'),
        ]);

        // Attach categories and sub-categories
        $product->categories()->attach($request->categories);
        $product->subCategories()->attach($request->sub_categories);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified product
     */
    public function show(Product $product)
    {
        $product->load(['productLine.doorStyle', 'productLine.doorColor', 'subCategory.category']);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product
     */
    public function edit(Product $product)
    {
        $productLines = ProductLine::with(['doorStyle', 'doorColor'])->get();
        $categories = Category::all();
        $subCategories = SubCategory::with('category')->get();
        return view('admin.products.edit', compact('product', 'productLines', 'categories', 'subCategories'));
    }

    /**
     * Duplicate the specified product
     */
    public function duplicate(Product $product)
    {
        // Create a new product with the same data
        $duplicate = $product->replicate();
        
        // Generate a unique SKU
        $baseSku = $product->sku;
        $counter = 1;
        $newSku = $baseSku . '-COPY';
        
        // Keep trying until we find a unique SKU
        while (Product::where('sku', $newSku)->exists()) {
            $newSku = $baseSku . '-COPY-' . $counter;
            $counter++;
        }
        
        $duplicate->sku = $newSku;
        $duplicate->name = $product->name . ' (Copy)';
        $duplicate->save();

        // Copy the relationships
        $duplicate->categories()->attach($product->categories->pluck('id')->toArray());
        $duplicate->subCategories()->attach($product->subCategories->pluck('id')->toArray());

        return redirect()->route('admin.products.index')
            ->with('success', 'Product duplicated successfully. Please update the SKU and name as needed.');
    }

    /**
     * Update the specified product
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_line_id' => 'required|exists:product_lines,id',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'sub_categories' => 'required|array|min:1',
            'sub_categories.*' => 'exists:sub_categories,id',
            'sku' => 'required|string|max:255|unique:products,sku,' . $product->id,
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'assembly_cost' => 'nullable|numeric|min:0',
            'hinge_type' => 'required|string|max:255',
            'is_modifiable' => 'boolean',
        ]);

        $product->update([
            'product_line_id' => $request->product_line_id,
            'sub_category_id' => $request->sub_categories[0], // Keep the original relationship for backward compatibility
            'sku' => $request->sku,
            'name' => $request->name,
            'price' => $request->price,
            'assembly_cost' => $request->assembly_cost ?? 0,
            'hinge_type' => $request->hinge_type,
            'is_modifiable' => $request->boolean('is_modifiable'),
        ]);

        // Sync categories and sub-categories
        $product->categories()->sync($request->categories);
        $product->subCategories()->sync($request->sub_categories);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified product
     */
    public function destroy(Product $product)
    {
        // Check if product has order items
        if ($product->orderItems()->count() > 0) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Cannot delete product. It has associated order items.');
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
