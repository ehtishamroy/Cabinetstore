@extends('layouts.app')

@section('title', 'Order Confirmation - BH Cabinetry')

@section('styles')
<style>
    body {
        background-color: #F8F7F4;
    }
    
    .success-card {
        background: linear-gradient(135deg, #FFFFFF 0%, #F8F7F4 100%);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    }
    
    .success-icon {
        background: linear-gradient(135deg, #10B981 0%, #059669 100%);
        animation: successPulse 2s ease-in-out infinite;
    }
    
    @keyframes successPulse {
        0%, 100% { transform: scale(1); }
        50% { transform: scale(1.05); }
    }
    
    .order-details {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(229, 231, 235, 0.5);
    }
</style>
@endsection

@section('content')
<main class="min-h-screen py-16">
    <div class="max-w-4xl mx-auto px-6 md:px-10">
        <!-- Success Card -->
        <div class="success-card rounded-3xl p-8 md:p-12 text-center mb-8">
            <!-- Success Icon -->
            <div class="success-icon w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                <i data-lucide="check" class="w-10 h-10 text-white"></i>
            </div>
            
            <!-- Success Message -->
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Order Confirmed!</h1>
            <p class="text-lg text-gray-600 mb-8">Thank you for your order. We've received your payment and will begin processing your custom cabinets.</p>
            
            <!-- Email Notification -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-8 max-w-2xl mx-auto">
                <div class="flex items-center">
                    <i data-lucide="mail" class="w-5 h-5 text-blue-600 mr-3"></i>
                    <div class="text-left">
                        <p class="text-blue-800 font-medium">Confirmation Email Sent</p>
                        <p class="text-blue-600 text-sm">We've sent a detailed confirmation email to <strong>{{ $order->customer_email }}</strong> with your order details and tracking information.</p>
                    </div>
                </div>
            </div>
            
            <!-- Order Summary -->
            <div class="order-details rounded-2xl p-6 mb-8 max-w-2xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-3">Order Details</h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Order Number:</span>
                                <span class="font-semibold text-gray-900">{{ $order->order_number }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Order Date:</span>
                                <span class="text-gray-900">{{ $order->created_at->format('M j, Y') }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Total Amount:</span>
                                <span class="font-bold text-primary text-lg">${{ number_format($order->total_amount, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Payment Method:</span>
                                <span class="text-gray-900">{{ ucfirst($order->payment_method) }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="font-semibold text-gray-900 mb-3">Shipping Information</h3>
                        @if($order->shipping_address)
                            <div class="text-sm text-gray-600">
                                <p>{{ $order->shipping_address['firstName'] ?? '' }} {{ $order->shipping_address['lastName'] ?? '' }}</p>
                                <p>{{ $order->shipping_address['address'] ?? '' }}</p>
                                @if(isset($order->shipping_address['apartment']) && $order->shipping_address['apartment'])
                                    <p>{{ $order->shipping_address['apartment'] }}</p>
                                @endif
                                <p>{{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['country'] ?? '' }} {{ $order->shipping_address['zipCode'] ?? '' }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('track-order') }}?order_number={{ $order->order_number }}&email={{ $order->customer_email }}" 
                   class="bg-primary-cta hover:bg-cta-hover text-white font-bold py-3 px-8 rounded-lg transition-all duration-300 transform hover:scale-105 flex items-center justify-center">
                    <i data-lucide="package-search" class="w-5 h-5 mr-2"></i>
                    Track Your Order
                </a>
                <a href="{{ route('shop') }}" 
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-3 px-8 rounded-lg transition-colors flex items-center justify-center">
                    <i data-lucide="shopping-bag" class="w-5 h-5 mr-2"></i>
                    Continue Shopping
                </a>
            </div>
        </div>
        
        <!-- Order Items -->
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-lg">
            <h3 class="text-2xl font-semibold text-gray-900 mb-6 flex items-center">
                <i data-lucide="package" class="w-6 h-6 mr-3 text-accent"></i>
                Your Order Items
            </h3>
            
            <div class="space-y-4">
                @foreach($order->orderItems as $item)
                    <div class="flex justify-between items-start p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-900">{{ $item->product_name }}</h4>
                            <p class="text-gray-600 text-sm">Quantity: {{ $item->quantity }}</p>
                            @if($item->assembly)
                                <span class="inline-flex items-center px-2 py-1 text-xs font-medium bg-green-100 text-green-800 rounded-full mt-2">
                                    <i data-lucide="wrench" class="w-3 h-3 mr-1"></i>
                                    Assembly Included
                                </span>
                            @endif
                        </div>
                        <div class="text-right">
                            <p class="font-semibold text-gray-900">${{ number_format($item->subtotal, 2) }}</p>
                            <p class="text-gray-500 text-sm">${{ number_format($item->unit_price, 2) }} each</p>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="mt-6 pt-4 border-t border-gray-200 flex justify-between items-center">
                <span class="text-lg font-semibold text-gray-900">Total</span>
                <span class="text-2xl font-bold text-primary">${{ number_format($order->total_amount, 2) }}</span>
            </div>
        </div>
        
        <!-- What's Next Section -->
        <div class="bg-white rounded-2xl p-6 md:p-8 shadow-lg mt-8">
            <h3 class="text-2xl font-semibold text-gray-900 mb-6 flex items-center">
                <i data-lucide="clock" class="w-6 h-6 mr-3 text-accent"></i>
                What Happens Next?
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="mail-check" class="w-8 h-8 text-blue-600"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">Order Confirmation</h4>
                    <p class="text-gray-600 text-sm">You'll receive an email confirmation shortly with your order details.</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="hammer" class="w-8 h-8 text-green-600"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">Production</h4>
                    <p class="text-gray-600 text-sm">Our craftsmen will begin creating your custom cabinets within 2-3 business days.</p>
                </div>
                
                <div class="text-center">
                    <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="truck" class="w-8 h-8 text-purple-600"></i>
                    </div>
                    <h4 class="font-semibold text-gray-900 mb-2">Delivery</h4>
                    <p class="text-gray-600 text-sm">Your order will be shipped in 2-4 weeks. You'll receive tracking information.</p>
                </div>
            </div>
        </div>
        
        <!-- Support Section -->
        <div class="bg-gray-50 rounded-2xl p-6 md:p-8 mt-8 text-center">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Need Help?</h3>
            <p class="text-gray-600 mb-6">Our customer support team is here to assist you with any questions.</p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('contact') }}" 
                   class="bg-accent hover:bg-accent-hover text-white font-medium py-3 px-6 rounded-lg transition-colors flex items-center justify-center">
                    <i data-lucide="mail" class="w-4 h-4 mr-2"></i>
                    Contact Support
                </a>
                <a href="tel:+1234567890" 
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-3 px-6 rounded-lg transition-colors flex items-center justify-center">
                    <i data-lucide="phone" class="w-4 h-4 mr-2"></i>
                    (123) 456-7890
                </a>
            </div>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
        
        // Clear the cart since the order is complete
        localStorage.removeItem('cart');
        
        // Update cart display
        if (typeof updateCartDisplay === 'function') {
            updateCartDisplay();
        }
    });
</script>
@endsection