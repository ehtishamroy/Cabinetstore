@extends('layouts.app')

@section('title', 'Track Your Order - BH Cabinetry')

@section('styles')
<style>
    .timeline-item {
        position: relative;
    }
    
    .timeline-item:not(:last-child)::after {
        content: '';
        position: absolute;
        left: 1.25rem;
        top: 2.5rem;
        width: 2px;
        height: calc(100% - 1rem);
        background-color: #E5E7EB;
    }
    
    .timeline-item.completed:not(:last-child)::after {
        background-color: #10B981;
    }
    
    .timeline-icon {
        position: relative;
        z-index: 10;
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 3px solid #E5E7EB;
        background-color: white;
        transition: all 0.3s ease;
    }
    
    .timeline-icon.completed {
        border-color: #10B981;
        background-color: #10B981;
        color: white;
    }
    
    .order-card {
        background: linear-gradient(135deg, #F8F7F4 0%, #FFFFFF 100%);
        border: 1px solid #E5E7EB;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
    }
    
    .tracking-form {
        background: linear-gradient(135deg, #2D2D2D 0%, #1A1A1A 100%);
    }
</style>
@endsection

@section('content')
<main class="min-h-screen">
    <!-- Hero Section -->
    <section class="tracking-form text-white py-16">
        <div class="max-w-4xl mx-auto px-6 md:px-10 text-center">
            <h1 class="text-4xl md:text-5xl font-semibold mb-4">Track Your Order</h1>
            <p class="text-lg text-gray-300 mb-8">Enter your order details to see the current status and tracking information</p>
            
            @if(!isset($order))
                <div class="max-w-md mx-auto">
                    <form action="{{ route('track-order.search') }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="text-left">
                            <label for="order_number" class="block text-sm font-medium text-gray-300 mb-2">Order Number</label>
                            <input type="text" 
                                   id="order_number" 
                                   name="order_number" 
                                   value="{{ old('order_number') }}"
                                   placeholder="e.g., ORD-12345" 
                                   class="w-full px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent"
                                   required>
                        </div>
                        
                        <div class="text-left">
                            <label for="email" class="block text-sm font-medium text-gray-300 mb-2">Email Address</label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}"
                                   placeholder="Enter your email address" 
                                   class="w-full px-4 py-3 rounded-lg bg-white/10 border border-white/20 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-white/50 focus:border-transparent"
                                   required>
                        </div>
                        
                        @if($errors->has('order_not_found'))
                            <div class="bg-red-500/20 border border-red-500/50 text-red-100 px-4 py-3 rounded-lg text-sm">
                                {{ $errors->first('order_not_found') }}
                            </div>
                        @endif
                        
                        <button type="submit" class="w-full bg-primary-cta hover:bg-cta-hover text-white font-bold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105">
                            Track Order
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </section>

    @if(isset($order))
        <!-- Order Found Section -->
        <section class="py-16 bg-gray-50">
            <div class="max-w-6xl mx-auto px-6 md:px-10">
                <!-- Order Header -->
                <div class="order-card rounded-2xl p-8 mb-8">
                    <div class="flex flex-col lg:flex-row lg:justify-between lg:items-center mb-6">
                        <div>
                            <h2 class="text-3xl font-semibold text-primary mb-2">Order {{ $order->order_number }}</h2>
                            <p class="text-gray-600">Placed on {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
                        </div>
                        <div class="mt-4 lg:mt-0 text-left lg:text-right">
                            <div class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold
                                {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                   ($order->status === 'processing' ? 'bg-blue-100 text-blue-800' : 
                                   ($order->status === 'shipped' ? 'bg-purple-100 text-purple-800' : 'bg-yellow-100 text-yellow-800')) }}">
                                <i data-lucide="package" class="w-4 h-4 mr-2"></i>
                                {{ ucfirst($order->status) }}
                            </div>
                            <p class="text-2xl font-bold text-primary mt-2">${{ number_format($order->total_amount, 2) }}</p>
                        </div>
                    </div>
                    
                    <!-- Customer Info -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t border-gray-200">
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-2">Customer Information</h3>
                            <p class="text-gray-600">{{ $order->customer_email }}</p>
                            @if($order->user)
                                <p class="text-gray-600">{{ $order->user->name }}</p>
                            @else
                                <p class="text-gray-500 text-sm">Guest Customer</p>
                            @endif
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 mb-2">Shipping Address</h3>
                            @if($order->shipping_address)
                                <div class="text-gray-600 text-sm">
                                    <p>{{ $order->shipping_address['firstName'] ?? '' }} {{ $order->shipping_address['lastName'] ?? '' }}</p>
                                    <p>{{ $order->shipping_address['address'] ?? '' }}</p>
                                    <p>{{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['state'] ?? '' }} {{ $order->shipping_address['zipCode'] ?? '' }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Order Timeline -->
                    <div class="order-card rounded-2xl p-8">
                        <h3 class="text-2xl font-semibold text-primary mb-6 flex items-center">
                            <i data-lucide="clock" class="w-6 h-6 mr-3 text-accent"></i>
                            Order Progress
                        </h3>
                        
                        <div class="space-y-6">
                            @foreach($timeline as $step)
                                <div class="timeline-item {{ $step['completed'] ? 'completed' : '' }} flex items-start">
                                    <div class="timeline-icon {{ $step['completed'] ? 'completed' : '' }}">
                                        <i data-lucide="{{ $step['icon'] }}" class="w-4 h-4"></i>
                                    </div>
                                    <div class="ml-6 flex-1">
                                        <h4 class="font-semibold text-gray-900">{{ $step['status'] }}</h4>
                                        <p class="text-gray-600 text-sm mt-1">{{ $step['description'] }}</p>
                                        @if($step['date'])
                                            <p class="text-gray-500 text-xs mt-2">{{ $step['date']->format('M j, Y \a\t g:i A') }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Order Items -->
                    <div class="order-card rounded-2xl p-8">
                        <h3 class="text-2xl font-semibold text-primary mb-6 flex items-center">
                            <i data-lucide="package" class="w-6 h-6 mr-3 text-accent"></i>
                            Order Items
                        </h3>
                        
                        <div class="space-y-4">
                            @foreach($order->orderItems as $item)
                                <div class="flex justify-between items-start p-4 bg-white rounded-lg border border-gray-200">
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
                        
                        <div class="mt-6 pt-4 border-t border-gray-200">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-semibold text-gray-900">Total</span>
                                <span class="text-2xl font-bold text-primary">${{ number_format($order->total_amount, 2) }}</span>
                            </div>
                            <p class="text-gray-500 text-sm mt-1">Payment via {{ ucfirst($order->payment_method) }} - 
                                <span class="font-medium {{ $order->payment_status === 'paid' ? 'text-green-600' : 'text-yellow-600' }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-8 text-center">
                    <a href="{{ route('track-order') }}" class="inline-block bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-3 px-6 rounded-lg transition-colors mr-4">
                        Track Another Order
                    </a>
                    <a href="{{ route('contact') }}" class="inline-block bg-primary-cta hover:bg-cta-hover text-white font-medium py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105">
                        Contact Support
                    </a>
                </div>
            </div>
        </section>
    @endif

    <!-- Help Section -->
    <section class="py-16 bg-white">
        <div class="max-w-4xl mx-auto px-6 md:px-10 text-center">
            <h2 class="text-3xl font-semibold text-primary mb-4">Need Help?</h2>
            <p class="text-gray-600 mb-8">Can't find your order or have questions about your delivery?</p>
            
                         <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="p-6 rounded-lg border border-gray-200 hover:shadow-lg transition-shadow">
                    <i data-lucide="mail" class="w-8 h-8 text-accent mx-auto mb-4"></i>
                    <h3 class="font-semibold text-gray-900 mb-2">Email Support</h3>
                    <p class="text-gray-600 text-sm mb-4">Get help via email within 24 hours</p>
                    <a href="{{ route('contact') }}" class="text-accent hover:text-accent-hover font-medium">Contact Us</a>
                </div>
                
                <div class="p-6 rounded-lg border border-gray-200 hover:shadow-lg transition-shadow">
                    <i data-lucide="phone" class="w-8 h-8 text-accent mx-auto mb-4"></i>
                    <h3 class="font-semibold text-gray-900 mb-2">Phone Support</h3>
                    <p class="text-gray-600 text-sm mb-4">Speak with our team directly</p>
                    <a href="tel:+18324225140" class="text-accent hover:text-accent-hover font-medium">(832) 422-5140</a>
                </div>
                
                
            </div>
        </div>
    </section>
</main>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });
</script>
@endsection