@extends('admin.layout')

@section('title', 'Dashboard - BH Cabinetry Admin Panel')

@section('content')
<div class="p-6 sm:p-8">
    <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
    <p class="text-gray-600 mt-1">Welcome back, Admin!</p>
    
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
        <div class="bg-white p-6 rounded-lg shadow">
            <i data-lucide="dollar-sign" class="w-8 h-8 text-green-500 mb-2"></i>
            <p class="text-gray-500 text-sm">Total Revenue</p>
            <p class="text-3xl font-bold text-gray-900">$75,392.00</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <i data-lucide="shopping-cart" class="w-8 h-8 text-blue-500 mb-2"></i>
            <p class="text-gray-500 text-sm">New Orders</p>
            <p class="text-3xl font-bold text-gray-900">3,281</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <i data-lucide="users" class="w-8 h-8 text-purple-500 mb-2"></i>
            <p class="text-gray-500 text-sm">New Customers</p>
            <p class="text-3xl font-bold text-gray-900">1,204</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <i data-lucide="activity" class="w-8 h-8 text-red-500 mb-2"></i>
            <p class="text-gray-500 text-sm">Conversion Rate</p>
            <p class="text-3xl font-bold text-gray-900">2.54%</p>
        </div>
    </div>

    <div class="mt-8">
        <!-- Recent Orders -->
        <div class="bg-white p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Recent Orders</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                        <tr>
                            <th class="px-4 py-3">Order ID</th>
                            <th class="px-4 py-3">Customer</th>
                            <th class="px-4 py-3">Total</th>
                            <th class="px-4 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b">
                            <td class="px-4 py-3 font-medium">#1254</td>
                            <td class="px-4 py-3">Jane Doe</td>
                            <td class="px-4 py-3">$250.00</td>
                            <td class="px-4 py-3"><span class="status-pill status-shipped">Shipped</span></td>
                        </tr>
                        <tr class="border-b">
                            <td class="px-4 py-3 font-medium">#1253</td>
                            <td class="px-4 py-3">John Smith</td>
                            <td class="px-4 py-3">$150.00</td>
                            <td class="px-4 py-3"><span class="status-pill status-shipped">Shipped</span></td>
                        </tr>
                        <tr class="border-b">
                            <td class="px-4 py-3 font-medium">#1252</td>
                            <td class="px-4 py-3">Michael B.</td>
                            <td class="px-4 py-3">$3,480.00</td>
                            <td class="px-4 py-3"><span class="status-pill status-processing">Processing</span></td>
                        </tr>
                        <tr class="border-b">
                            <td class="px-4 py-3 font-medium">#1251</td>
                            <td class="px-4 py-3">Sarah J.</td>
                            <td class="px-4 py-3">$1,250.00</td>
                            <td class="px-4 py-3"><span class="status-pill status-pending">Pending</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection 