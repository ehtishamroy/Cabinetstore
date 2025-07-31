@extends('layouts.app')

@section('title', 'Store - Aura Cabinets')

@section('content')
<main class="pt-20">
    <!-- Store Header -->
    <section class="bg-white py-12">
        <div class="px-6 md:px-10">
            <h1 class="text-4xl font-semibold text-center mb-4">Our Store</h1>
            <p class="text-gray-600 text-center max-w-2xl mx-auto">
                Discover our collection of high-quality, ready-to-assemble cabinets designed for modern living.
            </p>
        </div>
    </section>

    <!-- Store Content -->
    <section class="py-12">
        <div class="px-6 md:px-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Product Card 1 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="https://placehold.co/400x300/EAEAEA/333333?text=Cabinet+Door" alt="Cabinet Door" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Classic White Door</h3>
                        <p class="text-gray-600 mb-4">24" x 30" Shaker Style</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-accent">$125.00</span>
                            <button class="bg-primary-cta hover:bg-cta-hover text-white px-4 py-2 rounded-lg transition-colors">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product Card 2 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="https://placehold.co/400x300/2D2D2D/F8F7F4?text=Cabinet+Handle" alt="Cabinet Handle" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Matte Black Handle</h3>
                        <p class="text-gray-600 mb-4">5" Center to Center</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-accent">$28.00</span>
                            <button class="bg-primary-cta hover:bg-cta-hover text-white px-4 py-2 rounded-lg transition-colors">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Product Card 3 -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <img src="https://placehold.co/400x300/F8F7F4/333333?text=Floating+Shelf" alt="Floating Shelf" class="w-full h-48 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold mb-2">Oak Floating Shelf</h3>
                        <p class="text-gray-600 mb-4">36" Length</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-accent">$85.00</span>
                            <button class="bg-primary-cta hover:bg-cta-hover text-white px-4 py-2 rounded-lg transition-colors">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection 