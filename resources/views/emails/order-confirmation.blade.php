<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - BH Cabinetry</title>
    <style>
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #F8F7F4;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #2D2D2D 0%, #1A1A1A 100%);
            color: white;
            padding: 40px 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
            font-family: 'Instrument Sans', serif;
        }
        .header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 16px;
        }
        .content {
            padding: 40px 30px;
        }
        .success-icon {
            text-align: center;
            margin-bottom: 30px;
        }
        .success-icon .circle {
            width: 60px;
            height: 60px;
            background-color: #10B981;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
        }
        .order-number {
            background-color: #F3F4F6;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            text-align: center;
        }
        .order-number h2 {
            margin: 0 0 10px 0;
            color: #E86A33;
            font-size: 24px;
            font-weight: 600;
        }
        .order-number p {
            margin: 0;
            color: #6B7280;
            font-size: 14px;
        }
        .section {
            margin-bottom: 30px;
        }
        .section h3 {
            margin: 0 0 15px 0;
            color: #1F2937;
            font-size: 18px;
            font-weight: 600;
            border-bottom: 2px solid #E5E7EB;
            padding-bottom: 8px;
        }
        .customer-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }
        .info-box {
            background-color: #F9FAFB;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #E86A33;
        }
        .info-box h4 {
            margin: 0 0 10px 0;
            color: #374151;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .info-box p {
            margin: 0;
            color: #6B7280;
            font-size: 14px;
            line-height: 1.5;
        }
        .order-items {
            background-color: #F9FAFB;
            border-radius: 8px;
            overflow: hidden;
        }
        .item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            border-bottom: 1px solid #E5E7EB;
        }
        .item:last-child {
            border-bottom: none;
        }
        .item-details {
            flex: 1;
        }
        .item-name {
            font-weight: 600;
            color: #1F2937;
            margin-bottom: 5px;
        }
        .item-meta {
            font-size: 12px;
            color: #6B7280;
        }
        .item-price {
            font-weight: 600;
            color: #1F2937;
            text-align: right;
        }
        .order-summary {
            background-color: #F3F4F6;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .summary-row:last-child {
            margin-bottom: 0;
            padding-top: 10px;
            border-top: 1px solid #D1D5DB;
            font-weight: 600;
            font-size: 18px;
        }
        .total {
            color: #E86A33;
        }
        .footer {
            background-color: #F3F4F6;
            padding: 30px;
            text-align: center;
        }
        .footer h3 {
            margin: 0 0 15px 0;
            color: #1F2937;
            font-size: 18px;
            font-weight: 600;
        }
        .footer p {
            margin: 0 0 20px 0;
            color: #6B7280;
            font-size: 14px;
        }
        .cta-button {
            display: inline-block;
            background-color: #E86A33;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 14px;
            transition: background-color 0.3s;
        }
        .cta-button:hover {
            background-color: #F18E6A;
        }
        .contact-info {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #E5E7EB;
        }
        .contact-info p {
            margin: 5px 0;
            font-size: 12px;
            color: #6B7280;
        }
        @media (max-width: 600px) {
            .customer-info {
                grid-template-columns: 1fr;
            }
            .header, .content, .footer {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>BH CABINETRY</h1>
            <p>Thank you for your order!</p>
        </div>

        <!-- Content -->
        <div class="content">
            <!-- Success Icon -->
            <div class="success-icon">
                <div class="circle">✓</div>
            </div>

            <!-- Order Number -->
            <div class="order-number">
                <h2>Order #{{ $order->order_number }}</h2>
                <p>Placed on {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
            </div>

            <!-- Customer Information -->
            <div class="section">
                <h3>Order Details</h3>
                <div class="customer-info">
                    <div class="info-box">
                        <h4>Customer Information</h4>
                        <p>{{ $order->customer_email }}</p>
                        @if($order->user)
                            <p>{{ $order->user->name }}</p>
                        @else
                            <p>Guest Customer</p>
                        @endif
                    </div>
                    <div class="info-box">
                        <h4>Shipping Address</h4>
                        @if($order->shipping_address)
                            <p>
                                {{ $order->shipping_address['firstName'] ?? '' }} {{ $order->shipping_address['lastName'] ?? '' }}<br>
                                {{ $order->shipping_address['address'] ?? '' }}<br>
                                {{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['country'] ?? '' }} {{ $order->shipping_address['zipCode'] ?? '' }}
                            </p>
                        @else
                            <p>No shipping address provided</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="section">
                <h3>Items Ordered</h3>
                <div class="order-items">
                    @foreach($orderItems as $item)
                        <div class="item">
                            <div class="item-details">
                                <div class="item-name">{{ $item->product_name }}</div>
                                <div class="item-meta">
                                    Quantity: {{ $item->quantity }}
                                    @if($item->assembly)
                                        • Assembly Included
                                    @endif
                                </div>
                            </div>
                            <div class="item-price">${{ number_format($item->subtotal, 2) }}</div>
                        </div>
                    @endforeach
                </div>

                <!-- Order Summary -->
                <div class="order-summary">
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span>${{ number_format($order->total_amount - ($order->shipping_cost ?? 0), 2) }}</span>
                    </div>
                    @if($order->shipping_cost)
                        <div class="summary-row">
                            <span>Shipping</span>
                            <span>${{ number_format($order->shipping_cost, 2) }}</span>
                        </div>
                    @endif
                    <div class="summary-row total">
                        <span>Total</span>
                        <span>${{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Payment Information -->
            <div class="section">
                <h3>Payment Information</h3>
                <div class="info-box">
                    <h4>Payment Method</h4>
                    <p>{{ ucfirst($order->payment_method) }} - {{ ucfirst($order->payment_status) }}</p>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <h3>What's Next?</h3>
            <p>We'll send you updates as your order progresses. You can track your order anytime using your order number.</p>
            
            <a href="{{ url('/track-order') }}" class="cta-button">Track Your Order</a>
            
            <div class="contact-info">
                <p><strong>Need Help?</strong></p>
                <p>Email: support@bhcabinetry.com</p>
                <p>Phone: (123) 456-7890</p>
                <p>Hours: Monday-Friday, 9AM-6PM EST</p>
            </div>
        </div>
    </div>
</body>
</html> 