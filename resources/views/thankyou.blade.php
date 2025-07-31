@extends('layouts.app')

@section('title', 'Thank You for Your Order - Aura Cabinets')

@section('content')
<main>
    <div class="max-w-4xl mx-auto px-6 md:px-10 py-12 md:py-20">
        <div class="bg-white rounded-xl shadow-sm p-8 md:p-12 text-center">
            
            <div class="flex justify-center mb-6">
                <div class="bg-green-100 p-3 rounded-full">
                    <i data-lucide="check" class="w-10 h-10 text-green-600"></i>
                </div>
            </div>

            <p class="text-lg font-semibold text-accent">Payment Successful</p>
            <h1 class="text-4xl md:text-5xl font-light mt-2">Thank you for your order!</h1>
            
            <p class="mt-4 text-gray-600 max-w-2xl mx-auto">
                Your order <span class="font-semibold text-primary">#AUR-10542</span> has been placed. A confirmation email with your order details has been sent to your email address.
            </p>

            <div class="text-center mt-10">
                <a href="/" class="btn-minimal text-lg font-bold py-3 px-8 rounded-md transition-colors duration-300">
                    Continue Shopping
                </a>
            </div>

        </div>

        <!-- Order Details Section -->
        <div class="mt-12">
             <h2 class="text-2xl font-semibold mb-6">Your Order Details</h2>
             <div class="bg-white rounded-xl shadow-sm p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Shipping & Payment Details -->
                    <div>
                        <h3 class="font-semibold mb-3">Shipping Address</h3>
                        <p class="text-gray-600 text-sm">
                            John Doe<br>
                            123 Design Lane<br>
                            New York, NY 10001<br>
                            United States
                        </p>
                        <h3 class="font-semibold mt-6 mb-3">Payment Method</h3>
                         <p class="text-gray-600 text-sm flex items-center">
                            <i data-lucide="credit-card" class="w-4 h-4 mr-2"></i>
                            Ending in 1234
                        </p>
                    </div>
                    <!-- Order Summary -->
                    <div>
                        <h3 class="font-semibold mb-3">Order Summary</h3>
                        <div class="space-y-2 text-sm">
                             <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span>$540.00</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Shipping</span>
                                <span>$50.00</span>
                            </div>
                             <div class="flex justify-between">
                                <span class="text-gray-600">Taxes</span>
                                <span>$43.20</span>
                            </div>
                            <div class="flex justify-between font-bold text-base pt-2 border-t border-secondary">
                                <span>Total</span>
                                <span>$633.20</span>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="my-8 border-secondary">

                <!-- Items Ordered -->
                <h3 class="font-semibold mb-4">Items Ordered</h3>
                <div class="space-y-4">
                   <!-- Item 1 -->
                   <div class="flex items-center gap-4 text-sm">
                        <img src="https://placehold.co/80x80/EAEAEA/333333?text=WSS+B15" alt="Weston Sand Shaker B15" class="w-16 h-16 rounded-lg object-cover">
                        <div class="flex-grow">
                            <p class="font-medium">Weston Sand Shaker - B15 Base (x2)</p>
                            <p class="text-xs text-gray-500">Assembly: Yes</p>
                        </div>
                        <p class="font-medium">$420.00</p>
                    </div>
                    <!-- Item 2 -->
                    <div class="flex items-center gap-4 text-sm">
                        <img src="https://placehold.co/80x80/D6C7B9/333333?text=WSS+W1230" alt="Weston Sand Shaker W1230" class="w-16 h-16 rounded-lg object-cover">
                        <div class="flex-grow">
                            <p class="font-medium">Weston Sand Shaker - W1230 Wall (x1)</p>
                            <p class="text-xs text-gray-500">Assembly: No</p>
                        </div>
                        <p class="font-medium">$120.00</p>
                    </div>
                </div>
             </div>
        </div>
    </div>
</main>
@endsection 