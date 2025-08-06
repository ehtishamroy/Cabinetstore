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
    .form-input:invalid {
        border-color: #dc2626;
    }
    .form-input:invalid:focus {
        border-color: #dc2626;
        box-shadow: 0 0 0 2px rgba(220, 38, 38, 0.2);
    }
    .required-field::after {
        content: " *";
        color: #dc2626;
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

    /* Stripe card element styles */
    #card-element {
        background-color: #ffffff;
        border: 1px solid #D1D5DB;
        border-radius: 0.5rem;
        padding: 0.75rem 1rem;
        min-height: 50px;
        transition: border-color 0.3s, box-shadow 0.3s;
    }
    
    #card-element:focus-within {
        border-color: #2D2D2D;
        box-shadow: 0 0 0 2px rgba(45, 45, 45, 0.2);
    }
    
    #card-element.StripeElement--invalid {
        border-color: #dc2626;
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
                    <a href="{{ route('home') }}" class="text-3xl font-bold">BH CABINETRY</a>
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
                 
                 <!-- Localhost Testing Notice -->
                 

                <!-- Shipping Form -->
                <div id="shipping-step">
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-sm text-blue-800">
                            <i data-lucide="info" class="w-4 h-4 inline mr-1"></i>
                            Fields marked with <span class="text-red-600 font-semibold">*</span> are required
                        </p>
                    </div>
                    
                    <h2 class="text-xl font-semibold mb-2">Contact Information</h2>
                    <input type="email" id="customer-email" placeholder="Email Address *" class="form-input mb-6" required>
                    
                    <h2 class="text-xl font-semibold mb-4">Shipping Address</h2>
                    <form id="shipping-form" class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <input type="text" id="first-name" placeholder="First Name *" class="form-input" required>
                            <input type="text" id="last-name" placeholder="Last Name *" class="form-input" required>
                        </div>
                        <input type="text" id="company" placeholder="Company (optional)" class="form-input">
                        <input type="text" id="address" placeholder="Address *" class="form-input" required>
                        <input type="text" id="apartment" placeholder="Apartment, suite, etc. (optional)" class="form-input">
                         <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <input type="text" id="city" placeholder="City *" class="form-input" required>
                            <select id="state" class="form-input" required>
                                <option value="">Select State/Region *</option>
                                <!-- United States -->
                                <optgroup label="United States">
                                    <option value="AL">Alabama</option>
                                    <option value="AK">Alaska</option>
                                    <option value="AZ">Arizona</option>
                                    <option value="AR">Arkansas</option>
                                    <option value="CA">California</option>
                                    <option value="CO">Colorado</option>
                                    <option value="CT">Connecticut</option>
                                    <option value="DE">Delaware</option>
                                    <option value="DC">District of Columbia</option>
                                    <option value="FL">Florida</option>
                                    <option value="GA">Georgia</option>
                                    <option value="HI">Hawaii</option>
                                    <option value="ID">Idaho</option>
                                    <option value="IL">Illinois</option>
                                    <option value="IN">Indiana</option>
                                    <option value="IA">Iowa</option>
                                    <option value="KS">Kansas</option>
                                    <option value="KY">Kentucky</option>
                                    <option value="LA">Louisiana</option>
                                    <option value="ME">Maine</option>
                                    <option value="MD">Maryland</option>
                                    <option value="MA">Massachusetts</option>
                                    <option value="MI">Michigan</option>
                                    <option value="MN">Minnesota</option>
                                    <option value="MS">Mississippi</option>
                                    <option value="MO">Missouri</option>
                                    <option value="MT">Montana</option>
                                    <option value="NE">Nebraska</option>
                                    <option value="NV">Nevada</option>
                                    <option value="NH">New Hampshire</option>
                                    <option value="NJ">New Jersey</option>
                                    <option value="NM">New Mexico</option>
                                    <option value="NY">New York</option>
                                    <option value="NC">North Carolina</option>
                                    <option value="ND">North Dakota</option>
                                    <option value="OH">Ohio</option>
                                    <option value="OK">Oklahoma</option>
                                    <option value="OR">Oregon</option>
                                    <option value="PA">Pennsylvania</option>
                                    <option value="RI">Rhode Island</option>
                                    <option value="SC">South Carolina</option>
                                    <option value="SD">South Dakota</option>
                                    <option value="TN">Tennessee</option>
                                    <option value="TX">Texas</option>
                                    <option value="UT">Utah</option>
                                    <option value="VT">Vermont</option>
                                    <option value="VA">Virginia</option>
                                    <option value="WA">Washington</option>
                                    <option value="WV">West Virginia</option>
                                    <option value="WI">Wisconsin</option>
                                    <option value="WY">Wyoming</option>
                                </optgroup>
                                <!-- West Africa -->
                                <optgroup label="West Africa">
                                    <option value="NG">Nigeria</option>
                                    <option value="GH">Ghana</option>
                                    <option value="CI">Côte d'Ivoire</option>
                                    <option value="SN">Senegal</option>
                                    <option value="ML">Mali</option>
                                    <option value="BF">Burkina Faso</option>
                                    <option value="NE">Niger</option>
                                    <option value="TD">Chad</option>
                                    <option value="CM">Cameroon</option>
                                    <option value="CF">Central African Republic</option>
                                    <option value="CG">Republic of the Congo</option>
                                    <option value="CD">Democratic Republic of the Congo</option>
                                    <option value="GA">Gabon</option>
                                    <option value="GQ">Equatorial Guinea</option>
                                    <option value="ST">São Tomé and Príncipe</option>
                                    <option value="GW">Guinea-Bissau</option>
                                    <option value="GN">Guinea</option>
                                    <option value="SL">Sierra Leone</option>
                                    <option value="LR">Liberia</option>
                                    <option value="TG">Togo</option>
                                    <option value="BJ">Benin</option>
                                    <option value="MR">Mauritania</option>
                                    <option value="GM">Gambia</option>
                                    <option value="CV">Cape Verde</option>
                                </optgroup>
                            </select>
                            <input type="text" id="zip-code" placeholder="ZIP/Postal code *" class="form-input" required>
                        </div>
                        <input type="tel" id="phone" placeholder="Phone *" class="form-input" required>
                    </form>

                    <div class="mt-8">
                        <button id="continue-to-payment" class="w-full btn-minimal text-lg font-bold py-3.5 px-8 rounded-md">
                            Continue to Payment
                        </button>
                        <a href="{{ route('cart') }}" class="block text-center mt-4 text-accent font-medium">
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
                        <div class="border-2 border-gray-200 rounded-lg p-6 space-y-4 bg-white shadow-sm">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Card Information</label>
                            <div id="card-element" class="min-h-[50px]">
                                <!-- Stripe Elements will be inserted here -->
                            </div>
                            <div id="card-errors" class="text-red-500 text-sm hidden"></div>
                        </div>
                   </div>

                   <!-- PayPal Button -->
                   <div id="paypal-button-container" class="hidden">
                        <div id="paypal-button"></div>
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
<script src="https://www.paypal.com/sdk/js?client-id={{ config('services.paypal.client_id', 'test') }}&currency=USD"></script>

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
            const stripeKey = '{{ config("services.stripe.key") }}';
            if (!stripeKey || stripeKey === '') {
                console.error('Stripe key not configured');
                showMessage('Payment service not configured. Please contact support.', 'error');
                return;
            }
            stripe = Stripe(stripeKey);
            const elements = stripe.elements();
            card = elements.create('card', {
                style: {
                    base: {
                        fontSize: '16px',
                        color: '#2D2D2D',
                        backgroundColor: '#ffffff',
                        border: '1px solid #D1D5DB',
                        borderRadius: '8px',
                        padding: '12px 16px',
                        '::placeholder': {
                            color: '#6B7280',
                        },
                        ':-webkit-autofill': {
                            color: '#2D2D2D',
                        },
                    },
                    invalid: {
                        color: '#dc2626',
                        borderColor: '#dc2626',
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
    if (typeof paypal === 'undefined') {
        console.error('PayPal SDK not loaded');
        return;
    }
    
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

        // Show user-friendly error for ad blocker issues
        function showAdBlockerMessage() {
            const message = `
                <strong>Payment Issue Detected</strong><br>
                It looks like an ad blocker or browser extension is blocking payment processing. To complete your purchase:<br>
                <br>
                1. <strong>Disable your ad blocker</strong> for this website, or<br>
                2. Try using an <strong>incognito/private browsing window</strong><br>
                <br>
                Don't worry - your cart items are saved and will be here when you return!
            `;
            showMessage(message, 'error');
        }
        
        // Continue to payment
        document.getElementById('continue-to-payment').addEventListener('click', function() {
            const email = document.getElementById('customer-email').value.trim();
            const firstName = document.getElementById('first-name').value.trim();
            const lastName = document.getElementById('last-name').value.trim();
            const address = document.getElementById('address').value.trim();
            const city = document.getElementById('city').value.trim();
            const state = document.getElementById('state').value;
            const zipCode = document.getElementById('zip-code').value.trim();
            const phone = document.getElementById('phone').value.trim();
            
            // Validate required fields
            const requiredFields = [
                { value: email, name: 'Email Address' },
                { value: firstName, name: 'First Name' },
                { value: lastName, name: 'Last Name' },
                { value: address, name: 'Address' },
                { value: city, name: 'City' },
                { value: state, name: 'State/Region' },
                { value: zipCode, name: 'ZIP/Postal Code' },
                { value: phone, name: 'Phone' }
            ];
            
            const missingFields = requiredFields.filter(field => !field.value);
            
            if (missingFields.length > 0) {
                const fieldNames = missingFields.map(field => field.name).join(', ');
                showMessage(`Please fill in all required fields: ${fieldNames}`);
                return;
            }
            
            // Update summary
            document.getElementById('summary-email').textContent = email;
            document.getElementById('summary-address').textContent = `${address}, ${city}, ${state} ${zipCode}`;
            
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
             console.log('Processing payment with method:', method);
             console.log('Payment intent ID:', paymentIntentId);
             console.log('PayPal order ID:', paypalOrderId);
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
                        state: document.getElementById('state').value,
                        zipCode: document.getElementById('zip-code').value,
                        phone: document.getElementById('phone').value,
                    }
                };
                
                                 const cartItems = Object.keys(cart).map(productId => ({
                     product_id: productId,
                     ...cart[productId]
                 }));
                 
                 // Calculate total amount first
                 const totalAmount = await calculateTotal();
                 console.log('Calculated total amount:', totalAmount);
                 
                 const requestBody = {
                     payment_method: method,
                     payment_intent_id: paymentIntentId,
                     paypal_order_id: paypalOrderId,
                     customer_info: customerInfo,
                     cart_items: cartItems,
                     total_amount: totalAmount / 100
                 };
                 
                 console.log('Request body:', requestBody);
                 
                                  console.log('Making POST request to /checkout/process-payment');
                 console.log('CSRF Token:', document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || 'NOT FOUND');
                 
                 const response = await fetch('/checkout/process-payment', {
                     method: 'POST',
                     headers: {
                         'Content-Type': 'application/json',
                         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                         'Accept': 'application/json'
                     },
                     body: JSON.stringify(requestBody)
                 });
                
                                 if (!response.ok) {
                     const errorText = await response.text();
                     console.error('Process payment error response:', errorText);
                     showMessage('Payment processing failed. Please try again.');
                     return;
                 }
                 
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
                    
                    if (!response.ok) {
                        const errorText = await response.text();
                        console.error('Server error response:', errorText);
                        showMessage('Server error occurred. Please try again.');
                        return;
                    }
                    
                    const result = await response.json();
                    console.log('Response result:', result);
                    
                    if (result.clientSecret) {
                        paymentIntent = result.paymentIntentId;
                        
                        // Confirm payment
                        try {
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
                                console.error('Stripe error:', error);
                                // Check if it's a network/blocking issue
                                if (error.message && (error.message.includes('network') || error.message.includes('blocked') || error.message.includes('fetch'))) {
                                    showAdBlockerMessage();
                                } else {
                                    showMessage(error.message);
                                }
                            } else {
                                processPayment('stripe', paymentIntent);
                            }
                        } catch (confirmError) {
                            console.error('Payment confirmation error:', confirmError);
                            
                            // Check if it's a network blocking issue
                            if (confirmError.message && confirmError.message.includes('Failed to fetch')) {
                                showMessage('Payment blocked by browser extensions. Please disable ad-blockers or try in incognito mode.', 'error');
                            } else {
                                showMessage('Payment confirmation failed. Please try again.', 'error');
                            }
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
            window.location.href = '{{ route('cart') }}';
        } else {
            loadCartData();
        }
    });
</script>
@endsection 