<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('checkout');
    }

    public function createPaymentIntent(Request $request)
    {
        try {
            Log::info('Creating payment intent with amount: ' . $request->input('amount'));
            
            // Set your Stripe secret key
            $stripeSecret = config('services.stripe.secret');
            Log::info('Stripe secret key exists: ' . (!empty($stripeSecret) ? 'yes' : 'no'));
            
            Stripe::setApiKey($stripeSecret);

            $amount = $request->input('amount'); // Amount in cents
            $currency = 'usd';

            Log::info('Creating Stripe PaymentIntent with amount: ' . $amount . ' and currency: ' . $currency);

            $paymentIntent = PaymentIntent::create([
                'amount' => $amount,
                'currency' => $currency,
                'automatic_payment_methods' => [
                    'enabled' => true,
                ],
                'metadata' => [
                    'order_id' => uniqid('order_'),
                ],
            ]);

            Log::info('PaymentIntent created successfully: ' . $paymentIntent->id);

            return response()->json([
                'clientSecret' => $paymentIntent->client_secret,
                'paymentIntentId' => $paymentIntent->id,
            ]);
        } catch (\Exception $e) {
            Log::error('Stripe payment intent creation failed: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(['error' => 'Payment setup failed: ' . $e->getMessage()], 500);
        }
    }

    public function processPayment(Request $request)
    {
        try {
            $validated = $request->validate([
                'payment_method' => 'required|in:stripe,paypal',
                'payment_intent_id' => 'required_if:payment_method,stripe',
                'paypal_order_id' => 'required_if:payment_method,paypal',
                'customer_info' => 'required|array',
                'cart_items' => 'required|array',
                'total_amount' => 'required|numeric',
            ]);

            // Create order in database
            $order = Order::create([
                'user_id' => auth()->id() ?? null,
                'order_number' => 'ORD-' . uniqid(),
                'total_amount' => $validated['total_amount'],
                'status' => 'pending',
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'pending',
                'customer_email' => $validated['customer_info']['email'],
                'shipping_address' => json_encode($validated['customer_info']['shipping']),
                'billing_address' => json_encode($validated['customer_info']['billing'] ?? $validated['customer_info']['shipping']),
            ]);

            // Create order items
            foreach ($validated['cart_items'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['name'],
                    'quantity' => $item['qty'],
                    'unit_price' => $item['unitPrice'],
                    'labor_cost' => $item['laborCost'] ?? 0,
                    'assembly' => $item['assembly'] ?? false,
                    'subtotal' => $item['qty'] * $item['unitPrice'] + ($item['assembly'] ? $item['qty'] * ($item['laborCost'] ?? 0) : 0),
                ]);
            }

            // Process payment based on method
            if ($validated['payment_method'] === 'stripe') {
                // Verify Stripe payment
                Stripe::setApiKey(config('services.stripe.secret'));
                $paymentIntent = PaymentIntent::retrieve($validated['payment_intent_id']);
                
                if ($paymentIntent->status === 'succeeded') {
                    $order->update([
                        'payment_status' => 'paid',
                        'status' => 'processing',
                    ]);
                    
                    return response()->json([
                        'success' => true,
                        'order_id' => $order->id,
                        'message' => 'Payment successful!'
                    ]);
                } else {
                    $order->update(['payment_status' => 'failed']);
                    return response()->json(['error' => 'Payment failed'], 400);
                }
            } else {
                // PayPal payment verification would go here
                // For now, we'll assume it's successful
                $order->update([
                    'payment_status' => 'paid',
                    'status' => 'processing',
                ]);
                
                return response()->json([
                    'success' => true,
                    'order_id' => $order->id,
                    'message' => 'Payment successful!'
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Payment processing failed: ' . $e->getMessage());
            return response()->json(['error' => 'Payment processing failed'], 500);
        }
    }

    public function success($orderId)
    {
        $order = Order::findOrFail($orderId);
        return view('checkout.success', compact('order'));
    }
} 