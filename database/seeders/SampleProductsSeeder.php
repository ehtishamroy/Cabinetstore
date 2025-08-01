<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\ProductLine;
use App\Models\SubCategory;

class SampleProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all product lines and sub categories
        $productLines = ProductLine::with(['doorStyle', 'doorColor'])->get();
        $subCategories = SubCategory::all();

        // Create sample products for each product line
        foreach ($productLines as $productLine) {
            // Create 2-3 products for each product line
            for ($i = 1; $i <= 2; $i++) {
                $subCategory = $subCategories->random();
                
                Product::create([
                    'product_line_id' => $productLine->id,
                    'sub_category_id' => $subCategory->id,
                    'sku' => $productLine->doorStyle->name . '-' . $productLine->doorColor->name . '-' . $i,
                    'name' => $productLine->doorStyle->name . ' ' . $productLine->doorColor->name . ' Cabinet',
                    'price' => rand(100, 500),
                    'assembly_cost' => rand(10, 50),
                    'hinge_type' => 'Standard',
                    'is_modifiable' => true,
                ]);
            }
        }

        $this->command->info('Sample products created successfully!');
    }
} 