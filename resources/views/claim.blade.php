@extends('layouts.app')

@section('title', 'Submit a Claim - Aura Cabinets')

@section('styles')
<style>
    /* Claim page specific styles */
    body {
        background-color: #ffffff;
    }
    
    #main-header {
        position: sticky;
        top: 0;
        background-color: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border-bottom: 1px solid #EAEAEA;
    }

    /* Form Input Styles */
    .form-input {
        background-color: #F8F7F4; /* Light brown background */
        border: 1px solid #EAEAEA;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        transition: border-color 0.3s, box-shadow 0.3s;
    }
    .form-input:focus {
        outline: none;
        border-color: #2D2D2D;
        box-shadow: 0 0 0 2px rgba(45, 45, 45, 0.2);
    }
</style>
@endsection

@section('content')
<main>
    <div class="max-w-4xl mx-auto px-6 md:px-10 py-12 md:py-20">
        <!-- Page Content -->
        <div>
            <h1 class="text-3xl md:text-4xl font-semibold mb-4">Product Damages And Fulfillment: Claims Form</h1>
            
            <div class="mt-6 text-gray-700 leading-relaxed space-y-4">
                <p class="font-semibold text-red-600">IMPORTANT: BEFORE SUBMITTING YOUR CLAIM</p>
                <p>To ensure a smooth claims process, please follow these steps:</p>
                <ol class="list-decimal list-inside space-y-2">
                    <li>
                        <strong class="font-semibold">Inspect All Boxes and Components:</strong> 
                        Carefully open all boxes and inspect every item in your order for damage, defects, or missing pieces.
                    </li>
                    <li>
                        <strong class="font-semibold">Wait 24 Hours for Missing Items:</strong> 
                        If any items are missing from your delivery, please wait 24 hours before filing a claim, as they may arrive in a separate shipment.
                    </li>
                    <li>
                        <strong class="font-semibold">Submit a Complete Claim:</strong> 
                        Make sure your claim includes all affected items. Multiple claims for the same order may delay resolution.
                    </li>
                </ol>
                <p>Providing detailed and accurate information helps us process your claim as quickly as possible.</p>
            </div>

            <!-- Claims Form Box -->
            <div class="mt-12 border border-secondary rounded-xl p-8 md:p-10 bg-white">
                <h2 class="text-xl font-semibold text-center">Get started! Enter your order number and billing zip code to start your claim!</h2>
                
                <form action="#" method="POST" class="mt-8 max-w-sm mx-auto space-y-6">
                    <div>
                        <label for="order-number" class="block text-sm font-medium text-gray-700 mb-1">Your Order #</label>
                        <input type="text" name="order-number" id="order-number" class="form-input w-full">
                    </div>
                    <div>
                        <label for="zip-code" class="block text-sm font-medium text-gray-700 mb-1">Your Billing Zip Code</label>
                        <input type="text" name="zip-code" id="zip-code" class="form-input w-full">
                    </div>
                    <div class="pt-4">
                        <button type="submit" class="w-full btn-minimal text-lg font-bold py-3 px-8 rounded-md">
                            Continue
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        lucide.createIcons();
    });
</script>
@endsection 