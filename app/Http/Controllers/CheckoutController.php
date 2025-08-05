<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\ApiException;
use App\Models\Order;
use App\Models\OrderItem;
use App\Mail\OrderConfirmation;

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
            
            // Check if Stripe is properly configured
            $stripeSecret = config('services.stripe.secret');
            if (empty($stripeSecret)) {
                Log::error('Stripe secret key is not configured');
                return response()->json(['error' => 'Payment service not configured'], 500);
            }
            
            Log::info('Stripe secret key exists: ' . (!empty($stripeSecret) ? 'yes' : 'no'));
            
            // Set Stripe API key
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
        } catch (ApiException $e) {
            Log::error('Stripe API error: ' . $e->getMessage());
            return response()->json(['error' => 'Payment setup failed: ' . $e->getMessage()], 500);
        } catch (\Exception $e) {
            Log::error('Stripe payment intent creation failed: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(['error' => 'Payment setup failed: ' . $e->getMessage()], 500);
        }
    }

    public function processPayment(Request $request)
    {
        try {
            Log::info('Payment processing started', [
                'request_data' => $request->all()
            ]);

            $validated = $request->validate([
                'payment_method' => 'required|in:stripe,paypal',
                'payment_intent_id' => 'required_if:payment_method,stripe',
                'paypal_order_id' => 'required_if:payment_method,paypal',
                'customer_info' => 'required|array',
                'cart_items' => 'required|array',
                'total_amount' => 'required|numeric',
            ]);

            Log::info('Payment validation passed', [
                'validated_data' => $validated
            ]);

            // Calculate shipping cost (you can implement your shipping logic here)
            $shippingCost = 0; // Default to free shipping, you can calculate based on your logic
            
            // Create order in database
            Log::info('Creating order...');
            $order = Order::create([
                'user_id' => auth()->id() ?? null,
                'order_number' => 'ORD-' . uniqid(),
                'total_amount' => $validated['total_amount'],
                'shipping_cost' => $shippingCost,
                'status' => 'pending',
                'payment_method' => $validated['payment_method'],
                'payment_status' => 'pending',
                'customer_email' => $validated['customer_info']['email'],
                'shipping_address' => json_encode($validated['customer_info']['shipping']),
                'billing_address' => json_encode($validated['customer_info']['billing'] ?? $validated['customer_info']['shipping']),
            ]);
            Log::info('Order created successfully', ['order_id' => $order->id]);

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
                    
                    // Send order confirmation email
                    try {
                        Mail::to($order->customer_email)->send(new OrderConfirmation($order));
                        Log::info('Order confirmation email sent successfully', ['order_id' => $order->id, 'email' => $order->customer_email]);
                    } catch (\Exception $e) {
                        Log::error('Failed to send order confirmation email: ' . $e->getMessage(), ['order_id' => $order->id]);
                        // Don't fail the order if email fails
                    }
                    
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
                
                // Send order confirmation email
                try {
                    Mail::to($order->customer_email)->send(new OrderConfirmation($order));
                    Log::info('Order confirmation email sent successfully', ['order_id' => $order->id, 'email' => $order->customer_email]);
                } catch (\Exception $e) {
                    Log::error('Failed to send order confirmation email: ' . $e->getMessage(), ['order_id' => $order->id]);
                    // Don't fail the order if email fails
                }
                
                return response()->json([
                    'success' => true,
                    'order_id' => $order->id,
                    'message' => 'Payment successful!'
                ]);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed: ' . $e->getMessage(), [
                'errors' => $e->errors()
            ]);
            return response()->json(['error' => 'Validation failed: ' . $e->getMessage()], 422);
        } catch (\Exception $e) {
            Log::error('Payment processing failed: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(['error' => 'Payment processing failed: ' . $e->getMessage()], 500);
        }
    }

    public function success($orderId)
    {
        $order = Order::findOrFail($orderId);
        return view('checkout.success', compact('order'));
    }
} 