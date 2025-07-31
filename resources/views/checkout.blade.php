@extends('layouts.app')

@section('title', 'Checkout - Aura Cabinets')

@section('styles')
<style>
    /* Checkout page specific styles */
    body {
        background-color: #ffffff; /* White background for checkout */
        padding-bottom: 0; /* Remove padding for checkout */
    }
    
    /* Custom styles for checkout */
    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #D1D5DB; /* gray-300 */
        border-radius: 0.5rem;
        transition: border-color 0.3s, box-shadow 0.3s;
    }
    .form-input:focus {
        outline: none;
        border-color: #2D2D2D;
        box-shadow: 0 0 0 2px rgba(45, 45, 45, 0.2);
    }
    .order-summary {
        background-color: #F8F7F4; /* Lightest brown background */
    }
    .step-item.active {
         color: #2D2D2D;
         font-weight: 600;
    }
    .step-item.active .step-indicator {
         background-color: #2D2D2D;
         color: white;
    }
    .step-indicator {
         background-color: #EAEAEA;
         color: #6B7280;
    }
    
    /* Hide header and footer for checkout */
    #main-header, footer {
        display: none;
    }
    
    /* Remove top padding since no header */
    main {
        padding-top: 0;
    }
</style>
@endsection

@section('content')
<main class="w-full">
    <div class="grid grid-cols-1 lg:grid-cols-2 min-h-screen">
        <!-- Left Column: Form -->
        <div class="py-12 px-6 md:px-12 lg:px-16 order-2 lg:order-1">
            <div class="max-w-lg mx-auto lg:mx-0 lg:max-w-none">
                 <div class="text-left mb-10">
                    <a href="{{ route('home') }}" class="text-3xl font-bold">AURA</a>
                </div>
                
                <!-- Stepper -->
                <nav class="flex items-center text-sm font-medium text-gray-500 mb-10">
                    <div class="step-item flex items-center active">
                        <div class="step-indicator w-6 h-6 rounded-full flex items-center justify-center mr-2">1</div>
                        <span>Shipping</span>
                    </div>
                    <i data-lucide="chevron-right" class="w-5 h-5 mx-2 text-gray-300"></i>
                    <div class="step-item flex items-center">
                        <div class="step-indicator w-6 h-6 rounded-full flex items-center justify-center mr-2">2</div>
                        <span>Payment</span>
                    </div>
                </nav>

                <!-- Shipping Form -->
                <div id="shipping-step">
                    <h2 class="text-xl font-semibold mb-2">Contact Information</h2>
                    <input type="email" placeholder="Email Address" class="form-input mb-6">
                    
                    <h2 class="text-xl font-semibold mb-4">Shipping Address</h2>
                    <div class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <input type="text" placeholder="First Name" class="form-input">
                            <input type="text" placeholder="Last Name" class="form-input">
                        </div>
                        <input type="text" placeholder="Company (optional)" class="form-input">
                        <input type="text" placeholder="Address" class="form-input">
                        <input type="text" placeholder="Apartment, suite, etc. (optional)" class="form-input">
                         <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <input type="text" placeholder="City" class="form-input">
                            <select class="form-input">
                                <option>United States</option>
                            </select>
                            <input type="text" placeholder="ZIP code" class="form-input">
                        </div>
                        <input type="tel" placeholder="Phone" class="form-input">
                    </div>

                    <div class="mt-8">
                        <button class="w-full btn-minimal text-lg font-bold py-3.5 px-8 rounded-md">
                            Continue to Payment
                        </button>
                        <a href="{{ route('shop') }}" class="block text-center mt-4 text-accent font-medium">
                            <i data-lucide="arrow-left" class="inline w-4 h-4 mr-1"></i>
                            Return to cart
                        </a>
                    </div>
                </div>

                <!-- Payment Form (Hidden by default) -->
                <div id="payment-step" class="hidden">
                   <div class="border rounded-lg p-4 mb-6">
                       <div class="flex justify-between items-center text-sm">
                           <div class="text-gray-600">
                               <span class="block">Contact</span>
                               <span class="font-medium text-primary">customer@email.com</span>
                           </div>
                           <button class="text-accent text-xs font-medium hover:underline">Change</button>
                       </div>
                       <hr class="my-3 border-secondary">
                       <div class="flex justify-between items-center text-sm">
                           <div class="text-gray-600">
                               <span class="block">Ship to</span>
                               <span class="font-medium text-primary">123 Design Lane, New York, NY 10001</span>
                           </div>
                           <button class="text-accent text-xs font-medium hover:underline">Change</button>
                       </div>
                   </div>

                   <h2 class="text-xl font-semibold mb-4">Payment</h2>
                   <p class="text-sm text-gray-500 mb-4">All transactions are secure and encrypted.</p>
                   <div class="space-y-4">
                        <div class="border rounded-lg p-4 flex items-center has-[:checked]:bg-gray-50 has-[:checked]:border-black">
                            <input type="radio" id="credit-card" name="payment-method" class="h-4 w-4 text-accent focus:ring-accent" checked>
                            <label for="credit-card" class="ml-3 block text-sm font-medium text-primary">
                                Credit Card
                            </label>
                        </div>
                        <!-- Credit Card Form -->
                        <div class="border rounded-lg p-4 space-y-4">
                            <input type="text" placeholder="Card number" class="form-input">
                            <input type="text" placeholder="Name on card" class="form-input">
                            <div class="grid grid-cols-2 gap-4">
                                <input type="text" placeholder="Expiration date (MM / YY)" class="form-input">
                                <input type="text" placeholder="Security code" class="form-input">
                            </div>
                        </div>
                   </div>
                   
                    <h2 class="text-xl font-semibold mt-8 mb-4">Billing Address</h2>
                    <div class="space-y-3">
                         <div class="border rounded-lg p-4 flex items-center has-[:checked]:bg-gray-50 has-[:checked]:border-black">
                            <input type="radio" id="billing-same" name="billing-address" class="h-4 w-4 text-accent focus:ring-accent" checked>
                            <label for="billing-same" class="ml-3 block text-sm font-medium text-primary">
                                Same as shipping address
                            </label>
                        </div>
                         <div class="border rounded-lg p-4 flex items-center has-[:checked]:bg-gray-50 has-[:checked]:border-black">
                            <input type="radio" id="billing-different" name="billing-address" class="h-4 w-4 text-accent focus:ring-accent">
                            <label for="billing-different" class="ml-3 block text-sm font-medium text-primary">
                                Use a different billing address
                            </label>
                        </div>
                    </div>

                   <div class="mt-8">
                        <button class="w-full btn-minimal text-lg font-bold py-3.5 px-8 rounded-md">
                            Pay Now
                        </button>
                   </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column: Order Summary -->
        <div class="order-summary py-12 px-6 md:px-12 lg:px-16 order-1 lg:order-2">
            <div class="max-w-lg mx-auto lg:mx-0 lg:max-w-none lg:sticky lg:top-12">
                 <h2 class="text-xl font-semibold mb-6">Order Summary</h2>
                 <div class="space-y-4">
                    <!-- Summary Item 1 -->
                    <div class="flex items-center gap-4">
                        <div class="relative">
                           <img src="https://placehold.co/80x80/EAEAEA/333333?text=WSS+B15" alt="Weston Sand Shaker B15" class="w-20 h-20 rounded-lg object-cover">
                           <span class="absolute -top-2 -right-2 bg-gray-600 text-white text-xs w-6 h-6 rounded-full flex items-center justify-center">2</span>
                        </div>
                        <div class="flex-grow">
                            <p class="font-medium">Weston Sand Shaker - B15 Base</p>
                            <p class="text-sm text-gray-500">Assembly: Yes</p>
                        </div>
                        <p class="font-medium">$420.00</p>
                    </div>
                     <!-- Summary Item 2 -->
                    <div class="flex items-center gap-4">
                        <div class="relative">
                           <img src="https://placehold.co/80x80/D6C7B9/333333?text=WSS+W1230" alt="Weston Sand Shaker W1230" class="w-20 h-20 rounded-lg object-cover">
                           <span class="absolute -top-2 -right-2 bg-gray-600 text-white text-xs w-6 h-6 rounded-full flex items-center justify-center">1</span>
                        </div>
                        <div class="flex-grow">
                            <p class="font-medium">Weston Sand Shaker - W1230 Wall</p>
                            <p class="text-sm text-gray-500">Assembly: No</p>
                        </div>
                        <p class="font-medium">$120.00</p>
                    </div>
                 </div>

                 <div class="mt-8 pt-6 border-t border-gray-300 flex gap-4">
                    <input type="text" placeholder="Discount code" class="form-input bg-white w-full">
                    <button class="btn-minimal px-5 rounded-md text-sm font-bold disabled:opacity-50" disabled>Apply</button>
                 </div>

                 <div class="mt-6 pt-6 border-t border-gray-300 space-y-3">
                    <div class="flex justify-between text-sm">
                        <span>Subtotal</span>
                        <span>$540.00</span>
                    </div>
                     <div class="flex justify-between text-sm">
                        <span>Shipping</span>
                        <span class="font-semibold">$50.00</span>
                    </div>
                     <div class="flex justify-between text-sm">
                        <span>Taxes</span>
                        <span>$43.20</span>
                    </div>
                 </div>

                 <div class="mt-6 pt-6 border-t border-gray-300">
                    <div class="flex justify-between items-center font-semibold text-lg">
                            <span>Total</span>
                            <span class="text-xl font-bold">$633.20</span>
                        </div>
                 </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // This is a placeholder for the stepper logic.
        // In a real application, you would add JS to show/hide the payment step
        // and handle form validation.
        lucide.createIcons();
    });
</script>
@endsection 