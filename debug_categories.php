<?php

require_once 'vendor/autoload.php';

use App\Models\DoorColor;
use App\Models\ProductLine;

// Get all door colors
$doorColors = DoorColor::all();

foreach ($doorColors as $doorColor) {
    echo "=== Door Color: {$doorColor->name} ===\n";
    
    // Get product lines for this door color
    $productLines = ProductLine::where('door_color_id', $doorColor->id)
        ->with(['categories.subCategories'])
        ->get();
    
    if ($productLines->isEmpty()) {
        echo "No product lines found for this door color!\n";
        continue;
    }
    
    // Get unique categories from all product lines
    $categories = $productLines->flatMap(function ($productLine) {
        return $productLine->categories;
    })->unique('id');
    
    echo "Categories found: " . $categories->count() . "\n";
    
    foreach ($categories as $category) {
        echo "- Category: {$category->name}\n";
        foreach ($category->subCategories as $subCategory) {
            echo "  - SubCategory: {$subCategory->name}\n";
        }
    }
    echo "\n";
} 