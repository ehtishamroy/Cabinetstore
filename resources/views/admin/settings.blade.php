@extends('admin.layout')

@section('title', 'Settings - Aura Admin Panel')

@section('content')
<div class="p-6 sm:p-8">
    <h1 class="text-3xl font-bold text-gray-900">Settings</h1>
    <p class="text-gray-600 mt-1">Manage your store settings and integrations.</p>
    
    <div class="mt-8 space-y-6">
        <!-- Store Information -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Store Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Store Name</label>
                    <input type="text" value="Aura Cabinets" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Store Email</label>
                    <input type="email" value="admin@auracabinets.com" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                    <input type="tel" value="+1 (555) 123-4567" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                    <input type="text" value="123 Cabinet Street, Design City, DC 12345" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
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
                    <button class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-900">Configure</button>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="font-medium text-gray-900">PayPal</h3>
                        <p class="text-sm text-gray-500">Accept PayPal payments</p>
                    </div>
                    <button class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-900">Configure</button>
                </div>
            </div>
        </div>

        <!-- Shipping Settings -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Shipping Settings</h2>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Free Shipping Threshold</label>
                    <input type="number" value="1500" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Default Shipping Rate</label>
                    <input type="number" value="25" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-gray-500">
                </div>
            </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end">
            <button class="bg-gray-800 text-white font-semibold py-2 px-6 rounded-lg hover:bg-gray-900">
                Save Settings
            </button>
        </div>
    </div>
</div>
@endsection 