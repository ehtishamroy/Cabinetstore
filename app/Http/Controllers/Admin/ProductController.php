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
        
        // Get all categories that are related to any product line
        $categories = Category::whereHas('productLines')->get();
        
        // Get all subcategories that are related to any product line
        $subCategories = SubCategory::whereHas('category.productLines')->with('category')->get();
        
        return view('admin.products.create', compact('productLines', 'categories', 'subCategories'));
    }

    /**
     * Store a newly created product
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_line_id' => 'required|exists:product_lines,id',
            'category_id' => 'required|exists:categories,id',
            'sub_categories' => 'required|array|min:1',
            'sub_categories.*' => 'exists:sub_categories,id',
            'sku' => 'required|string|max:255|unique:products',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'labor_cost' => 'nullable|numeric|min:0',
            'hinge_type' => 'required|string|max:255',
            'is_modifiable' => 'boolean',
        ]);

        $product = Product::create([
            'product_line_id' => $request->product_line_id,
            'sub_category_id' => $request->sub_categories[0], // Keep the original relationship for backward compatibility
            'sku' => $request->sku,
            'name' => $request->name,
            'price' => $request->price,
            'labor_cost' => $request->has('labor_cost') ? $request->labor_cost : 30,
            'hinge_type' => $request->hinge_type,
            'is_modifiable' => $request->boolean('is_modifiable'),
        ]);

        // Attach single category and sub-categories
        $product->categories()->attach([$request->category_id]);
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
        
        // Get all categories that are related to any product line
        $categories = Category::whereHas('productLines')->get();
        
        // Get all subcategories that are related to any product line
        $subCategories = SubCategory::whereHas('category.productLines')->with('category')->get();
        
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
            'category_id' => 'required|exists:categories,id',
            'sub_categories' => 'required|array|min:1',
            'sub_categories.*' => 'exists:sub_categories,id',
            'sku' => 'required|string|max:255|unique:products,sku,' . $product->id,
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'labor_cost' => 'nullable|numeric|min:0',
            'hinge_type' => 'required|string|max:255',
            'is_modifiable' => 'boolean',
        ]);

        $product->update([
            'product_line_id' => $request->product_line_id,
            'sub_category_id' => $request->sub_categories[0], // Keep the original relationship for backward compatibility
            'sku' => $request->sku,
            'name' => $request->name,
            'price' => $request->price,
            'labor_cost' => $request->has('labor_cost') ? $request->labor_cost : 30,
            'hinge_type' => $request->hinge_type,
            'is_modifiable' => $request->boolean('is_modifiable'),
        ]);

        // Sync single category and sub-categories
        $product->categories()->sync([$request->category_id]);
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

    /**
     * Get categories for a specific product line (AJAX)
     */
    public function getCategoriesForProductLine(ProductLine $productLine)
    {
        $categories = $productLine->categories()->with('subCategories')->get();
        
        return response()->json([
            'categories' => $categories->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'sub_categories' => $category->subCategories->map(function ($subCategory) {
                        return [
                            'id' => $subCategory->id,
                            'name' => $subCategory->name,
                            'category_id' => $subCategory->category_id,
                        ];
                    })
                ];
            })
        ]);
    }

    /**
     * Get products for a specific category (AJAX)
     */
    public function getProductsByCategory($categoryId)
    {
        $products = Product::whereHas('categories', function ($query) use ($categoryId) {
            $query->where('categories.id', $categoryId);
        })->with(['productLine.doorStyle', 'productLine.doorColor'])->get();
        
        return response()->json([
            'products' => $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'stock' => 'In Stock', // You can add stock logic later
                    'unitPrice' => (float) $product->price,
                    'laborCost' => (float) ($product->labor_cost ?? 30),
                    'hingeOptions' => $this->parseHingeType($product->hinge_type),
                    'modifications' => (bool) $product->is_modifiable,
                ];
            })
        ]);
    }

    /**
     * Get products for a specific subcategory (AJAX)
     */
    public function getProductsBySubcategory($subcategoryId)
    {
        $products = Product::whereHas('subCategories', function ($query) use ($subcategoryId) {
            $query->where('sub_categories.id', $subcategoryId);
        })->with(['productLine.doorStyle', 'productLine.doorColor'])->get();
        
        return response()->json([
            'products' => $products->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'stock' => 'In Stock', // You can add stock logic later
                    'unitPrice' => (float) $product->price,
                    'laborCost' => (float) ($product->labor_cost ?? 30),
                    'hingeOptions' => $this->parseHingeType($product->hinge_type),
                    'modifications' => (bool) $product->is_modifiable,
                ];
            })
        ]);
    }

    /**
     * Parse hinge type string into array format
     */
    private function parseHingeType($hingeType)
    {
        if (empty($hingeType)) {
            return ['N/A'];
        }
        
        $hingeType = strtoupper(trim($hingeType));
        
        if ($hingeType === 'BOTH') {
            return ['L', 'R'];
        }
        
        if (strpos($hingeType, ',') !== false) {
            return array_map('trim', explode(',', $hingeType));
        }
        
        if (strpos($hingeType, '/') !== false) {
            return array_map('trim', explode('/', $hingeType));
        }
        
        return [$hingeType];
    }
}
