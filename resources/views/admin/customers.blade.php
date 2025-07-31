@extends('admin.layout')

@section('title', 'Customers - Aura Admin Panel')

@section('content')
<div class="p-6 sm:p-8">
    <h1 class="text-3xl font-bold text-gray-900">Customers</h1>
    <p class="text-gray-600 mt-1">View and manage your customer list.</p>
    <div class="bg-white p-6 rounded-lg shadow mt-8">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                    <tr>
                        <th class="px-4 py-3">Customer Name</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Join Date</th>
                        <th class="px-4 py-3">Total Orders</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b">
                        <td class="px-4 py-3 font-medium flex items-center">
                            <img src="https://placehold.co/32x32/cccccc/666666?text=JD" class="w-8 h-8 rounded-full mr-3">Jane Doe
                        </td>
                        <td class="px-4 py-3">jane.doe@example.com</td>
                        <td class="px-4 py-3">July 15, 2025</td>
                        <td class="px-4 py-3">1</td>
                        <td class="px-4 py-3 text-right">
                            <button class="action-button">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </button>
                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-4 py-3 font-medium flex items-center">
                            <img src="https://placehold.co/32x32/cccccc/666666?text=JS" class="w-8 h-8 rounded-full mr-3">John Smith
                        </td>
                        <td class="px-4 py-3">john.smith@example.com</td>
                        <td class="px-4 py-3">July 14, 2025</td>
                        <td class="px-4 py-3">1</td>
                        <td class="px-4 py-3 text-right">
                            <button class="action-button">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 