<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DoorStyle;
use App\Models\DoorColor;
use App\Models\ProductLine;

class ProductLineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get door styles and colors
        $hdfDoors = DoorStyle::where('name', 'HDF Doors')->first();
        $modernSlab = DoorStyle::where('name', 'Modern Slab')->first();
        
        $pureWhite = DoorColor::where('name', 'Pure White')->first();
        $cyberGrey = DoorColor::where('name', 'Cyber Grey')->first();
        $navyBlue = DoorColor::where('name', 'Navy Blue')->first();
        $naturalOak = DoorColor::where('name', 'Natural Oak')->first();

        // Add missing product lines for Modern Slab
        if ($modernSlab && $pureWhite) {
            ProductLine::firstOrCreate([
                'door_style_id' => $modernSlab->id,
                'door_color_id' => $pureWhite->id,
            ]);
        }

        if ($modernSlab && $cyberGrey) {
            ProductLine::firstOrCreate([
                'door_style_id' => $modernSlab->id,
                'door_color_id' => $cyberGrey->id,
            ]);
        }

        if ($modernSlab && $navyBlue) {
            ProductLine::firstOrCreate([
                'door_style_id' => $modernSlab->id,
                'door_color_id' => $navyBlue->id,
            ]);
        }

        if ($modernSlab && $naturalOak) {
            ProductLine::firstOrCreate([
                'door_style_id' => $modernSlab->id,
                'door_color_id' => $naturalOak->id,
            ]);
        }

        // Add missing colors for HDF Doors
        if ($hdfDoors && $cyberGrey) {
            ProductLine::firstOrCreate([
                'door_style_id' => $hdfDoors->id,
                'door_color_id' => $cyberGrey->id,
            ]);
        }

        if ($hdfDoors && $naturalOak) {
            ProductLine::firstOrCreate([
                'door_style_id' => $hdfDoors->id,
                'door_color_id' => $naturalOak->id,
            ]);
        }

        $this->command->info('Product lines seeded successfully!');
    }
} 