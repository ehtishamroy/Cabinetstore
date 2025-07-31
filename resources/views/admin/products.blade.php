@extends('admin.layout')

@section('title', 'Products - Aura Admin Panel')

@section('content')
<div class="p-6 sm:p-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Products</h1>
            <p class="text-gray-600 mt-1">Add, edit, and manage your products.</p>
        </div>
        <button class="mt-4 sm:mt-0 bg-gray-800 text-white font-semibold py-2 px-4 rounded-lg flex items-center hover:bg-gray-900">
            <i data-lucide="plus" class="w-4 h-4 mr-2"></i> Add New Product
        </button>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                    <tr>
                        <th class="px-4 py-3">Image</th>
                        <th class="px-4 py-3">Product Name</th>
                        <th class="px-4 py-3">Category</th>
                        <th class="px-4 py-3">Price</th>
                        <th class="px-4 py-3">Stock</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b">
                        <td class="p-2">
                            <img src="https://placehold.co/48x48/f0f0f0/333?text=B12" class="w-12 h-12 rounded-md">
                        </td>
                        <td class="px-4 py-3 font-medium">B12 Base</td>
                        <td class="px-4 py-3">Base Cabinets</td>
                        <td class="px-4 py-3">$150.00</td>
                        <td class="px-4 py-3">120</td>
                        <td class="px-4 py-3 text-right">
                            <button class="action-button">
                                <i data-lucide="edit-2" class="w-4 h-4"></i>
                            </button>
                            <button class="action-button text-red-500">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="p-2">
                            <img src="https://placehold.co/48x48/f0f0f0/333?text=W1230" class="w-12 h-12 rounded-md">
                        </td>
                        <td class="px-4 py-3 font-medium">W1230 Wall</td>
                        <td class="px-4 py-3">Wall Cabinets</td>
                        <td class="px-4 py-3">$120.00</td>
                        <td class="px-4 py-3">85</td>
                        <td class="px-4 py-3 text-right">
                            <button class="action-button">
                                <i data-lucide="edit-2" class="w-4 h-4"></i>
                            </button>
                            <button class="action-button text-red-500">
                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 