@extends('admin.layout')

@section('title', 'Settings - Aura Admin Panel')

@section('content')
<div class="p-6 sm:p-8">
    <h1 class="text-3xl font-bold text-gray-900">Settings</h1>
    <p class="text-gray-600 mt-1">Manage your store settings and integrations.</p>
    
    @if(session('success'))
        <div class="mt-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif
    
    <form method="POST" action="{{ route('admin.settings.update') }}" class="mt-8 space-y-6">
        @csrf
        @method('PUT')
        
        <!-- Store Information -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Store Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Store Name</label>
                    <input type="text" name="settings[store_name][value]" value="{{ \App\Models\Setting::getValue('store_name', 'BH Cabinetry') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                    <input type="hidden" name="settings[store_name][key]" value="store_name">
                    <input type="hidden" name="settings[store_name][type]" value="string">
                    <input type="hidden" name="settings[store_name][group]" value="general">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Store Email</label>
                    <input type="email" name="settings[store_email][value]" value="{{ \App\Models\Setting::getValue('store_email', 'admin@bhcabinetry.com') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                    <input type="hidden" name="settings[store_email][key]" value="store_email">
                    <input type="hidden" name="settings[store_email][type]" value="string">
                    <input type="hidden" name="settings[store_email][group]" value="general">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                    <input type="tel" name="settings[store_phone][value]" value="{{ \App\Models\Setting::getValue('store_phone', '+1 (555) 123-4567') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                    <input type="hidden" name="settings[store_phone][key]" value="store_phone">
                    <input type="hidden" name="settings[store_phone][type]" value="string">
                    <input type="hidden" name="settings[store_phone][group]" value="general">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                    <input type="text" name="settings[store_address][value]" value="{{ \App\Models\Setting::getValue('store_address', '123 Cabinet Street, Design City, DC 12345') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                    <input type="hidden" name="settings[store_address][key]" value="store_address">
                    <input type="hidden" name="settings[store_address][type]" value="string">
                    <input type="hidden" name="settings[store_address][group]" value="general">
                </div>
            </div>
        </div>

        <!-- Payment Settings -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Payment Settings</h2>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-medium text-gray-900">Stripe Payment Gateway</h3>
                        <p class="text-sm text-gray-500">Process credit card payments securely</p>
                    </div>
                    <button type="button" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-900">Configure</button>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-medium text-gray-900">PayPal</h3>
                        <p class="text-sm text-gray-500">Accept PayPal payments</p>
                    </div>
                    <button type="button" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-900">Configure</button>
                </div>
            </div>
        </div>

        <!-- Shipping Settings -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Shipping Settings</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Free Shipping Threshold ($)</label>
                    <input type="number" name="settings[free_shipping_threshold][value]" value="{{ \App\Models\Setting::getValue('free_shipping_threshold', 2500) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                    <input type="hidden" name="settings[free_shipping_threshold][key]" value="free_shipping_threshold">
                    <input type="hidden" name="settings[free_shipping_threshold][type]" value="number">
                    <input type="hidden" name="settings[free_shipping_threshold][group]" value="shipping">
                    <p class="text-sm text-gray-500 mt-1">Orders above this amount qualify for free shipping</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Default Shipping Rate ($)</label>
                    <input type="number" name="settings[default_shipping_rate][value]" value="{{ \App\Models\Setting::getValue('default_shipping_rate', 50) }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                    <input type="hidden" name="settings[default_shipping_rate][key]" value="default_shipping_rate">
                    <input type="hidden" name="settings[default_shipping_rate][type]" value="number">
                    <input type="hidden" name="settings[default_shipping_rate][group]" value="shipping">
                    <p class="text-sm text-gray-500 mt-1">Default shipping cost for orders below free shipping threshold</p>
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end">
            <button type="submit" class="bg-gray-800 text-white font-semibold py-2 px-6 rounded-lg hover:bg-gray-900">
                Save Settings
            </button>
        </div>
    </form>
</div>
@endsection 