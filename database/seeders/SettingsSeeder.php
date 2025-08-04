<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Shipping Settings
        Setting::setValue(
            'free_shipping_threshold',
            2500,
            'number',
            'shipping',
            'Free Shipping Threshold',
            'Orders above this amount qualify for free shipping'
        );

        Setting::setValue(
            'default_shipping_rate',
            50,
            'number',
            'shipping',
            'Default Shipping Rate',
            'Default shipping cost for orders below free shipping threshold'
        );

        // General Settings
        Setting::setValue(
            'store_name',
            'BH Cabinetry',
            'string',
            'general',
            'Store Name',
            'The name of your store'
        );

        Setting::setValue(
            'store_email',
            'admin@bhcabinetry.com',
            'string',
            'general',
            'Store Email',
            'Primary contact email for the store'
        );

        Setting::setValue(
            'store_phone',
            '+1 (555) 123-4567',
            'string',
            'general',
            'Store Phone',
            'Primary contact phone number'
        );

        Setting::setValue(
            'store_address',
            '123 Cabinet Street, Design City, DC 12345',
            'string',
            'general',
            'Store Address',
            'Physical address of the store'
        );
    }
}
