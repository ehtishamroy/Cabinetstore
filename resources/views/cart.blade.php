@extends('layouts.app')

@section('title', 'Shopping Cart - BH Cabinetry')

@section('content')
<main class="pt-32 pb-16">
    <div class="max-w-7xl mx-auto px-6 md:px-10">
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <div class="flex items-center space-x-2 text-sm text-gray-600">
                <a href="{{ route('home') }}" class="hover:underline">Home</a>
                <span>/</span>
                <span class="text-gray-400">Cart</span>
            </div>
        </nav>

        <!-- Page Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-light mb-4">Shopping Cart</h1>
            <p class="text-gray-600 max-w-2xl mx-auto">Review your selected items and proceed to checkout</p>
        </div>

        <!-- Cart Content -->
        <div id="cart-content" class="max-w-4xl mx-auto">
            <!-- Cart Items will be populated by JavaScript -->
        </div>

        <!-- Empty Cart State -->
        <div id="empty-cart" class="hidden text-center py-16">
            <div class="max-w-md mx-auto">
                <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i data-lucide="shopping-cart" class="w-12 h-12 text-gray-400"></i>
                </div>
                <h2 class="text-2xl font-semibold mb-4">Your cart is empty</h2>
                <p class="text-gray-600 mb-8">Looks like you haven't added any items to your cart yet.</p>
                <a href="{{ route('shop') }}" class="bg-accent text-white px-8 py-3 rounded-lg font-semibold hover:bg-orange-600 transition-colors duration-200">
                    Start Shopping
                </a>
            </div>
        </div>
    </div>
</main>


@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cartContent = document.getElementById('cart-content');
    const emptyCart = document.getElementById('empty-cart');

    // Load cart data from localStorage
    let cart = JSON.parse(localStorage.getItem('cart')) || {};

    // Load shipping settings
    let shippingSettings = {
        free_shipping_threshold: 2500,
        default_shipping_rate: 50
    };

    // Fetch shipping settings from backend
    async function loadShippingSettings() {
        try {
            const response = await fetch('/api/shipping-settings');
            const data = await response.json();
            shippingSettings = data;
        } catch (error) {
            console.error('Error loading shipping settings:', error);
        }
    }

    // Calculate shipping cost
    function calculateShippingCost(subtotal) {
        if (subtotal >= shippingSettings.free_shipping_threshold) {
            return 0;
        }
        return shippingSettings.default_shipping_rate;
    }

    async function renderCart() {
        // Load shipping settings first
        await loadShippingSettings();
        
        const itemCount = Object.keys(cart).length;
        
        if (itemCount === 0) {
            cartContent.classList.add('hidden');
            emptyCart.classList.remove('hidden');
            return;
        }

        cartContent.classList.remove('hidden');
        emptyCart.classList.add('hidden');

        let total = 0;
        let itemsHtml = '';

        Object.keys(cart).forEach(productId => {
            const item = cart[productId];
            const itemTotal = item.qty * item.unitPrice + (item.assembly ? item.qty * item.laborCost : 0);
            total += itemTotal;

            itemsHtml += `
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold mb-2">${item.name}</h3>
                            <div class="text-sm text-gray-600 space-y-1">
                                <p>Quantity: ${item.qty}</p>
                                <p>Unit Price: $${item.unitPrice.toFixed(2)}</p>
                                <p>Assembly: ${item.assembly ? 'Yes (+$${item.laborCost.toFixed(2)} each)' : 'No'}</p>
                            </div>
                        </div>
                        <div class="text-right ml-6">
                            <div class="text-xl font-bold mb-2">$${itemTotal.toFixed(2)}</div>
                            <button onclick="removeFromCart('${productId}')" class="text-sm text-red-500 hover:text-red-700 font-medium">
                                Remove
                            </button>
                        </div>
                    </div>
                </div>
            `;
        });

        const shipping = calculateShippingCost(total);
        const finalTotal = total + shipping;

        cartContent.innerHTML = `
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2">
                    <h2 class="text-2xl font-semibold mb-6">Cart Items (${itemCount})</h2>
                    ${itemsHtml}
                </div>
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 sticky top-32">
                        <h3 class="text-xl font-semibold mb-4">Order Summary</h3>
                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-semibold">$${total.toFixed(2)}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Shipping</span>
                                <span class="font-semibold ${shipping === 0 ? 'text-green-600' : ''}">${shipping === 0 ? 'Free' : '$' + shipping.toFixed(2)}</span>
                            </div>
                            <hr class="border-gray-200">
                            <div class="flex justify-between text-lg">
                                <span class="font-semibold">Total</span>
                                <span class="font-bold">$${finalTotal.toFixed(2)}</span>
                            </div>
                        </div>
                                    <a href="{{ route('checkout') }}" class="w-full bg-gray-900 text-white py-3 px-6 rounded-lg font-semibold hover:bg-black transition-colors duration-200 mb-4 inline-block text-center">
                Proceed to Checkout
            </a>
                        <button onclick="clearCart()" class="w-full bg-gray-200 text-gray-800 py-2 px-6 rounded-lg font-semibold hover:bg-gray-300 transition-colors duration-200">
                            Clear Cart
                        </button>
                    </div>
                </div>
            </div>
        `;
    }

    // Remove from cart function
    window.removeFromCart = function(productId) {
        delete cart[productId];
        localStorage.setItem('cart', JSON.stringify(cart));
        renderCart();
        
        // Update header cart count
        const cartCount = document.getElementById('cart-count');
        if (cartCount) {
            const itemCount = Object.keys(cart).length;
            cartCount.textContent = itemCount;
            cartCount.style.display = itemCount === 0 ? 'none' : 'flex';
        }
    };

    // Clear cart function
    window.clearCart = function() {
        cart = {};
        localStorage.setItem('cart', JSON.stringify(cart));
        renderCart();
        
        // Update header cart count
        const cartCount = document.getElementById('cart-count');
        if (cartCount) {
            cartCount.textContent = '0';
            cartCount.style.display = 'none';
        }
    };



    // Initialize cart display
    renderCart();
});
</script>
@endsection 