<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update orders table
        Schema::table('orders', function (Blueprint $table) {
            $table->string('order_number')->nullable()->after('user_id');
            $table->string('payment_method')->nullable()->after('total_amount');
            $table->string('payment_status')->default('pending')->after('payment_method');
            $table->string('customer_email')->nullable()->after('payment_status');
            $table->json('shipping_address')->nullable()->after('customer_email');
            $table->json('billing_address')->nullable()->after('shipping_address');
        });

        // Update order_items table
        Schema::table('order_items', function (Blueprint $table) {
            $table->string('product_name')->nullable()->after('product_id');
            $table->decimal('unit_price', 8, 2)->nullable()->after('product_name');
            $table->decimal('labor_cost', 8, 2)->default(0)->after('unit_price');
            $table->boolean('assembly')->default(false)->after('labor_cost');
            $table->decimal('subtotal', 8, 2)->nullable()->after('assembly');
            
            // Drop old columns
            $table->dropColumn(['price_at_time_of_purchase', 'assembly_selected']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert order_items table
        Schema::table('order_items', function (Blueprint $table) {
            $table->decimal('price_at_time_of_purchase', 8, 2)->nullable();
            $table->boolean('assembly_selected')->default(false);
            
            $table->dropColumn(['product_name', 'unit_price', 'labor_cost', 'assembly', 'subtotal']);
        });

        // Revert orders table
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['order_number', 'payment_method', 'payment_status', 'customer_email', 'shipping_address', 'billing_address']);
        });
    }
};
