@extends('admin.layout')

@section('title', 'Order Details - ' . $order->order_number)

@section('content')
<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">Order Details</h1>
        <p class="text-gray-600">Order #{{ $order->order_number }}</p>
    </div>
    <a href="{{ route('admin.orders') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
        Back to Orders
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Order Information -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Order Items -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Order Items</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Quantity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unit Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Assembly</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($order->orderItems as $item)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $item->product_name }}</div>
                                    @if($item->product)
                                        <div class="text-sm text-gray-500">SKU: {{ $item->product->id }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $item->quantity }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">${{ number_format($item->unit_price, 2) }}</td>
                                <td class="px-6 py-4">
                                    @if($item->assembly)
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            Yes (+${{ number_format($item->labor_cost, 2) }})
                                        </span>
                                    @else
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
                                            No
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm font-medium text-gray-900">${{ number_format($item->subtotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-right text-sm font-medium text-gray-900">Total:</td>
                            <td class="px-6 py-4 text-sm font-bold text-gray-900">${{ number_format($order->total_amount, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Customer Information</h3>
            </div>
            <div class="px-6 py-4 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Customer Type</label>
                    <p class="mt-1 text-sm text-gray-900">
                        @if($order->user)
                            Admin User: {{ $order->user->name }}
                        @else
                            Guest Customer
                        @endif
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $order->customer_email }}</p>
                </div>
            </div>
        </div>

        <!-- Addresses -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Shipping Address -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Shipping Address</h3>
                </div>
                <div class="px-6 py-4">
                    @if($order->shipping_address)
                        <div class="text-sm text-gray-900">
                            <p><strong>{{ $order->shipping_address['firstName'] ?? '' }} {{ $order->shipping_address['lastName'] ?? '' }}</strong></p>
                            @if(isset($order->shipping_address['company']) && $order->shipping_address['company'])
                                <p>{{ $order->shipping_address['company'] }}</p>
                            @endif
                            <p>{{ $order->shipping_address['address'] ?? '' }}</p>
                            @if(isset($order->shipping_address['apartment']) && $order->shipping_address['apartment'])
                                <p>{{ $order->shipping_address['apartment'] }}</p>
                            @endif
                            <p>{{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['state'] ?? '' }} {{ $order->shipping_address['zipCode'] ?? '' }}</p>
                            @if(isset($order->shipping_address['phone']) && $order->shipping_address['phone'])
                                <p>Phone: {{ $order->shipping_address['phone'] }}</p>
                            @endif
                        </div>
                    @else
                        <p class="text-sm text-gray-500">No shipping address available</p>
                    @endif
                </div>
            </div>

            <!-- Billing Address -->
            <div class="bg-white shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Billing Address</h3>
                </div>
                <div class="px-6 py-4">
                    @if($order->billing_address)
                        @if($order->billing_address === $order->shipping_address)
                            <p class="text-sm text-gray-500 italic">Same as shipping address</p>
                        @else
                            <div class="text-sm text-gray-900">
                                <p><strong>{{ $order->billing_address['firstName'] ?? '' }} {{ $order->billing_address['lastName'] ?? '' }}</strong></p>
                                @if(isset($order->billing_address['company']) && $order->billing_address['company'])
                                    <p>{{ $order->billing_address['company'] }}</p>
                                @endif
                                <p>{{ $order->billing_address['address'] ?? '' }}</p>
                                @if(isset($order->billing_address['apartment']) && $order->billing_address['apartment'])
                                    <p>{{ $order->billing_address['apartment'] }}</p>
                                @endif
                                <p>{{ $order->billing_address['city'] ?? '' }}, {{ $order->billing_address['state'] ?? '' }} {{ $order->billing_address['zipCode'] ?? '' }}</p>
                                @if(isset($order->billing_address['phone']) && $order->billing_address['phone'])
                                    <p>Phone: {{ $order->billing_address['phone'] }}</p>
                                @endif
                            </div>
                        @endif
                    @else
                        <p class="text-sm text-gray-500">No billing address available</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Order Status Panel -->
    <div class="space-y-6">
        <!-- Order Status -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Order Status</h3>
            </div>
            <div class="px-6 py-4 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Order Date</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $order->created_at->format('M d, Y \a\t g:i A') }}</p>
                </div>
                
                <form action="{{ route('admin.orders.update-status', $order) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Order Status</label>
                        <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <button type="submit" class="mt-2 w-full bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Update Status
                    </button>
                </form>

                <form action="{{ route('admin.orders.update-payment-status', $order) }}" method="POST" class="mt-4">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label for="payment_status" class="block text-sm font-medium text-gray-700">Payment Status</label>
                        <select name="payment_status" id="payment_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="pending" {{ $order->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="paid" {{ $order->payment_status === 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="failed" {{ $order->payment_status === 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="refunded" {{ $order->payment_status === 'refunded' ? 'selected' : '' }}>Refunded</option>
                        </select>
                    </div>
                    <button type="submit" class="mt-2 w-full bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        Update Payment Status
                    </button>
                </form>
            </div>
        </div>

        <!-- Payment Information -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Payment Information</h3>
            </div>
            <div class="px-6 py-4 space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Payment Method</label>
                    <p class="mt-1 text-sm text-gray-900">{{ ucfirst($order->payment_method) }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Payment Status</label>
                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                        {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-800' : 
                           ($order->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                           ($order->payment_status === 'failed' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800')) }}">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Total Amount</label>
                    <p class="mt-1 text-lg font-bold text-gray-900">${{ number_format($order->total_amount, 2) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection