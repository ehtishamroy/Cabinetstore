@extends('layouts.app')

@section('title', 'Inspiration & Ideas - Aura Cabinets')

@section('styles')
<style>
    /* Blog page specific styles */
    body {
        background-color: #F8F7F4; /* Lightest brown background */
    }
    
    #main-header {
        background-color: rgba(248, 247, 244, 0.8); /* Match body bg */
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border-bottom: 1px solid #EAEAEA;
    }
    
    .blog-card img {
        transition: transform 0.3s ease-in-out;
    }
    .blog-card:hover img {
        transform: scale(1.05);
    }
    .category-tag {
        background-color: #E86A33;
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
</style>
@endsection

@section('content')
<main>
    <!-- Page Header -->
    <section class="bg-white pt-12 pb-8">
        <div class="max-w-7xl mx-auto px-6 md:px-10 text-center">
            <h1 class="text-4xl md:text-5xl font-light">Inspiration & Ideas</h1>
            <p class="mt-2 text-lg text-gray-600">Your guide to creating the perfect kitchen.</p>
        </div>
    </section>

    <!-- Blog Content -->
    <div class="max-w-7xl mx-auto px-6 md:px-10 py-12">
        <!-- Featured Post -->
        <a href="#" class="block group mb-12 blog-card">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                <div class="overflow-hidden rounded-lg">
                    <img src="https://images.unsplash.com/photo-1556911220-bff31c812dba?q=80&w=2148&auto=format&fit=crop"
                         onerror="this.onerror=null;this.src='https://placehold.co/800x600/cccccc/666666?text=Featured+Post';"
                         alt="A beautifully organized modern kitchen" class="w-full h-full object-cover">
                </div>
                <div>
                    <span class="category-tag mb-4 inline-block">Design Trends</span>
                    <h2 class="text-3xl md:text-4xl font-semibold mb-4 group-hover:text-accent transition-colors">Top 5 Kitchen Cabinet Trends to Watch This Year</h2>
                    <p class="text-gray-600 mb-4 leading-relaxed">From bold colors to natural wood finishes, discover the latest trends that are shaping modern kitchen design. We break down the top styles to help you create a kitchen that's both beautiful and functional.</p>
                    <div class="flex items-center text-sm text-gray-500">
                        <i data-lucide="calendar" class="w-4 h-4 mr-2"></i>
                        <span>July 20, 2025</span>
                        <span class="mx-2">|</span>
                        <i data-lucide="clock" class="w-4 h-4 mr-2"></i>
                        <span>6 min read</span>
                    </div>
                </div>
            </div>
        </a>

        <!-- Posts Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Post 1 -->
            <a href="#" class="block group blog-card">
                <div class="overflow-hidden rounded-lg mb-4">
                    <img src="https://images.unsplash.com/photo-1602028985551-50b699a7e09a?q=80&w=1974&auto=format&fit=crop" 
                         onerror="this.onerror=null;this.src='https://placehold.co/600x400/cccccc/666666?text=Blog+Post';"
                         alt="A person assembling a cabinet" class="w-full h-64 object-cover">
                </div>
                <span class="category-tag text-xs">DIY Guides</span>
                <h3 class="text-xl font-semibold my-2 group-hover:text-accent transition-colors">The Ultimate Guide to Assembling Your RTA Cabinets</h3>
                <p class="text-sm text-gray-600">Our step-by-step guide makes assembling your new cabinets a breeze. Follow along for pro tips and tricks.</p>
            </a>
             <!-- Post 2 -->
            <a href="#" class="block group blog-card">
                <div class="overflow-hidden rounded-lg mb-4">
                    <img src="https://images.unsplash.com/photo-1588854337236-6889d631f379?q=80&w=2070&auto=format&fit=crop" 
                         onerror="this.onerror=null;this.src='https://placehold.co/600x400/cccccc/666666?text=Blog+Post';"
                         alt="A small but stylish kitchen" class="w-full h-64 object-cover">
                </div>
                <span class="category-tag text-xs">Small Spaces</span>
                <h3 class="text-xl font-semibold my-2 group-hover:text-accent transition-colors">Maximizing Style in a Small Kitchen</h3>
                <p class="text-sm text-gray-600">Think you can't have a beautiful kitchen in a small space? Think again. We share our favorite tips for making the most of every square inch.</p>
            </a>
            <!-- Post 3 -->
            <a href="#" class="block group blog-card">
                <div class="overflow-hidden rounded-lg mb-4">
                    <img src="https://images.unsplash.com/photo-1596731362429-7e4895204b3b?q=80&w=1974&auto=format&fit=crop" 
                         onerror="this.onerror=null;this.src='https://placehold.co/600x400/cccccc/666666?text=Blog+Post';"
                         alt="Different cabinet hardware options" class="w-full h-64 object-cover">
                </div>
                <span class="category-tag text-xs">Details</span>
                <h3 class="text-xl font-semibold my-2 group-hover:text-accent transition-colors">Choosing the Perfect Hardware for Your Cabinets</h3>
                <p class="text-sm text-gray-600">The right hardware can elevate your entire kitchen. Learn how to choose the perfect knobs and pulls to match your style.</p>
            </a>
             <!-- Post 4 -->
            <a href="#" class="block group blog-card">
                <div class="overflow-hidden rounded-lg mb-4">
                    <img src="https://images.unsplash.com/photo-1617806118233-5cf6e722141a?q=80&w=1964&auto=format&fit=crop" 
                         onerror="this.onerror=null;this.src='https://placehold.co/600x400/cccccc/666666?text=Blog+Post';"
                         alt="A kitchen with white cabinets and dark countertops" class="w-full h-64 object-cover">
                </div>
                <span class="category-tag text-xs">Color Theory</span>
                <h3 class="text-xl font-semibold my-2 group-hover:text-accent transition-colors">The Psychology of Kitchen Colors</h3>
                <p class="text-sm text-gray-600">How do colors affect the mood of your kitchen? We explore the psychology behind popular color choices.</p>
            </a>
             <!-- Post 5 -->
            <a href="#" class="block group blog-card">
                <div class="overflow-hidden rounded-lg mb-4">
                    <img src="https://images.unsplash.com/photo-1533090481720-856c6e3c1fdc?q=80&w=1964&auto=format&fit=crop" 
                         onerror="this.onerror=null;this.src='https://placehold.co/600x400/cccccc/666666?text=Blog+Post';"
                         alt="A person cleaning cabinet doors" class="w-full h-64 object-cover">
                </div>
                <span class="category-tag text-xs">Maintenance</span>
                <h3 class="text-xl font-semibold my-2 group-hover:text-accent transition-colors">How to Care for Your New Cabinets</h3>
                <p class="text-sm text-gray-600">Keep your cabinets looking brand new for years to come with our simple cleaning and maintenance guide.</p>
            </a>
             <!-- Post 6 -->
            <a href="#" class="block group blog-card">
                <div class="overflow-hidden rounded-lg mb-4">
                    <img src="https://images.unsplash.com/photo-1616046229478-9901c5536a45?q=80&w=2070&auto=format&fit=crop" 
                         onerror="this.onerror=null;this.src='https://placehold.co/600x400/cccccc/666666?text=Blog+Post';"
                         alt="A kitchen island with stools" class="w-full h-64 object-cover">
                </div>
                <span class="category-tag text-xs">Design Trends</span>
                <h3 class="text-xl font-semibold my-2 group-hover:text-accent transition-colors">The Kitchen Island: Is It Right for You?</h3>
                <p class="text-sm text-gray-600">A kitchen island can be a game-changer, but it's not for every space. We help you decide if it's the right fit for your home.</p>
            </a>
        </div>
        <!-- Pagination -->
        <div class="flex justify-center mt-12">
            <nav class="flex items-center space-x-2">
                <span class="bg-dark-section text-white font-semibold py-2 px-4 rounded-md">1</span>
                <a href="#" class="bg-white text-gray-700 hover:bg-gray-200 font-semibold py-2 px-4 rounded-md transition-colors">2</a>
                <a href="#" class="bg-white text-gray-700 hover:bg-gray-200 font-semibold py-2 px-4 rounded-md transition-colors">3</a>
                <span>...</span>
                <a href="#" class="bg-white text-gray-700 hover:bg-gray-200 font-semibold py-2 px-4 rounded-md transition-colors">Next <i data-lucide="arrow-right" class="inline w-4 h-4 ml-1"></i></a>
            </nav>
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