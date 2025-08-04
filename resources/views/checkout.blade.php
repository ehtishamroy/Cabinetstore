@extends('layouts.app')

@section('title', 'Checkout - BH Cabinetry')

@section('styles')
<style>
    /* Checkout page specific styles */
    body {
        background-color: #ffffff;
        padding-bottom: 0;
    }
    
    .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #D1D5DB;
        border-radius: 0.5rem;
        transition: border-color 0.3s, box-shadow 0.3s;
    }
    .form-input:focus {
        outline: none;
        border-color: #2D2D2D;
        box-shadow: 0 0 0 2px rgba(45, 45, 45, 0.2);
    }
    .order-summary {
        background-color: #F8F7F4;
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
    
    main {
        padding-top: 0;
    }

    /* Payment method styles */
    .payment-method {
        border: 2px solid #EAEAEA;
        border-radius: 0.5rem;
        padding: 1rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .payment-method:hover {
        border-color: #2D2D2D;
    }
    .payment-method.selected {
        border-color: #2D2D2D;
        background-color: #F8F7F4;
    }

    /* Loading spinner */
    .loading {
        display: inline-block;
        width: 20px;
        height: 20px;
        border: 3px solid #f3f3f3;
        border-top: 3px solid #2D2D2D;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Error message styles */
    .error-message {
        color: #dc2626;
        background-color: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 0.5rem;
        padding: 0.75rem;
        margin-bottom: 1rem;
    }

    /* Success message styles */
    .success-message {
        color: #059669;
        background-color: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-radius: 0.5rem;
        padding: 0.75rem;
        margin-bottom: 1rem;
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
                    <a href="/" class="text-3xl font-bold">BH CABINETRY</a>
                </div>
                
                <!-- Stepper -->
                <nav class="flex items-center text-sm font-medium text-gray-500 mb-10">
                    <div class="step-item flex items-center active" id="shipping-step-indicator">
                        <div class="step-indicator w-6 h-6 rounded-full flex items-center justify-center mr-2">1</div>
                        <span>Shipping</span>
                    </div>
                    <i data-lucide="chevron-right" class="w-5 h-5 mx-2 text-gray-300"></i>
                    <div class="step-item flex items-center" id="payment-step-indicator">
                        <div class="step-indicator w-6 h-6 rounded-full flex items-center justify-center mr-2">2</div>
                        <span>Payment</span>
                    </div>
                </nav>

                <!-- Error/Success Messages -->
                <div id="message-container"></div>

                <!-- Shipping Form -->
                <div id="shipping-step">
                    <h2 class="text-xl font-semibold mb-2">Contact Information</h2>
                    <input type="email" id="customer-email" placeholder="Email Address" class="form-input mb-6" required>
                    
                    <h2 class="text-xl font-semibold mb-4">Shipping Address</h2>
                    <form id="shipping-form" class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <input type="text" id="first-name" placeholder="First Name" class="form-input" required>
                            <input type="text" id="last-name" placeholder="Last Name" class="form-input" required>
                        </div>
                        <input type="text" id="company" placeholder="Company (optional)" class="form-input">
                        <input type="text" id="address" placeholder="Address" class="form-input" required>
                        <input type="text" id="apartment" placeholder="Apartment, suite, etc. (optional)" class="form-input">
                         <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <input type="text" id="city" placeholder="City" class="form-input" required>
                            <select id="country" class="form-input" required>
                                <option value="US">United States</option>
                                <option value="CA">Canada</option>
                            </select>
                            <input type="text" id="zip-code" placeholder="ZIP code" class="form-input" required>
                        </div>
                        <input type="tel" id="phone" placeholder="Phone" class="form-input" required>
                    </form>

                    <div class="mt-8">
                        <button id="continue-to-payment" class="w-full btn-minimal text-lg font-bold py-3.5 px-8 rounded-md">
                            Continue to Payment
                        </button>
                        <a href="/cart" class="block text-center mt-4 text-accent font-medium">
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
                               <span id="summary-email" class="font-medium text-primary"></span>
                           </div>
                           <button type="button" onclick="backToShipping()" class="text-accent text-xs font-medium hover:underline">Change</button>
                       </div>
                       <hr class="my-3 border-secondary">
                       <div class="flex justify-between items-center text-sm">
                           <div class="text-gray-600">
                               <span class="block">Ship to</span>
                               <span id="summary-address" class="font-medium text-primary"></span>
                           </div>
                           <button type="button" onclick="backToShipping()" class="text-accent text-xs font-medium hover:underline">Change</button>
                       </div>
                   </div>

                   <h2 class="text-xl font-semibold mb-4">Payment Method</h2>
                   <p class="text-sm text-gray-500 mb-4">All transactions are secure and encrypted.</p>
                   
                   <div class="space-y-4 mb-6">
                        <div class="payment-method" data-method="stripe">
                            <div class="flex items-center">
                                <input type="radio" id="stripe" name="payment-method" value="stripe" class="h-4 w-4 text-accent focus:ring-accent" checked>
                                <label for="stripe" class="ml-3 block text-sm font-medium text-primary">
                                    Credit Card (Stripe)
                                </label>
                            </div>
                        </div>
                        <div class="payment-method" data-method="paypal">
                            <div class="flex items-center">
                                <input type="radio" id="paypal" name="payment-method" value="paypal" class="h-4 w-4 text-accent focus:ring-accent">
                                <label for="paypal" class="ml-3 block text-sm font-medium text-primary">
                                    PayPal
                                </label>
                            </div>
                        </div>
                   </div>

                   <!-- Stripe Payment Form -->
                   <div id="stripe-payment-form" class="space-y-4">
                        <div class="border rounded-lg p-4 space-y-4">
                            <div id="card-element" class="form-input">
                                <!-- Stripe Elements will be inserted here -->
                            </div>
                            <div id="card-errors" class="text-red-500 text-sm hidden"></div>
                        </div>
                   </div>

                   <!-- PayPal Button -->
                   <div id="paypal-button-container" class="hidden">
                        <div id="paypal-button"></div>
                   </div>
                   
                   <h2 class="text-xl font-semibold mt-8 mb-4">Billing Address</h2>
                   <div class="space-y-3">
                         <div class="border rounded-lg p-4 flex items-center">
                            <input type="radio" id="billing-same" name="billing-address" class="h-4 w-4 text-accent focus:ring-accent" checked>
                            <label for="billing-same" class="ml-3 block text-sm font-medium text-primary">
                                Same as shipping address
                            </label>
                        </div>
                         <div class="border rounded-lg p-4 flex items-center">
                            <input type="radio" id="billing-different" name="billing-address" class="h-4 w-4 text-accent focus:ring-accent">
                            <label for="billing-different" class="ml-3 block text-sm font-medium text-primary">
                                Use a different billing address
                            </label>
                        </div>
                    </div>

                   <div class="mt-8">
                        <button id="pay-now-btn" class="w-full btn-minimal text-lg font-bold py-3.5 px-8 rounded-md">
                            Pay Now
                        </button>
                        <button id="back-to-shipping" onclick="backToShipping()" class="w-full bg-gray-200 text-gray-800 text-lg font-bold py-3.5 px-8 rounded-md mt-4">
                            Back to Shipping
                        </button>
                   </div>
                </div>
            </div>
        </div>
        
        <!-- Right Column: Order Summary -->
        <div class="order-summary py-12 px-6 md:px-12 lg:px-16 order-1 lg:order-2">
            <div class="max-w-lg mx-auto lg:mx-0 lg:max-w-none lg:sticky lg:top-12">
                 <h2 class="text-xl font-semibold mb-6">Order Summary</h2>
                 <div id="cart-items-summary" class="space-y-4">
                    <!-- Cart items will be populated here -->
                 </div>

                 <div class="mt-8 pt-6 border-t border-gray-300 flex gap-4">
                    <input type="text" placeholder="Discount code" class="form-input bg-white w-full">
                    <button class="btn-minimal px-5 rounded-md text-sm font-bold disabled:opacity-50" disabled>Apply</button>
                 </div>

                 <div class="mt-6 pt-6 border-t border-gray-300 space-y-3">
                     <div class="flex justify-between text-sm">
                         <span>Subtotal</span>
                         <span id="subtotal">$0.00</span>
                     </div>
                     <div class="flex justify-between text-sm">
                         <span>Shipping</span>
                         <span class="font-semibold">$50.00</span>
                     </div>
                 </div>

                 <div class="mt-6 pt-6 border-t border-gray-300">
                    <div class="flex justify-between items-center font-semibold text-lg">
                            <span>Total</span>
                            <span id="total" class="text-xl font-bold">$0.00</span>
                        </div>
                 </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<!-- Stripe.js -->
<script src="https://js.stripe.com/v3/"></script>
<!-- PayPal SDK -->
<script src="https://www.paypal.com/sdk/js?client-id={{ config('services.paypal.client_id') }}&currency=USD"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        lucide.createIcons();
        
        // Initialize variables
        let stripe;
        let card;
        let paymentIntent;
        let cart = JSON.parse(localStorage.getItem('cart')) || {};
        
        // Initialize Stripe
        function initializeStripe() {
            stripe = Stripe('{{ config("services.stripe.key") }}');
            const elements = stripe.elements();
            card = elements.create('card', {
                style: {
                    base: {
                        fontSize: '16px',
                        color: '#424770',
                        '::placeholder': {
                            color: '#aab7c4',
                        },
                    },
                    invalid: {
                        color: '#9e2146',
                    },
                },
            });
            card.mount('#card-element');
            
            card.addEventListener('change', function(event) {
                const displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                    displayError.classList.remove('hidden');
                } else {
                    displayError.textContent = '';
                    displayError.classList.add('hidden');
                }
            });
        }
        
        // Initialize PayPal
        function initializePayPal() {
            paypal.Buttons({
                createOrder: async function(data, actions) {
                    const total = await calculateTotal();
                    return actions.order.create({
                        purchase_units: [{
                            amount: {
                                value: (total / 100).toFixed(2)
                            }
                        }]
                    });
                },
                onApprove: function(data, actions) {
                    return actions.order.capture().then(function(details) {
                        processPayment('paypal', null, details.id);
                    });
                }
            }).render('#paypal-button');
        }
        
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

        // Load cart data
        async function loadCartData() {
            // Load shipping settings first
            await loadShippingSettings();
            
            const cartItemsContainer = document.getElementById('cart-items-summary');
            let itemsHtml = '';
            let subtotal = 0;
            
            Object.keys(cart).forEach(productId => {
                const item = cart[productId];
                const itemTotal = item.qty * item.unitPrice + (item.assembly ? item.qty * item.laborCost : 0);
                subtotal += itemTotal;
                
                // Use subcategory image if available, otherwise use placeholder
                const imageUrl = item.imageUrl || `https://placehold.co/80x80/EAEAEA/333333?text=${encodeURIComponent(item.name)}`;
                
                itemsHtml += `
                    <div class="flex items-center gap-4">
                        <div class="relative">
                           <img src="${imageUrl}" alt="${item.name}" class="w-20 h-20 rounded-lg object-cover">
                           <span class="absolute -top-2 -right-2 bg-gray-600 text-white text-xs w-6 h-6 rounded-full flex items-center justify-center">${item.qty}</span>
                        </div>
                        <div class="flex-grow">
                            <p class="font-medium">${item.name}</p>
                            <p class="text-sm text-gray-500">Assembly: ${item.assembly ? 'Yes' : 'No'}</p>
                        </div>
                        <p class="font-medium">$${itemTotal.toFixed(2)}</p>
                    </div>
                `;
            });
            
            cartItemsContainer.innerHTML = itemsHtml;
            
            const shipping = calculateShippingCost(subtotal);
            const total = subtotal + shipping;
            
            document.getElementById('subtotal').textContent = `$${subtotal.toFixed(2)}`;
            document.getElementById('total').textContent = `$${total.toFixed(2)}`;
            
            // Update shipping display
            const shippingElement = document.querySelector('.flex.justify-between.text-sm:nth-child(2) span:last-child');
            if (shippingElement) {
                if (shipping === 0) {
                    shippingElement.textContent = 'Free';
                    shippingElement.classList.add('text-green-600', 'font-semibold');
                } else {
                    shippingElement.textContent = `$${shipping.toFixed(2)}`;
                    shippingElement.classList.remove('text-green-600', 'font-semibold');
                }
            }
            
            return total;
        }
        
        // Calculate total for payment
        async function calculateTotal() {
            // Ensure shipping settings are loaded
            await loadShippingSettings();
            
            let subtotal = 0;
            Object.keys(cart).forEach(productId => {
                const item = cart[productId];
                const itemTotal = item.qty * item.unitPrice + (item.assembly ? item.qty * item.laborCost : 0);
                subtotal += itemTotal;
            });
            
            const shipping = calculateShippingCost(subtotal);
            return Math.round((subtotal + shipping) * 100); // Convert to cents
        }
        
        // Show message
        function showMessage(message, type = 'error') {
            const container = document.getElementById('message-container');
            container.innerHTML = `<div class="${type === 'error' ? 'error-message' : 'success-message'}">${message}</div>`;
        }
        
        // Continue to payment
        document.getElementById('continue-to-payment').addEventListener('click', function() {
            const email = document.getElementById('customer-email').value;
            const firstName = document.getElementById('first-name').value;
            const lastName = document.getElementById('last-name').value;
            const address = document.getElementById('address').value;
            const city = document.getElementById('city').value;
            const zipCode = document.getElementById('zip-code').value;
            const phone = document.getElementById('phone').value;
            
            if (!email || !firstName || !lastName || !address || !city || !zipCode || !phone) {
                showMessage('Please fill in all required fields.');
                return;
            }
            
            // Update summary
            document.getElementById('summary-email').textContent = email;
            document.getElementById('summary-address').textContent = `${address}, ${city}, ${zipCode}`;
            
            // Switch to payment step
            document.getElementById('shipping-step').classList.add('hidden');
            document.getElementById('payment-step').classList.remove('hidden');
            document.getElementById('shipping-step-indicator').classList.remove('active');
            document.getElementById('payment-step-indicator').classList.add('active');
            
            // Initialize payment methods
            initializeStripe();
            initializePayPal();
        });
        
        // Payment method selection
        document.querySelectorAll('input[name="payment-method"]').forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'stripe') {
                    document.getElementById('stripe-payment-form').classList.remove('hidden');
                    document.getElementById('paypal-button-container').classList.add('hidden');
                } else {
                    document.getElementById('stripe-payment-form').classList.add('hidden');
                    document.getElementById('paypal-button-container').classList.remove('hidden');
                }
            });
        });
        
        // Back to shipping
        window.backToShipping = function() {
            document.getElementById('payment-step').classList.add('hidden');
            document.getElementById('shipping-step').classList.remove('hidden');
            document.getElementById('payment-step-indicator').classList.remove('active');
            document.getElementById('shipping-step-indicator').classList.add('active');
        };
        
        // Process payment
        async function processPayment(method, paymentIntentId = null, paypalOrderId = null) {
            const payButton = document.getElementById('pay-now-btn');
            const originalText = payButton.innerHTML;
            payButton.innerHTML = '<span class="loading"></span> Processing...';
            payButton.disabled = true;
            
            try {
                const customerInfo = {
                    email: document.getElementById('customer-email').value,
                    shipping: {
                        firstName: document.getElementById('first-name').value,
                        lastName: document.getElementById('last-name').value,
                        company: document.getElementById('company').value,
                        address: document.getElementById('address').value,
                        apartment: document.getElementById('apartment').value,
                        city: document.getElementById('city').value,
                        country: document.getElementById('country').value,
                        zipCode: document.getElementById('zip-code').value,
                        phone: document.getElementById('phone').value,
                    }
                };
                
                const cartItems = Object.keys(cart).map(productId => ({
                    product_id: productId,
                    ...cart[productId]
                }));
                
                const response = await fetch('/checkout/process-payment', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify({
                        payment_method: method,
                        payment_intent_id: paymentIntentId,
                        paypal_order_id: paypalOrderId,
                        customer_info: customerInfo,
                        cart_items: cartItems,
                        total_amount: calculateTotal() / 100
                    })
                });
                
                const result = await response.json();
                
                if (result.success) {
                    // Clear cart
                    localStorage.removeItem('cart');
                    // Redirect to success page
                    window.location.href = `/checkout/success/${result.order_id}`;
                } else {
                    showMessage(result.error || 'Payment failed. Please try again.');
                }
            } catch (error) {
                showMessage('An error occurred. Please try again.');
                console.error('Payment error:', error);
            } finally {
                payButton.innerHTML = originalText;
                payButton.disabled = false;
            }
        }
        
        // Pay now button
        document.getElementById('pay-now-btn').addEventListener('click', async function() {
            const selectedMethod = document.querySelector('input[name="payment-method"]:checked').value;
            
            if (selectedMethod === 'stripe') {
                // Create payment intent
                try {
                    console.log('Creating payment intent...');
                    const total = await calculateTotal();
                    console.log('Total amount:', total);
                    
                    const response = await fetch('/checkout/create-payment-intent', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        },
                        body: JSON.stringify({
                            amount: total
                        })
                    });
                    
                    console.log('Response status:', response.status);
                    const result = await response.json();
                    console.log('Response result:', result);
                    
                    if (result.clientSecret) {
                        paymentIntent = result.paymentIntentId;
                        
                        // Confirm payment
                        const { error } = await stripe.confirmCardPayment(result.clientSecret, {
                            payment_method: {
                                card: card,
                                billing_details: {
                                    name: document.getElementById('first-name').value + ' ' + document.getElementById('last-name').value,
                                    email: document.getElementById('customer-email').value,
                                }
                            }
                        });
                        
                        if (error) {
                            showMessage(error.message);
                        } else {
                            processPayment('stripe', paymentIntent);
                        }
                    } else {
                        showMessage(result.error || 'Failed to create payment intent.');
                    }
                } catch (error) {
                    showMessage('An error occurred. Please try again.');
                    console.error('Payment intent error:', error);
                }
            } else {
                // PayPal payment is handled by the PayPal button
                showMessage('Please use the PayPal button above to complete your payment.');
            }
        });
        
        // Load initial data
        if (Object.keys(cart).length === 0) {
            window.location.href = '/cart';
        } else {
            loadCartData();
        }
    });
</script>
@endsection 