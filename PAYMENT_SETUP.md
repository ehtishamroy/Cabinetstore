# Payment Integration Setup Guide

## Stripe Setup

1. **Get Stripe API Keys:**
   - Go to [Stripe Dashboard](https://dashboard.stripe.com/)
   - Sign up or log in to your account
   - Go to Developers > API keys
   - Copy your Publishable key and Secret key

2. **Add to .env file:**
   ```
   STRIPE_KEY=pk_test_your_publishable_key_here
   STRIPE_SECRET=sk_test_your_secret_key_here
   STRIPE_WEBHOOK_SECRET=whsec_your_webhook_secret_here
   ```

## PayPal Setup

1. **Get PayPal API Credentials:**
   - Go to [PayPal Developer Dashboard](https://developer.paypal.com/)
   - Sign up or log in to your account
   - Go to My Apps & Credentials
   - Create a new app or use an existing one
   - Copy your Client ID and Secret

2. **Add to .env file:**
   ```
   PAYPAL_CLIENT_ID=your_client_id_here
   PAYPAL_CLIENT_SECRET=your_secret_here
   PAYPAL_MODE=sandbox
   ```

## Testing

### Stripe Test Cards:
- **Success:** 4242 4242 4242 4242
- **Decline:** 4000 0000 0000 0002
- **Expiry:** Any future date
- **CVC:** Any 3 digits

### PayPal Testing:
- Use the PayPal sandbox environment
- Create test accounts in PayPal Developer Dashboard
- Use test buyer accounts for payment testing

## Features Implemented

✅ **Stripe Integration:**
- Secure payment processing
- Real-time card validation
- Payment intent creation
- Payment confirmation

✅ **PayPal Integration:**
- PayPal button integration
- Order creation and capture
- Sandbox environment support

✅ **Checkout Flow:**
- Dynamic cart loading
- Shipping information collection
- Payment method selection
- Order creation and storage
- Success page with order details

✅ **Security Features:**
- CSRF protection
- Input validation
- Secure payment processing
- Error handling

## Usage

1. **Add items to cart** from the product pages
2. **Go to cart** and click "Proceed to Checkout"
3. **Fill shipping information** and continue to payment
4. **Select payment method** (Stripe or PayPal)
5. **Complete payment** using test credentials
6. **View order confirmation** on success page

## Notes

- This is set up for **sandbox/testing** environment
- For production, change `PAYPAL_MODE` to `live`
- Update Stripe keys to live keys for production
- Add proper error handling and logging for production use 