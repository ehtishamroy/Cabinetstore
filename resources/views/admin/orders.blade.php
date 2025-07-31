@extends('admin.layout')

@section('title', 'Orders - Aura Admin Panel')

@section('content')
<div class="p-6 sm:p-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Orders</h1>
            <p class="text-gray-600 mt-1">Manage and track all customer orders.</p>
        </div>
    </div>
    <div class="bg-white p-6 rounded-lg shadow">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                    <tr>
                        <th class="px-4 py-3">Order ID</th>
                        <th class="px-4 py-3">Customer</th>
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3">Total</th>
                        <th class="px-4 py-3">Status</th>
                        <th class="px-4 py-3 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b">
                        <td class="px-4 py-3 font-medium">#1254</td>
                        <td class="px-4 py-3">Jane Doe</td>
                        <td class="px-4 py-3">July 25, 2025</td>
                        <td class="px-4 py-3">$250.00</td>
                        <td class="px-4 py-3"><span class="status-pill status-shipped">Shipped</span></td>
                        <td class="px-4 py-3 text-right">
                            <button class="action-button">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </button>
                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-4 py-3 font-medium">#1253</td>
                        <td class="px-4 py-3">John Smith</td>
                        <td class="px-4 py-3">July 25, 2025</td>
                        <td class="px-4 py-3">$150.00</td>
                        <td class="px-4 py-3"><span class="status-pill status-shipped">Shipped</span></td>
                        <td class="px-4 py-3 text-right">
                            <button class="action-button">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </button>
                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-4 py-3 font-medium">#1252</td>
                        <td class="px-4 py-3">Michael B.</td>
                        <td class="px-4 py-3">July 24, 2025</td>
                        <td class="px-4 py-3">$3,480.00</td>
                        <td class="px-4 py-3"><span class="status-pill status-processing">Processing</span></td>
                        <td class="px-4 py-3 text-right">
                            <button class="action-button">
                                <i data-lucide="eye" class="w-4 h-4"></i>
                            </button>
                        </td>
                    </tr>
                    <tr class="border-b">
                        <td class="px-4 py-3 font-medium">#1251</td>
                        <td class="px-4 py-3">Sarah J.</td>
                        <td class="px-4 py-3">July 23, 2025</td>
                        <td class="px-4 py-3">$1,250.00</td>
                        <td class="px-4 py-3"><span class="status-pill status-pending">Pending</span></td>
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