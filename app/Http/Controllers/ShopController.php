<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\DoorStyle;
use App\Models\DoorColor;
use App\Models\ProductLine;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Display the shop page with door styles and colors
     */
    public function index(Request $request)
    {
        // Get all door styles (including those without product lines) with image URLs
        $doorStyles = DoorStyle::orderBy('name')->get()->map(function ($style) {
            return [
                'id' => $style->id,
                'name' => $style->name,
                'image_url' => $this->getDoorStyleImageUrl($style),
            ];
        });
        
        // Get door colors grouped by door style for the color view
        $doorColorsByStyle = [];
        foreach ($doorStyles as $doorStyle) {
            // Get only colors that are actually related to this door style through ProductLine
            $colors = ProductLine::where('door_style_id', $doorStyle['id'])
                ->with(['doorColor', 'doorStyle'])
                ->get()
                ->map(function ($productLine) {
                    // Generate proper image URL for door colors
                    $imageUrl = $this->getDoorColorImageUrl($productLine->doorColor);
                    
                    return [
                        'id' => $productLine->doorColor->id,
                        'name' => $productLine->doorColor->name,
                        'image_url' => $imageUrl,
                        'door_style' => $productLine->doorStyle->name,
                        'door_style_id' => $productLine->doorStyle->id,
                        'door_color_id' => $productLine->doorColor->id,
                        'product_line_id' => $productLine->id,
                        'slug' => $this->generateSlug($productLine->doorColor->name),
                    ];
                });
            $doorColorsByStyle[$doorStyle['name']] = $colors;
        }

        return view('shop', compact('doorStyles', 'doorColorsByStyle'));
    }

    /**
     * Get door colors for selected door style (AJAX endpoint)
     */
    public function getDoorColors(Request $request)
    {
        $selectedDoorStyle = $request->input('door_style');
        
        if (!$selectedDoorStyle) {
            return response()->json([]);
        }

        $doorStyle = DoorStyle::where('name', $selectedDoorStyle)->first();
        
        if (!$doorStyle) {
            return response()->json([]);
        }

        // Get only colors that are actually related to this door style through ProductLine
        $doorColors = ProductLine::where('door_style_id', $doorStyle->id)
            ->with(['doorColor', 'doorStyle'])
            ->get()
            ->map(function ($productLine) {
                // Generate proper image URL for door colors
                $imageUrl = $this->getDoorColorImageUrl($productLine->doorColor);
                
                return [
                    'id' => $productLine->doorColor->id,
                    'name' => $productLine->doorColor->name,
                    'image_url' => $imageUrl,
                    'door_style' => $productLine->doorStyle->name,
                    'door_style_id' => $productLine->doorStyle->id,
                    'door_color_id' => $productLine->doorColor->id,
                    'product_line_id' => $productLine->id,
                    'slug' => $this->generateSlug($productLine->doorColor->name),
                ];
            });

        return response()->json($doorColors);
    }

    /**
     * Get all door styles that have associated colors (AJAX endpoint)
     */
    public function getDoorStyles()
    {
        $doorStyles = DoorStyle::orderBy('name')
            ->get()
            ->map(function ($style) {
                // Count how many colors are available for this style
                $colorCount = ProductLine::where('door_style_id', $style->id)->count();
                
                return [
                    'id' => $style->id,
                    'name' => $style->name,
                    'image_url' => $this->getDoorStyleImageUrl($style),
                    'color_count' => $colorCount,
                ];
            });

        return response()->json($doorStyles);
    }

    /**
     * Display the product page for a specific door color
     */
    public function showProduct($doorColorId, $slug = null)
    {
        $doorColor = DoorColor::findOrFail($doorColorId);
        
        // Generate the expected slug for this door color
        $expectedSlug = $this->generateSlug($doorColor->name);
        
        // If a slug was provided but doesn't match, redirect to the correct URL
        if ($slug && $slug !== $expectedSlug) {
            return redirect()->route('product.show', [
                'doorColorId' => $doorColorId,
                'slug' => $expectedSlug
            ]);
        }
        
        // Get the first product line for this door color (for basic info)
        $productLine = ProductLine::where('door_color_id', $doorColorId)
            ->with(['doorStyle', 'categories'])
            ->first();
        
        if (!$productLine) {
            abort(404, 'Product not found');
        }
        
        // Get all product lines for this door color (for variants if needed)
        $allProductLines = ProductLine::where('door_color_id', $doorColorId)
            ->with(['doorStyle', 'categories'])
            ->get();
        
        // Get categories that are actually related to this door color through ProductLine
        $relatedCategories = $allProductLines->flatMap(function ($productLine) {
            return $productLine->categories;
        })->unique('id');
        
        // Get all subcategories for these related categories
        $categories = $relatedCategories->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
                'image_url' => $this->getCategoryImageUrl($category),
                'sub_categories' => $category->subCategories->map(function ($subCategory) {
                    return [
                        'id' => $subCategory->id,
                        'name' => $subCategory->name,
                        'image_url' => $this->getSubCategoryImageUrl($subCategory),
                    ];
                })->toArray(),
            ];
        });
        
        // Add image URLs to the door color
        $doorColor->image_url = $this->getDoorColorImageUrl($doorColor);
        $doorColor->main_image_url = $this->getDoorColorMainImageUrl($doorColor);
        $doorColor->gallery_images_urls = $this->getDoorColorGalleryImageUrls($doorColor);
        
        return view('product', compact('doorColor', 'productLine', 'allProductLines', 'categories'));
    }

    /**
     * Generate SEO-friendly slug from door color name
     */
    private function generateSlug($name)
    {
        // Convert to lowercase and replace spaces with hyphens
        $slug = strtolower(trim($name));
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/[\s-]+/', '-', $slug);
        $slug = trim($slug, '-');
        
        return $slug;
    }

    /**
     * Generate product URL with slug
     */
    public function generateProductUrl($doorColorId, $doorColorName)
    {
        $slug = $this->generateSlug($doorColorName);
        return route('product.show', ['doorColorId' => $doorColorId, 'slug' => $slug]);
    }

    /**
     * Generate proper image URL for door colors
     */
    private function getDoorColorImageUrl($doorColor)
    {
        if ($doorColor->image) {
            // Check if the image file exists in public/uploads directory
            $imagePath = public_path('uploads/door-colors/' . basename($doorColor->image));
            if (file_exists($imagePath)) {
                // Use rawurlencode for better URL handling of spaces and special characters
                return asset('uploads/door-colors/' . rawurlencode(basename($doorColor->image)));
            }
        }
        
        // Fallback to placeholder with color name
        return 'https://placehold.co/400x400/EAEAEA/333?text=' . urlencode($doorColor->name);
    }

    /**
     * Generate proper image URL for door styles
     */
    private function getDoorStyleImageUrl($doorStyle)
    {
        if ($doorStyle->image) {
            // Check if the image file exists in public/uploads directory
            $imagePath = public_path('uploads/door-styles/' . basename($doorStyle->image));
            if (file_exists($imagePath)) {
                // Use rawurlencode for better URL handling of spaces and special characters
                return asset('uploads/door-styles/' . rawurlencode(basename($doorStyle->image)));
            }
        }
        
        // Fallback to placeholder with style name
        return 'https://placehold.co/400x400/EAEAEA/333?text=' . urlencode($doorStyle->name);
    }

    /**
     * Generate proper image URL for categories
     */
    private function getCategoryImageUrl($category)
    {
        if ($category->image) {
            // Check if the image file exists in public/uploads directory
            $imagePath = public_path('uploads/categories/' . basename($category->image));
            if (file_exists($imagePath)) {
                // Use rawurlencode for better URL handling of spaces and special characters
                return asset('uploads/categories/' . rawurlencode(basename($category->image)));
            }
        }
        
        // Fallback to placeholder with category name
        return 'https://placehold.co/80x50/8c7a6b/ffffff?text=' . urlencode($category->name);
    }

    /**
     * Generate proper image URL for subcategories
     */
    private function getSubCategoryImageUrl($subCategory)
    {
        if ($subCategory->image_url) {
            // Check if the image file exists in public/uploads directory
            $imagePath = public_path('uploads/sub-categories/' . basename($subCategory->image_url));
            if (file_exists($imagePath)) {
                // Use rawurlencode for better URL handling of spaces and special characters
                return asset('uploads/sub-categories/' . rawurlencode(basename($subCategory->image_url)));
            }
        }
        
        // Fallback to placeholder with subcategory name
        return 'https://placehold.co/60x40/a6988d/ffffff?text=' . urlencode($subCategory->name);
    }

    /**
     * Generate main image URL for door colors
     */
    private function getDoorColorMainImageUrl($doorColor)
    {
        if ($doorColor->main_image) {
            $imagePath = public_path('uploads/door-colors/' . basename($doorColor->main_image));
            if (file_exists($imagePath)) {
                return asset('uploads/door-colors/' . rawurlencode(basename($doorColor->main_image)));
            }
        }
        return null;
    }

    /**
     * Generate gallery image URLs for door colors
     */
    private function getDoorColorGalleryImageUrls($doorColor)
    {
        if (!$doorColor->gallery_images || !is_array($doorColor->gallery_images)) {
            return [];
        }
        
        $urls = [];
        foreach ($doorColor->gallery_images as $imagePath) {
            $imagePath = public_path('uploads/door-colors/' . basename($imagePath));
            if (file_exists($imagePath)) {
                $urls[] = asset('uploads/door-colors/' . rawurlencode(basename($imagePath)));
            }
        }
        
        return $urls;
    }

    /**
     * Get color hex code based on color name
     */
    private function getColorHex($colorName)
    {
        $colorMap = [
            'Pure White' => '#FFFFFF',
            'Cyber Grey' => '#9CA3AF',
            'Navy Blue' => '#3B82F6',
            'Natural Oak' => '#D6C7B9',
            'Charcoal' => '#374151',
            'Light Gray' => '#E5E7EB',
            'Espresso' => '#5d4037',
            'Matte Black' => '#1F2937',
            'Sage Green' => '#86EFAC',
        ];

        return $colorMap[$colorName] ?? '#EAEAEA';
    }

    /**
     * Get products for a specific subcategory (AJAX)
     */
    public function getProductsBySubcategory(Request $request, $subcategoryId)
    {
        $query = Product::whereHas('subCategories', function ($query) use ($subcategoryId) {
            $query->where('sub_categories.id', $subcategoryId);
        });

        if ($request->has('doorColorId')) {
            $productLine = ProductLine::where('door_color_id', $request->doorColorId)->first();
            if ($productLine) {
                $query->where('product_line_id', $productLine->id);
            }
        }

        $products = $query->with(['productLine.doorStyle', 'productLine.doorColor', 'subCategories'])->get();
        
        // Find the specific subcategory to get its image URL
        $subCategory = \App\Models\SubCategory::find($subcategoryId);
        $subCategoryImageUrl = $subCategory ? $this->getSubCategoryImageUrl($subCategory) : 'https://placehold.co/60x60/f0f0f0/333?text=Product';

        return response()->json([
            'products' => $products->map(function ($product) use ($subCategoryImageUrl) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sku' => $product->sku,
                    'stock' => 'In Stock',
                    'unitPrice' => (float) $product->price,
                    'laborCost' => (float) ($product->labor_cost ?? 30),
                    'hingeOptions' => $this->parseHingeType($product->hinge_type),
                    'modifications' => (bool) $product->is_modifiable,
                    'imageUrl' => $subCategoryImageUrl, // Add image URL here
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