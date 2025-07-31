@extends('admin.layout')

@section('title', 'Categories - Aura Admin Panel')

@section('content')
<div class="p-6 sm:p-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Categories</h1>
            <p class="text-gray-600 mt-1">Organize your product categories and sub-categories.</p>
        </div>
        <button class="mt-4 sm:mt-0 bg-gray-800 text-white font-semibold py-2 px-4 rounded-lg flex items-center hover:bg-gray-900">
            <i data-lucide="plus" class="w-4 h-4 mr-2"></i> Add New Category
        </button>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                    <tr>
                        <th class="px-4 py-3">Category Name</th>
                        <th class="px-4 py-3">Sub-categories</th>
                        <th class="px-4 py-3">Product Count</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b">
                        <td class="px-4 py-3 font-medium">Base Cabinets</td>
                        <td class="px-4 py-3">Single Door, Double Door</td>
                        <td class="px-4 py-3">4</td>
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
                        <td class="px-4 py-3 font-medium">Wall Cabinets</td>
                        <td class="px-4 py-3">Small Wall</td>
                        <td class="px-4 py-3">1</td>
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