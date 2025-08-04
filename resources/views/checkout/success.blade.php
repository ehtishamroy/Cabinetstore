@extends('layouts.app')

@section('title', 'Order Confirmation - BH Cabinetry')

@section('styles')
<style>
    body {
        background-color: #ffffff;
        padding-bottom: 0;
    }
    
    main {
        padding-top: 0;
    }
    
    .success-icon {
        width: 80px;
        height: 80px;
        background-color: #10b981;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 2rem;
    }
    
    .order-details {
        background-color: #f8f7f4;
        border-radius: 0.5rem;
        padding: 1.5rem;
        margin: 2rem 0;
    }
    
    .order-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .order-item:last-child {
        border-bottom: none;
    }
</style>
@endsection

@section('content')
<main class="w-full">
    <div class="min-h-screen flex items-center justify-center py-12 px-6">
        <div class="max-w-2xl w-full">
            <!-- Success Icon -->
            <div class="success-icon">
                <i data-lucide="check" class="w-10 h-10 text-white"></i>
            </div>
            
            <!-- Success Message -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-4">Thank you for your order!</h1>
                <p class="text-lg text-gray-600 mb-2">Your order has been successfully placed.</p>
                <p class="text-sm text-gray-500">Order #{{ $order->order_number }}</p>
            </div>
            
            <!-- Order Details -->
            <div class="order-details">
                <h2 class="text-xl font-semibold mb-4">Order Details</h2>
                
                <div class="space-y-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Order Number:</span>
                        <span class="font-medium">{{ $order->order_number }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Order Date:</span>
                        <span class="font-medium">{{ $order->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Payment Method:</span>
                        <span class="font-medium capitalize">{{ $order->payment_method }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Payment Status:</span>
                        <span class="font-medium text-green-600 capitalize">{{ $order->payment_status }}</span>
                    </div>
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Order Status:</span>
                        <span class="font-medium capitalize">{{ $order->status }}</span>
                    </div>
                </div>
                
                <hr class="my-6 border-gray-300">
                
                <h3 class="text-lg font-semibold mb-4">Items Ordered</h3>
                <div class="space-y-3">
                    @foreach($order->orderItems as $item)
                    <div class="order-item">
                        <div>
                            <p class="font-medium">{{ $item->product_name }}</p>
                            <p class="text-sm text-gray-500">
                                Qty: {{ $item->quantity }} | 
                                Assembly: {{ $item->assembly ? 'Yes' : 'No' }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="font-medium">${{ number_format($item->subtotal, 2) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <hr class="my-6 border-gray-300">
                
                <div class="flex justify-between items-center text-lg font-bold">
                    <span>Total</span>
                    <span>${{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>
            
            <!-- Shipping Information -->
            @php
                $shippingAddress = json_decode($order->shipping_address, true);
            @endphp
            <div class="order-details">
                <h2 class="text-xl font-semibold mb-4">Shipping Information</h2>
                <div class="text-sm text-gray-600">
                    <p class="font-medium">{{ $shippingAddress['firstName'] }} {{ $shippingAddress['lastName'] }}</p>
                    @if($shippingAddress['company'])
                        <p>{{ $shippingAddress['company'] }}</p>
                    @endif
                    <p>{{ $shippingAddress['address'] }}</p>
                    @if($shippingAddress['apartment'])
                        <p>{{ $shippingAddress['apartment'] }}</p>
                    @endif
                    <p>{{ $shippingAddress['city'] }}, {{ $shippingAddress['zipCode'] }}</p>
                    <p>{{ $shippingAddress['country'] }}</p>
                    <p class="mt-2">{{ $shippingAddress['phone'] }}</p>
                </div>
            </div>
            
            <!-- Next Steps -->
            <div class="text-center mt-8">
                <h3 class="text-lg font-semibold mb-4">What's Next?</h3>
                <div class="space-y-3 text-sm text-gray-600">
                    <p>• You'll receive an order confirmation email shortly</p>
                    <p>• We'll notify you when your order ships</p>
                    <p>• Estimated delivery: 2-3 weeks</p>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 mt-8">
                <a href="/shop" class="flex-1 bg-gray-900 text-white py-3 px-6 rounded-lg font-semibold hover:bg-black transition-colors duration-200 text-center">
                    Continue Shopping
                </a>
                <a href="/" class="flex-1 bg-gray-200 text-gray-800 py-3 px-6 rounded-lg font-semibold hover:bg-gray-300 transition-colors duration-200 text-center">
                    Back to Home
                </a>
            </div>
            
            <!-- Contact Information -->
            <div class="text-center mt-8 text-sm text-gray-500">
                <p>Questions about your order? Contact us at <a href="mailto:support@bhcabinetry.com" class="text-accent hover:underline">support@bhcabinetry.com</a></p>
            </div>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        lucide.createIcons();
    });
</script>
@endsection 