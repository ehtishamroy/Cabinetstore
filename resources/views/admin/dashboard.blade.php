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
            <p class="text-3xl font-bold text-gray-900">${{ number_format($totalRevenue, 2) }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <i data-lucide="shopping-cart" class="w-8 h-8 text-blue-500 mb-2"></i>
            <p class="text-gray-500 text-sm">New Orders (30 days)</p>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($newOrders) }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <i data-lucide="package" class="w-8 h-8 text-purple-500 mb-2"></i>
            <p class="text-gray-500 text-sm">Total Products</p>
            <p class="text-3xl font-bold text-gray-900">{{ number_format($totalProducts) }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow">
            <i data-lucide="activity" class="w-8 h-8 text-red-500 mb-2"></i>
            <p class="text-gray-500 text-sm">Conversion Rate</p>
            <p class="text-3xl font-bold text-gray-900">{{ $conversionRate }}%</p>
        </div>
    </div>

    <div class="mt-8">
        <!-- Recent Orders -->
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-900">Recent Orders</h2>
                <a href="{{ route('admin.orders') }}" class="text-accent hover:text-accent-dark text-sm">View All Orders</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-500 uppercase bg-gray-50">
                        <tr>
                            <th class="px-4 py-3">Order ID</th>
                            <th class="px-4 py-3">Customer</th>
                            <th class="px-4 py-3">Total</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-accent hover:text-accent-dark">
                                    #{{ $order->order_number }}
                                </a>
                            </td>
                            <td class="px-4 py-3">
                                @if($order->user)
                                    {{ $order->user->name }}
                                @else
                                    Guest Customer
                                @endif
                            </td>
                            <td class="px-4 py-3">${{ number_format($order->total_amount, 2) }}</td>
                            <td class="px-4 py-3">
                                <span class="status-pill status-{{ $order->status }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-gray-500">
                                {{ $order->created_at->format('M d, Y') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-3 text-center text-gray-500">No orders found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Additional Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
        <!-- Blog Posts -->
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-900">Blog Posts</h2>
                <a href="{{ route('admin.blog.index') }}" class="text-accent hover:text-accent-dark text-sm">Manage Posts</a>
            </div>
            <div class="flex items-center">
                <i data-lucide="file-text" class="w-8 h-8 text-blue-500 mr-3"></i>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalBlogPosts }}</p>
                    <p class="text-gray-500 text-sm">Total Posts</p>
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="bg-white p-6 rounded-lg shadow">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-900">All Orders</h2>
                <a href="{{ route('admin.orders') }}" class="text-accent hover:text-accent-dark text-sm">View All</a>
            </div>
            <div class="flex items-center">
                <i data-lucide="shopping-bag" class="w-8 h-8 text-green-500 mr-3"></i>
                <div>
                    <p class="text-2xl font-bold text-gray-900">{{ $totalOrders }}</p>
                    <p class="text-gray-500 text-sm">Total Orders</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.status-pill {
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}
.status-pending {
    background-color: #fef3c7;
    color: #92400e;
}
.status-processing {
    background-color: #dbeafe;
    color: #1e40af;
}
.status-shipped {
    background-color: #d1fae5;
    color: #065f46;
}
.status-completed {
    background-color: #d1fae5;
    color: #065f46;
}
.status-cancelled {
    background-color: #fee2e2;
    color: #991b1b;
}
</style>
@endsection 