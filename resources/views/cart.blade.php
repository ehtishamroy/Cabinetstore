@extends('layouts.app')

@section('title', 'Shopping Cart - Aura Cabinets')

@section('styles')
<style>
    /* Cart page specific styles */
    body {
        background-color: #F8F7F4; /* Lightest brown background */
    }
    
    #main-header {
        position: sticky;
        top: 0;
        background-color: rgba(248, 247, 244, 0.8); /* Match body bg */
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border-bottom: 1px solid #EAEAEA;
    }
</style>
@endsection

@section('content')
<main>
    <div class="max-w-7xl mx-auto px-6 md:px-10 py-12 md:py-20">
        <div class="text-left mb-10">
            <h1 class="text-4xl md:text-5xl font-light">Shopping Cart</h1>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12 items-start">
            <!-- Left Column: Cart Items -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6 md:p-8">
                <div class="space-y-6">
                    <!-- Cart Item 1 -->
                    <div class="cart-item flex flex-col sm:flex-row items-start gap-6 pb-6 border-b border-secondary">
                        <img src="https://placehold.co/120x120/EAEAEA/333333?text=WSS+B15" alt="Weston Sand Shaker B15" class="w-32 h-32 rounded-lg object-cover flex-shrink-0">
                        <div class="flex-grow">
                            <h3 class="font-semibold text-lg">Weston Sand Shaker - B15 Base</h3>
                            <p class="text-sm text-gray-500">Assembly: Yes (+ $35.00)</p>
                            <p class="text-sm text-gray-500">Hinge: L</p>
                        </div>
                        <div class="flex flex-col items-end gap-3 w-full sm:w-auto">
                            <p class="font-semibold text-lg item-price" data-unit-price="210">$420.00</p>
                            <div class="flex items-center border border-secondary rounded-md">
                                <button class="quantity-change px-3 py-1" data-change="-1">-</button>
                                <input type="number" class="quantity-input w-12 text-center focus:outline-none" value="2" min="1">
                                <button class="quantity-change px-3 py-1" data-change="1">+</button>
                            </div>
                            <button class="remove-item text-xs text-red-500 hover:underline">Remove</button>
                        </div>
                    </div>

                    <!-- Cart Item 2 -->
                    <div class="cart-item flex flex-col sm:flex-row items-start gap-6 pb-6 border-b border-secondary">
                        <img src="https://placehold.co/120x120/D6C7B9/333333?text=WSS+W1230" alt="Weston Sand Shaker W1230" class="w-32 h-32 rounded-lg object-cover flex-shrink-0">
                        <div class="flex-grow">
                            <h3 class="font-semibold text-lg">Weston Sand Shaker - W1230 Wall</h3>
                            <p class="text-sm text-gray-500">Assembly: No</p>
                            <p class="text-sm text-gray-500">Hinge: R</p>
                        </div>
                        <div class="flex flex-col items-end gap-3 w-full sm:w-auto">
                            <p class="font-semibold text-lg item-price" data-unit-price="120">$120.00</p>
                            <div class="flex items-center border border-secondary rounded-md">
                                <button class="quantity-change px-3 py-1" data-change="-1">-</button>
                                <input type="number" class="quantity-input w-12 text-center focus:outline-none" value="1" min="1">
                                <button class="quantity-change px-3 py-1" data-change="1">+</button>
                            </div>
                            <button class="remove-item text-xs text-red-500 hover:underline">Remove</button>
                        </div>
                    </div>
                    
                     <!-- Cart Item 3 -->
                    <div class="cart-item flex flex-col sm:flex-row items-start gap-6">
                        <img src="https://placehold.co/120x120/374151/FFFFFF?text=Handle+10" alt="Matte Black Handle" class="w-32 h-32 rounded-lg object-cover flex-shrink-0">
                        <div class="flex-grow">
                            <h3 class="font-semibold text-lg">Matte Black Handle - Pack of 10</h3>
                            <p class="text-sm text-gray-500">Hardware</p>
                        </div>
                        <div class="flex flex-col items-end gap-3 w-full sm:w-auto">
                            <p class="font-semibold text-lg item-price" data-unit-price="45">$45.00</p>
                            <div class="flex items-center border border-secondary rounded-md">
                                <button class="quantity-change px-3 py-1" data-change="-1">-</button>
                                <input type="number" class="quantity-input w-12 text-center focus:outline-none" value="1" min="1">
                                <button class="quantity-change px-3 py-1" data-change="1">+</button>
                            </div>
                            <button class="remove-item text-xs text-red-500 hover:underline">Remove</button>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-secondary">
                    <a href="{{ route('shop') }}" class="text-accent font-medium flex items-center gap-2">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                        Continue Shopping
                    </a>
                </div>
            </div>

            <!-- Right Column: Order Summary -->
            <div class="lg:col-span-1 w-full">
                <div class="bg-white rounded-xl shadow-sm p-6 md:p-8 sticky top-28">
                    <h2 class="text-2xl font-semibold border-b border-secondary pb-4 mb-4">Order Summary</h2>
                    <div class="space-y-3 text-gray-700">
                        <div class="flex justify-between">
                            <span>Subtotal</span>
                            <span id="summary-subtotal">$585.00</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Shipping</span>
                            <span>Calculated at next step</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Taxes</span>
                            <span>Calculated at next step</span>
                        </div>
                    </div>
                    <div class="mt-6 pt-6 border-t border-secondary">
                        <div class="flex justify-between items-center font-semibold text-lg">
                            <span>Estimated Total</span>
                            <span id="summary-total">$585.00</span>
                        </div>
                    </div>
                    <div class="mt-8">
                        <a href="{{ route('checkout') }}" class="w-full btn-minimal text-lg font-bold py-3 px-8 rounded-md inline-block text-center">
                            Proceed to Checkout
                        </a>
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
        const cartItemsContainer = document.querySelector('.lg\\:col-span-2');

        function updateItemPrice(cartItem) {
            const priceEl = cartItem.querySelector('.item-price');
            const quantityInput = cartItem.querySelector('.quantity-input');
            
            const unitPrice = parseFloat(priceEl.dataset.unitPrice);
            const quantity = parseInt(quantityInput.value);
            const itemTotal = unitPrice * quantity;
            
            priceEl.textContent = `$${itemTotal.toFixed(2)}`;
            updateOrderSummary();
        }

        function updateOrderSummary() {
            let subtotal = 0;
            document.querySelectorAll('.cart-item').forEach(item => {
                const priceEl = item.querySelector('.item-price');
                const quantityInput = item.querySelector('.quantity-input');
                subtotal += parseFloat(priceEl.dataset.unitPrice) * parseInt(quantityInput.value);
            });

            const subtotalEl = document.getElementById('summary-subtotal');
            const totalEl = document.getElementById('summary-total');

            subtotalEl.textContent = `$${subtotal.toFixed(2)}`;
            totalEl.textContent = `$${subtotal.toFixed(2)}`;
        }

        cartItemsContainer.addEventListener('click', function(e) {
            const cartItem = e.target.closest('.cart-item');
            if (!cartItem) return;

            // Handle quantity changes
            if (e.target.matches('.quantity-change')) {
                const quantityInput = cartItem.querySelector('.quantity-input');
                let newQuantity = parseInt(quantityInput.value) + parseInt(e.target.dataset.change);
                if (newQuantity < 1) newQuantity = 1;
                quantityInput.value = newQuantity;
                updateItemPrice(cartItem);
            }

            // Handle remove item
            if (e.target.matches('.remove-item')) {
                cartItem.remove();
                updateOrderSummary();
            }
        });

        cartItemsContainer.addEventListener('change', function(e) {
            if(e.target.matches('.quantity-input')) {
                const cartItem = e.target.closest('.cart-item');
                if (parseInt(e.target.value) < 1) {
                    e.target.value = 1;
                }
                updateItemPrice(cartItem);
            }
        });

        // Initial calculation
        updateOrderSummary();
        lucide.createIcons();
    });
</script>
@endsection 