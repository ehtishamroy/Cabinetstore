@extends('layouts.app')

@section('title', 'About Us - Aura Cabinets')

@section('content')
<main>
    <!-- Hero Section -->
    <section class="relative h-[50vh] flex items-center justify-center text-center text-white bg-dark-section">
        <img src="https://images.unsplash.com/photo-1556742044-53c242bd8aa4?q=80&w=2070&auto=format&fit=crop" 
             onerror="this.onerror=null;this.src='https://placehold.co/1920x800/cccccc/666666?text=Our+Workspace';"
             alt="A bright and modern design studio" class="absolute inset-0 w-full h-full object-cover opacity-30">
        <div class="relative z-10 px-6">
            <h1 class="text-4xl md:text-6xl font-light">Our Story</h1>
            <p class="mt-4 text-lg md:text-xl max-w-2xl mx-auto text-gray-300">Making beautiful, high-quality kitchen design accessible to everyone.</p>
        </div>
    </section>

    <!-- Our Mission Section -->
    <section class="py-12 md:py-20 bg-white">
        <div class="max-w-4xl mx-auto px-6 md:px-10 text-center">
            <h2 class="text-3xl md:text-4xl font-semibold mb-6 fade-in-section">Design Within Reach</h2>
            <div class="text-gray-600 leading-relaxed space-y-4 fade-in-section">
                <p>Aura Cabinets was founded on a simple idea: everyone deserves a beautiful, high-quality kitchen without the luxury price tag or the hassle of a traditional showroom. We saw a gap in the market for homeowners and contractors who valued design and durability but needed a more streamlined, accessible, and affordable solution.</p>
                <p>We are a team of passionate designers, craftspeople, and innovators dedicated to creating premium, ready-to-assemble cabinets that bring your vision to life. By focusing on timeless styles, superior materials, and a direct-to-consumer model, we cut out the middlemen to deliver exceptional value directly to your door.</p>
            </div>
        </div>
    </section>
</main>
@endsection

@section('styles')
<style>
    .fade-in-section { 
        opacity: 0; 
        transform: translateY(20px); 
        transition: opacity 0.6s ease-out, transform 0.6s ease-out; 
    }
    .fade-in-section.is-visible { 
        opacity: 1; 
        transform: translateY(0); 
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                }
            });
        }, {
            threshold: 0.1
        });

        document.querySelectorAll('.fade-in-section').forEach((section) => {
            observer.observe(section);
        });
    });
</script>
@endsection 