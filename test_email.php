<?php

// Test script to verify Brevo SMTP configuration
// Run this with: php test_email.php

require_once 'vendor/autoload.php';

// Load Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;
use App\Models\Order;

echo "Testing Brevo SMTP Configuration...\n";

// Test email configuration
try {
    // Create a test order (you can modify this with real data)
    $testOrder = new Order();
    $testOrder->order_number = 'TEST-' . time();
    $testOrder->customer_email = 'test@example.com'; // Change this to your email
    $testOrder->total = 299.99;
    $testOrder->subtotal = 249.99;
    $testOrder->shipping_cost = 50.00;
    $testOrder->payment_method = 'stripe';
    $testOrder->payment_status = 'paid';
    $testOrder->shipping_address = [
        'name' => 'John Doe',
        'address' => '123 Main St',
        'city' => 'New York',
        'state' => 'NY',
        'zip' => '10001',
        'phone' => '(555) 123-4567'
    ];
    $testOrder->created_at = now();

    // Create test order items
    $testOrder->setRelation('items', collect([
        (object)[
            'product_name' => 'Modern Slab Cabinet Door',
            'unit_price' => 89.99,
            'quantity' => 2,
            'assembly' => true
        ],
        (object)[
            'product_name' => 'Shaker Style Cabinet Door',
            'unit_price' => 69.99,
            'quantity' => 1,
            'assembly' => false
        ]
    ]));

    // Send test email
    Mail::to('test@example.com')->send(new OrderConfirmation($testOrder));
    
    echo "✅ Email sent successfully!\n";
    echo "Check your email inbox for the test order confirmation.\n";
    
} catch (Exception $e) {
    echo "❌ Email failed to send:\n";
    echo $e->getMessage() . "\n";
    echo "\nPlease check your SMTP configuration in .env file.\n";
}

echo "\nMake sure your .env file contains these settings:\n";
echo "MAIL_MAILER=smtp\n";
echo "MAIL_HOST=smtp-relay.brevo.com\n";
echo "MAIL_PORT=587\n";
echo "MAIL_USERNAME=93f0f0001@smtp-brevo.com\n";
echo "MAIL_PASSWORD=xsmtpsib-44e809363f8d740eeac8be36225e1b25f767cf1b137eff9a96b1f53e88fec0b8-5Fgt1qJ09hG3pcdI\n";
echo "MAIL_ENCRYPTION=tls\n";
echo "MAIL_FROM_ADDRESS=contact@bhcabinetry.com\n";
echo "MAIL_FROM_NAME=\"BH Cabinetry\"\n"; 