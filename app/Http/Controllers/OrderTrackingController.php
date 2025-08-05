<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderTrackingController extends Controller
{
    /**
     * Show the order tracking form
     */
    public function index(Request $request)
    {
        // Check if order details are pre-filled from success page
        if ($request->has('order_number') && $request->has('email')) {
            $order = Order::where('order_number', $request->order_number)
                         ->where('customer_email', $request->email)
                         ->with(['orderItems', 'user'])
                         ->first();
            
            if ($order) {
                $timeline = $this->getOrderTimeline($order);
                return view('order-tracking', compact('order', 'timeline'));
            }
        }
        
        return view('order-tracking');
    }

    /**
     * Track an order by order number and email
     */
    public function track(Request $request)
    {
        $request->validate([
            'order_number' => 'required|string',
            'email' => 'required|email',
        ]);

        $order = Order::where('order_number', $request->order_number)
                     ->where('customer_email', $request->email)
                     ->with(['orderItems', 'user'])
                     ->first();

        if (!$order) {
            return back()->withErrors([
                'order_not_found' => 'Order not found. Please check your order number and email address.'
            ])->withInput();
        }

        $timeline = $this->getOrderTimeline($order);
        
        return view('order-tracking', compact('order', 'timeline'));
    }

    /**
     * Get order status timeline
     */
    private function getOrderTimeline($order)
    {
        $timeline = [];
        
        // Order Placed
        $timeline[] = [
            'status' => 'Order Placed',
            'description' => 'Your order has been received and is being processed.',
            'date' => $order->created_at,
            'completed' => true,
            'icon' => 'shopping-cart'
        ];

        // Payment Status
        if ($order->payment_status === 'paid') {
            $timeline[] = [
                'status' => 'Payment Confirmed',
                'description' => 'Your payment has been successfully processed.',
                'date' => $order->updated_at,
                'completed' => true,
                'icon' => 'credit-card'
            ];
        }

        // Order Status Timeline
        $statuses = [
            'pending' => ['Processing', 'Your order is being prepared.', 'clock'],
            'processing' => ['In Production', 'Your cabinets are being crafted.', 'tools'],
            'shipped' => ['Shipped', 'Your order is on its way to you.', 'truck'],
            'completed' => ['Delivered', 'Your order has been delivered.', 'check-circle']
        ];

        foreach ($statuses as $status_key => $status_info) {
            $completed = false;
            $current_statuses = ['pending', 'processing', 'shipped', 'completed'];
            $current_index = array_search($order->status, $current_statuses);
            $status_index = array_search($status_key, $current_statuses);
            
            if ($status_index <= $current_index) {
                $completed = true;
            }

            $timeline[] = [
                'status' => $status_info[0],
                'description' => $status_info[1],
                'date' => $completed ? $order->updated_at : null,
                'completed' => $completed,
                'icon' => $status_info[2]
            ];
        }

        return $timeline;
    }
}
