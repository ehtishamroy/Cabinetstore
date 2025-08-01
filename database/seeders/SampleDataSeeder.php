<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DoorStyle;
use App\Models\DoorColor;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ProductLine;

class SampleDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Door Styles
        $hdfStyle = DoorStyle::create(['name' => 'HDF Doors']);
        $shakerStyle = DoorStyle::create(['name' => 'Shaker Style']);
        $modernStyle = DoorStyle::create(['name' => 'Modern Slab']);

        // Create Door Colors
        $whiteColor = DoorColor::create(['name' => 'Pure White']);
        $greyColor = DoorColor::create(['name' => 'Cyber Grey']);
        $navyColor = DoorColor::create(['name' => 'Navy Blue']);
        $oakColor = DoorColor::create(['name' => 'Natural Oak']);

        // Create Categories
        $baseCategory = Category::create(['name' => 'Base Cabinets']);
        $wallCategory = Category::create(['name' => 'Wall Cabinets']);
        $tallCategory = Category::create(['name' => 'Tall Cabinets']);

        // Create Sub Categories
        SubCategory::create([
            'category_id' => $baseCategory->id,
            'name' => '2 Drawer Base Cabinet',
            'image_url' => 'https://placehold.co/400x300/cccccc/666666?text=2+Drawer+Base'
        ]);

        SubCategory::create([
            'category_id' => $baseCategory->id,
            'name' => 'Single Door Base Cabinet',
            'image_url' => 'https://placehold.co/400x300/cccccc/666666?text=Single+Door+Base'
        ]);

        SubCategory::create([
            'category_id' => $baseCategory->id,
            'name' => '3 Drawer Base Cabinet',
            'image_url' => 'https://placehold.co/400x300/cccccc/666666?text=3+Drawer+Base'
        ]);

        SubCategory::create([
            'category_id' => $wallCategory->id,
            'name' => 'Single Door Wall Cabinet',
            'image_url' => 'https://placehold.co/400x300/cccccc/666666?text=Single+Door+Wall'
        ]);

        SubCategory::create([
            'category_id' => $wallCategory->id,
            'name' => 'Double Door Wall Cabinet',
            'image_url' => 'https://placehold.co/400x300/cccccc/666666?text=Double+Door+Wall'
        ]);

        SubCategory::create([
            'category_id' => $tallCategory->id,
            'name' => 'Pantry Cabinet',
            'image_url' => 'https://placehold.co/400x300/cccccc/666666?text=Pantry+Cabinet'
        ]);

        // Create Product Lines
        $productLine1 = ProductLine::create([
            'door_style_id' => $hdfStyle->id,
            'door_color_id' => $whiteColor->id,
        ]);

        $productLine2 = ProductLine::create([
            'door_style_id' => $hdfStyle->id,
            'door_color_id' => $greyColor->id,
        ]);

        $productLine3 = ProductLine::create([
            'door_style_id' => $shakerStyle->id,
            'door_color_id' => $oakColor->id,
        ]);

        // Associate categories with product lines
        $productLine1->categories()->attach([$baseCategory->id, $wallCategory->id]);
        $productLine2->categories()->attach([$baseCategory->id, $wallCategory->id, $tallCategory->id]);
        $productLine3->categories()->attach([$baseCategory->id, $wallCategory->id]);
    }
}
