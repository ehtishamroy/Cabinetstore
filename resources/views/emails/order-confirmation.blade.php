<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation - BH Cabinetry</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f8f7f4;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #E86A33;
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 600;
        }
        .content {
            padding: 40px 20px;
        }
        .order-number {
            background-color: #f8f7f4;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 30px;
            text-align: center;
        }
        .order-number h2 {
            margin: 0;
            color: #E86A33;
            font-size: 24px;
        }
        .order-details {
            margin-bottom: 30px;
        }
        .order-details h3 {
            color: #333;
            border-bottom: 2px solid #E86A33;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        .item:last-child {
            border-bottom: none;
        }
        .item-name {
            font-weight: 600;
        }
        .item-price {
            color: #E86A33;
            font-weight: 600;
        }
        .total-section {
            background-color: #f8f7f4;
            padding: 20px;
            border-radius: 8px;
            margin: 30px 0;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .total-row.final {
            font-size: 18px;
            font-weight: 700;
            color: #E86A33;
            border-top: 2px solid #E86A33;
            padding-top: 10px;
            margin-top: 15px;
        }
        .customer-info {
            background-color: #f8f7f4;
            padding: 20px;
            border-radius: 8px;
            margin: 30px 0;
        }
        .customer-info h3 {
            color: #333;
            margin-top: 0;
        }
        .info-row {
            margin-bottom: 10px;
        }
        .info-label {
            font-weight: 600;
            color: #666;
        }
        .footer {
            background-color: #333;
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .footer a {
            color: #E86A33;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
        .tracking-link {
            display: inline-block;
            background-color: #E86A33;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 6px;
            margin: 20px 0;
            font-weight: 600;
        }
        .tracking-link:hover {
            background-color: #d55a2a;
        }
        .thank-you {
            text-align: center;
            margin: 30px 0;
            font-size: 18px;
            color: #666;
        }
        @media only screen and (max-width: 600px) {
            .container {
                margin: 0;
                box-shadow: none;
            }
            .content {
                padding: 20px 15px;
            }
            .header {
                padding: 20px 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>BH CABINETRY</h1>
            <p>Order Confirmation</p>
        </div>

        <!-- Content -->
        <div class="content">
            <div class="order-number">
                <h2>Order #{{ $order->order_number }}</h2>
                <p>Thank you for your order!</p>
            </div>

            <div class="thank-you">
                <p>Dear {{ $order->shipping_address['firstName'] ?? 'Customer' }},</p>
                <p>Thank you for choosing BH Cabinetry! We're excited to fulfill your order and provide you with quality kitchen cabinets.</p>
            </div>

            <!-- Order Details -->
            <div class="order-details">
                <h3>Order Summary</h3>
                @foreach($order->orderItems as $item)
                <div class="item">
                    <div class="item-name">
                        {{ $item->product_name }}
                        @if($item->assembly)
                            <br><small style="color: #666;">Assembly Required</small>
                        @endif
                    </div>
                    <div class="item-price">
                        ${{ number_format($item->unit_price, 2) }} x {{ $item->quantity }}
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Totals -->
            <div class="total-section">
                <div class="total-row">
                    <span>Subtotal:</span>
                    <span>${{ number_format($order->orderItems->sum('subtotal'), 2) }}</span>
                </div>
                <div class="total-row">
                    <span>Shipping:</span>
                    <span>${{ number_format($order->shipping_cost, 2) }}</span>
                </div>
                <div class="total-row final">
                    <span>Total:</span>
                    <span>${{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="customer-info">
                <h3>Shipping Information</h3>
                <div class="info-row">
                    <span class="info-label">Name:</span>
                    <span>{{ ($order->shipping_address['firstName'] ?? '') . ' ' . ($order->shipping_address['lastName'] ?? '') }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Address:</span>
                    <span>
                        {{ $order->shipping_address['address'] ?? 'N/A' }}<br>
                                                 {{ $order->shipping_address['city'] ?? '' }}, {{ $order->shipping_address['state'] ?? '' }} {{ $order->shipping_address['zipCode'] ?? '' }}
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Phone:</span>
                    <span>{{ $order->shipping_address['phone'] ?? 'N/A' }}</span>
                </div>
            </div>

            <!-- Payment Information -->
            <div class="customer-info">
                <h3>Payment Information</h3>
                <div class="info-row">
                    <span class="info-label">Payment Method:</span>
                    <span>{{ ucfirst($order->payment_method) }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Payment Status:</span>
                    <span style="color: {{ $order->payment_status === 'paid' ? '#28a745' : '#ffc107' }};">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Order Date:</span>
                    <span>{{ $order->created_at->format('F j, Y \a\t g:i A') }}</span>
                </div>
            </div>

            <!-- Tracking Link -->
            <div style="text-align: center;">
                <a href="{{ route('track-order') }}?order_number={{ $order->order_number }}&email={{ $order->customer_email }}" class="tracking-link">
                    Track Your Order
                </a>
            </div>

            <!-- Additional Information -->
            <div style="margin-top: 30px; padding: 20px; background-color: #f8f7f4; border-radius: 8px;">
                <h3 style="margin-top: 0; color: #333;">What's Next?</h3>
                <ul style="text-align: left; color: #666;">
                    <li>We'll process your order within 1-2 business days</li>
                    <li>You'll receive shipping confirmation once your order ships</li>
                    <li>Track your order status using the link above</li>
                    <li>For assembly instructions, visit our website</li>
                </ul>
            </div>

            <div style="margin-top: 30px; text-align: center; color: #666;">
                <p>If you have any questions about your order, please don't hesitate to contact us:</p>
                <p><strong>Email:</strong> info@bhcabinetry.com<br>
                <strong>Phone:</strong> (832) 422-5140</p>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>BH Cabinetry</strong></p>
            <p>Quality Kitchen Cabinets for Your Home</p>
            <p><a href="{{ route('home') }}">Visit Our Website</a></p>
            <p style="font-size: 12px; margin-top: 20px;">
                This email was sent to {{ $order->customer_email }}<br>
                Order #{{ $order->order_number }} | {{ $order->created_at->format('F j, Y') }}
            </p>
        </div>
    </div>
</body>
</html> 