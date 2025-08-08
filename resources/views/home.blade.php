@extends('layouts.app')

@section('title', 'BH Cabinetry - Modern Kitchens, Simply Delivered')

@section('content')
<main>
    <!-- ===== Hero Section ===== -->
    <section class="relative h-screen flex items-end justify-start text-white">
        <!-- Background Image -->
        <div class="absolute inset-0">
            <img src="{{ asset('uploads/hero/2941.jpg') }}" 
                 onerror="this.onerror=null;this.src='https://placehold.co/1920x1080/cccccc/666666?text=Modern+Kitchen';"
                 alt="Modern kitchen with beautiful cabinets" class="w-full h-full object-cover">
            <!-- Gradient Overlay -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
        </div>

        <!-- Content -->
        <div class="relative z-10 p-6 md:p-10 text-left">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-semibold leading-tight">Beautiful Kitchens, Simply Delivered.</h1>
            <p class="mt-4 text-lg md:text-xl max-w-xl">High-quality, ready-to-assemble cabinets designed for modern living.</p>
            <a href="#styles" class="mt-8 inline-block bg-primary-cta hover:bg-cta-hover text-white font-bold py-3 px-8 rounded-lg text-lg transition-all duration-300 transform hover:scale-105">
                Shop All Cabinet Styles
            </a>
        </div>
    </section>

    <!-- ===== NEW About Us Section ===== -->
    <section class="py-12 md:py-20 bg-white">
        <div class="px-6 md:px-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-center">
                <!-- Image Column -->
                <div class="relative h-[350px] lg:h-[450px] flex items-center justify-center">
                    <div class="absolute w-2/5 top-0 left-0 transform -rotate-6 shadow-2xl rounded-2xl overflow-hidden group">
                        <img src="{{ asset('uploads/hero/2150710629.jpg') }}" onerror="this.onerror=null;this.src='https://placehold.co/400x500/cccccc/666666?text=Cabinet+Detail';" alt="Cabinet detail" class="w-full h-full object-cover transition-transform duration-300 ease-in-out group-hover:scale-110">
                    </div>
                    <div class="relative w-2/5 bottom-0 right-0 transform rotate-3 shadow-2xl rounded-2xl overflow-hidden group">
                        <img src="{{ asset('uploads/hero/2151008695.jpg') }}" onerror="this.onerror=null;this.src='https://placehold.co/400x500/cccccc/666666?text=Cabinet+Detail';" alt="Cabinet detail" class="w-full h-full object-cover transition-transform duration-300 ease-in-out group-hover:scale-110">
                    </div>
                </div>
                <!-- Text Column -->
                <div class="text-left">
                    <p class="text-accent font-semibold mb-2">OUR STORY</p>
                    <h2 class="text-3xl md:text-4xl font-semibold mb-4">Designed & Crafted with Passion</h2>
                    <p class="text-gray-600 leading-relaxed">
                        BH Cabinetry was founded on a simple idea: everyone deserves a beautiful, high-quality kitchen without the luxury price tag. We are a team of passionate designers, craftspeople, and innovators dedicated to creating premium, ready-to-assemble cabinets that bring your vision to life.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== Shop by Style Section (REDESIGNED) ===== -->
    <section id="styles" class="py-10 md:py-16">
        <div class="px-6 md:px-10">
            <h2 class="text-3xl md:text-4xl font-semibold text-center mb-10">Choose Your Door Style</h2>
            <div class="swiper style-swiper">
                <div class="swiper-wrapper pb-12">
                    @foreach($doorStyles as $doorStyle)
                        @php
                            $colorCount = isset($doorColorsByStyle[$doorStyle['name']]) ? count($doorColorsByStyle[$doorStyle['name']]) : 0;
                            $bgColor = $colorCount > 0 ? 'bg-[#F8F7F4]' : 'bg-gray-200';
                            $textColor = $colorCount > 0 ? 'text-primary' : 'text-gray-500';
                        @endphp
                        <div class="swiper-slide">
                            <a href="{{ route('shop') }}" class="block {{ $bgColor }} rounded-2xl p-4 {{ $textColor }} h-full flex flex-col">
                                <div class="flex-grow">
                                    <h3 class="text-xl font-semibold">{{ $doorStyle['name'] }}</h3>
                                    <p class="text-sm opacity-70">{{ $colorCount }} color{{ $colorCount !== 1 ? 's' : '' }} available</p>
                                </div>
                                <img src="{{ $doorStyle['image_url'] }}" alt="{{ $doorStyle['name'] }} style cabinets" class="w-full rounded-lg mt-4 object-cover aspect-square">
                            </a>
                        </div>
                    @endforeach
                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>


    
    <!-- ===== Why Choose Us Section ===== -->
    <section class="py-12 md:py-20 bg-white">
        <div class="px-6 md:px-10">
             <h2 class="text-3xl md:text-4xl font-semibold text-center mb-10">Designed for Your Life</h2>
             <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Feature 1: Quality -->
                <a href="#" class="group feature-image-card rounded-2xl shadow-lg">
                    <img src="https://images.unsplash.com/photo-1580913428023-02c695666d61?q=80&w=1965&auto=format&fit=crop" onerror="this.onerror=null;this.src='https://placehold.co/600x800/cccccc/666666?text=Quality';" alt="Closeup of high-quality wood grain" class="w-full h-full object-cover">
                    <div class="content">
                        <i data-lucide="gem" class="w-10 h-10 mb-4 text-accent"></i>
                        <h3 class="text-2xl font-semibold mb-2">Quality Materials</h3>
                        <p class="text-gray-300 text-sm">Premium plywood and solid wood for cabinets that last a lifetime.</p>
                    </div>
                </a>
                <!-- Feature 2: Assembly -->
                <a href="#" class="group feature-image-card rounded-2xl shadow-lg">
                    <img src="https://images.unsplash.com/photo-1517048676732-d65bc937f952?q=80&w=2070&auto=format&fit=crop" onerror="this.onerror=null;this.src='https://placehold.co/600x800/cccccc/666666?text=Assembly';" alt="A clean and organized workspace for assembly" class="w-full h-full object-cover">
                    <div class="content">
                        <i data-lucide="wrench" class="w-10 h-10 mb-4 text-accent"></i>
                        <h3 class="text-2xl font-semibold mb-2">Simple Assembly</h3>
                        <p class="text-gray-300 text-sm">Our innovative process makes installation straightforward and hassle-free.</p>
                    </div>
                </a>
                <!-- Feature 3: Delivery -->
                <a href="#" class="group feature-image-card rounded-2xl shadow-lg">
                    <img src="https://images.unsplash.com/photo-1556742044-53c242bd8aa4?q=80&w=2070&auto=format&fit=crop" onerror="this.onerror=null;this.src='https://placehold.co/600x800/cccccc/666666?text=Delivery';" alt="A person receiving a delivery package at their door" class="w-full h-full object-cover">
                    <div class="content">
                        <i data-lucide="truck" class="w-10 h-10 mb-4 text-accent"></i>
                        <h3 class="text-2xl font-semibold mb-2">Direct Delivery</h3>
                        <p class="text-gray-300 text-sm">Get your dream kitchen delivered directly to your door, ready for assembly.</p>
                    </div>
                </a>
             </div>
        </div>
    </section>

    <!-- ===== Testimonials Section ===== -->
    <section class="py-12 md:py-20 bg-white">
        <div class="px-6 md:px-10">
            <h2 class="text-3xl md:text-4xl font-semibold text-left mb-10">Our customers</h2>
            <!-- Swiper -->
            <div class="swiper testimonial-swiper -mx-2">
                <div class="swiper-wrapper pb-2">
                    <!-- Slide 1 -->
                    <div class="swiper-slide p-2">
                       <div class="border border-gray-200 rounded-xl p-8 h-full flex flex-col text-left">
                            <div class="flex text-yellow-400 mb-4">
                                <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                                <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                                <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                                <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                                <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                            </div>
                            <p class="text-gray-700 leading-relaxed flex-grow">"The quality of these cabinets blew me away. They completely transformed our kitchen and the assembly was surprisingly easy!"</p>
                            <div class="mt-6 flex items-center">
                                <img src="https://images.unsplash.com/photo-1554151228-14d9def656e4?q=80&w=1972&auto=format&fit=crop" onerror="this.onerror=null;this.src='https://placehold.co/48x48/cccccc/666666?text=SJ';" alt="Avatar of Sarah J." class="w-12 h-12 rounded-full mr-4 object-cover">
                                <div>
                                    <p class="font-semibold text-primary">Sarah J.</p>
                                    <p class="text-sm text-gray-500">Homeowner, Austin, TX</p>
                                </div>
                            </div>
                       </div>
                    </div>
                    <!-- Slide 2 -->
                    <div class="swiper-slide p-2">
                       <div class="border border-gray-200 rounded-xl p-8 h-full flex flex-col text-left">
                            <div class="flex text-yellow-400 mb-4">
                                <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                                <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                                <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                                <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                                <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                            </div>
                            <p class="text-gray-700 leading-relaxed flex-grow">"I'm a contractor and I've started using BH Cabinetry for all my projects. My clients love the look and I love the price and fast shipping. It's a game-changer."</p>
                            <div class="mt-6 flex items-center">
                                <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?q=80&w=1974&auto=format&fit=crop" onerror="this.onerror=null;this.src='https://placehold.co/48x48/cccccc/666666?text=MB';" alt="Avatar of Michael B." class="w-12 h-12 rounded-full mr-4 object-cover">
                                <div>
                                    <p class="font-semibold text-primary">Michael B.</p>
                                    <p class="text-sm text-gray-500">General Contractor</p>
                                </div>
                            </div>
                       </div>
                    </div>
                    <!-- Slide 3 -->
                    <div class="swiper-slide p-2">
                       <div class="border border-gray-200 rounded-xl p-8 h-full flex flex-col text-left">
                            <div class="flex text-yellow-400 mb-4">
                                <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                                <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                                <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                                <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                                <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                            </div>
                            <p class="text-gray-700 leading-relaxed flex-grow">"Customer service was fantastic. They helped me with my layout and answered all my questions. Highly recommend!"</p>
                            <div class="mt-6 flex items-center">
                                <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=1974&auto=format&fit=crop" onerror="this.onerror=null;this.src='https://placehold.co/48x48/cccccc/666666?text=ER';" alt="Avatar of Emily R." class="w-12 h-12 rounded-full mr-4 object-cover">
                                <div>
                                    <p class="font-semibold text-primary">Emily R.</p>
                                    <p class="text-sm text-gray-500">DIY Renovator, San Diego, CA</p>
                                </div>
                            </div>
                       </div>
                    </div>
                     <!-- Slide 4 -->
                    <div class="swiper-slide p-2">
                       <div class="border border-gray-200 rounded-xl p-8 h-full flex flex-col text-left">
                            <div class="flex text-yellow-400 mb-4">
                                <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                                <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                                <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                                <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                                <i data-lucide="star" class="w-5 h-5 fill-current"></i>
                            </div>
                            <p class="text-gray-700 leading-relaxed flex-grow">"The design process was seamless and the 3D rendering helped me visualize everything perfectly. The end result is my dream kitchen."</p>
                            <div class="mt-6 flex items-center">
                                <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?q=80&w=1961&auto=format&fit=crop" onerror="this.onerror=null;this.src='https://placehold.co/48x48/cccccc/666666?text=LC';" alt="Avatar of Linda C." class="w-12 h-12 rounded-full mr-4 object-cover">
                                <div>
                                    <p class="font-semibold text-primary">Linda C.</p>
                                    <p class="text-sm text-gray-500">Interior Designer</p>
                                </div>
                            </div>
                       </div>
                    </div>
                </div>
                <!-- Add Navigation -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </div>
    </section>

    <!-- ===== New CTA Section ===== -->
    <section class="py-12 md:py-20">
        <div class="px-6 md:px-10">
            <div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-xl p-8 md:p-12">
                <div class="flex flex-col md:flex-row items-center text-center md:text-left">
                    <img src="https://placehold.co/80x80/2D2D2D/F8F7F4?text=A" alt="Avatar" class="w-20 h-20 rounded-full mb-6 md:mb-0 md:mr-8">
                    <div class="flex-grow">
                        <h3 class="text-2xl md:text-3xl font-semibold">Have more questions?</h3>
                        <p class="text-gray-600 text-lg">Book a free discovery call with our design experts.</p>
                    </div>
                </div>
                <div class="text-center mt-8">
                    <div class="cta-button-container w-full max-w-xs mx-auto h-12">
                         <span class="cta-button-base"></span>
                         <a href="#" class="cta-button-link flex items-center justify-center bg-gray-900 text-white font-bold rounded-full text-lg">
                             Book a Discovery Call
                             <i data-lucide="arrow-right" class="ml-2 w-5 h-5"></i>
                         </a>
                    </div>
                    <p class="mt-6 text-sm text-gray-500">Or, email us at <a href="mailto:hello@bhcabinetry.com" class="text-accent font-semibold">hello@bhcabinetry.com</a></p>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection

@section('scripts')
<script>
    // --- Testimonial Slider Initialization ---
    const testimonialSwiper = new Swiper('.testimonial-swiper', {
        loop: false,
        slidesPerView: 1, // Default for mobile
        spaceBetween: 20,
        navigation: {
            nextEl: '.testimonial-swiper .swiper-button-next',
            prevEl: '.testimonial-swiper .swiper-button-prev',
        },
        breakpoints: {
            768: { slidesPerView: 2, spaceBetween: 30 },
            1024: { slidesPerView: 3, spaceBetween: 30 }, // Show 3 on desktop
        },
    });



    // --- Style Carousel Initialization ---
    const styleSwiper = new Swiper('.style-swiper', {
        loop: false,
        slidesPerView: 'auto',
        spaceBetween: 20,
        pagination: {
            el: '.style-swiper .swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            640: { slidesPerView: 2, spaceBetween: 20 },
            768: { slidesPerView: 3, spaceBetween: 20 },
            1024: { slidesPerView: 4, spaceBetween: 20 },
            1280: { slidesPerView: 5, spaceBetween: 20 },
        },
    });
</script>
@endsection
