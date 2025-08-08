<?php

namespace App\Http\Controllers;

use App\Models\DoorStyle;
use App\Models\DoorColor;
use App\Models\ProductLine;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the homepage with door styles
     */
    public function index()
    {
        // Get all door styles with image URLs, similar to shop page
        $doorStyles = DoorStyle::orderBy('name')->get()->map(function ($style) {
            return [
                'id' => $style->id,
                'name' => $style->name,
                'image_url' => $this->getDoorStyleImageUrl($style),
            ];
        });
        
        // Get door colors grouped by door style for the color count
        $doorColorsByStyle = [];
        foreach ($doorStyles as $doorStyle) {
            // Get only colors that are actually related to this door style through ProductLine
            $colors = ProductLine::where('door_style_id', $doorStyle['id'])
                ->with(['doorColor', 'doorStyle'])
                ->get()
                ->map(function ($productLine) {
                    return [
                        'id' => $productLine->doorColor->id,
                        'name' => $productLine->doorColor->name,
                        'door_style' => $productLine->doorStyle->name,
                        'door_style_id' => $productLine->doorStyle->id,
                        'door_color_id' => $productLine->doorColor->id,
                        'product_line_id' => $productLine->id,
                        'slug' => $this->generateSlug($productLine->doorColor->name),
                    ];
                });
            $doorColorsByStyle[$doorStyle['name']] = $colors;
        }

        return view('home', compact('doorStyles', 'doorColorsByStyle'));
    }

    /**
     * Generate a URL-friendly slug from a name
     */
    private function generateSlug($name)
    {
        $slug = strtolower(trim($name));
        $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
        $slug = preg_replace('/[\s-]+/', '-', $slug);
        $slug = trim($slug, '-');
        return $slug;
    }

    /**
     * Get door style image URL
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
        
        // If no specific image, try to get the first color's image for this style
        $firstColor = ProductLine::where('door_style_id', $doorStyle->id)
            ->with('doorColor')
            ->first();
            
        if ($firstColor && $firstColor->doorColor && $firstColor->doorColor->image) {
            $imagePath = public_path('uploads/door-colors/' . basename($firstColor->doorColor->image));
            if (file_exists($imagePath)) {
                return asset('uploads/door-colors/' . rawurlencode(basename($firstColor->doorColor->image)));
            }
        }
        
        // Fallback to a placeholder based on the style name
        $styleName = urlencode($doorStyle->name);
        return "https://placehold.co/400x400/EAEAEA/333?text={$styleName}";
    }
}
