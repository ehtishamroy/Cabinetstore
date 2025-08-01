<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\DoorStyle;
use App\Models\DoorColor;
use App\Models\ProductLine;
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
} 