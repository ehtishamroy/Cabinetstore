@extends('layouts.app')

@section('title', 'Top 5 Kitchen Cabinet Trends - Aura Cabinets')

@section('styles')
<style>
    /* Post page specific styles */
    body {
        background-color: #F8F7F4; /* Lightest brown background */
    }
    
    #main-header {
        background-color: rgba(248, 247, 244, 0.8); /* Match body bg */
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border-bottom: 1px solid #EAEAEA;
    }
    
    /* Styles for article content */
    .article-content h2 {
        font-size: 1.875rem; /* text-3xl */
        font-weight: 600;
        margin-top: 2.5rem;
        margin-bottom: 1rem;
    }
    .article-content h3 {
        font-size: 1.5rem; /* text-2xl */
        font-weight: 600;
        margin-top: 2rem;
        margin-bottom: 0.75rem;
    }
    .article-content p {
        line-height: 1.75;
        margin-bottom: 1.5rem;
    }
    .article-content ul {
        list-style-type: disc;
        padding-left: 1.5rem;
        margin-bottom: 1.5rem;
    }
    .article-content li {
        margin-bottom: 0.5rem;
    }
    .article-content a {
        color: #E86A33; /* Accent color */
        text-decoration: underline;
    }
    .article-content a:hover {
        text-decoration: none;
    }
    .article-content blockquote {
        border-left: 4px solid #E86A33;
        padding-left: 1rem;
        margin: 1.5rem 0;
        font-style: italic;
        color: #555;
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
    <article class="bg-white">
        <!-- Article Header -->
        <header class="text-center pt-12 pb-8">
            <div class="max-w-4xl mx-auto px-6 md:px-10">
                <a href="{{ route('blog') }}" class="category-tag mb-4 inline-block">Design Trends</a>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-light leading-tight">Top 5 Kitchen Cabinet Trends to Watch This Year</h1>
                <div class="flex items-center justify-center text-sm text-gray-500 mt-6">
                    <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?q=80&w=1974&auto=format&fit=crop" 
                         onerror="this.onerror=null;this.src='https://placehold.co/48x48/cccccc/666666?text=A';"
                         alt="Author avatar" class="w-10 h-10 rounded-full mr-3">
                    <span>By Jane Doe</span>
                    <span class="mx-2">|</span>
                    <i data-lucide="calendar" class="w-4 h-4 mr-2"></i>
                    <span>July 20, 2025</span>
                    <span class="mx-2">|</span>
                    <i data-lucide="clock" class="w-4 h-4 mr-2"></i>
                    <span>6 min read</span>
                </div>
            </div>
        </header>

        <!-- Featured Image -->
        <div class="max-w-6xl mx-auto px-6 md:px-10 mb-12">
            <div class="aspect-w-16 aspect-h-9 rounded-lg overflow-hidden">
                 <img src="https://images.unsplash.com/photo-1556911220-bff31c812dba?q=80&w=2148&auto=format&fit=crop"
                         onerror="this.onerror=null;this.src='https://placehold.co/1200x675/cccccc/666666?text=Featured+Post';"
                         alt="A beautifully organized modern kitchen" class="w-full h-full object-cover">
            </div>
        </div>

        <!-- Article Body -->
        <div class="max-w-3xl mx-auto px-6 md:px-10 pb-16">
            <div class="article-content text-lg text-gray-800">
                <p>The kitchen is the heart of the home, and its design sets the tone for your entire living space. As we move through the year, several exciting trends are emerging in kitchen cabinet design. Whether you're planning a full renovation or just a simple refresh, these top five trends offer inspiration for creating a kitchen that is both stylish and highly functional.</p>

                <h2>1. Rich, Moody Colors</h2>
                <p>While white kitchens will always be a classic, we're seeing a significant shift towards darker, more dramatic hues. Deep greens, moody blues, and even charcoal blacks are making a statement. These colors create a sense of sophistication and intimacy, turning the kitchen into a cozy and inviting space.</p>
                <blockquote>"Don't be afraid to go bold. A dark cabinet color can act as a neutral, allowing other elements like brass hardware or a marble backsplash to truly shine."</blockquote>
                <p>Pairing these dark cabinets with light countertops and warm metallic accents creates a balanced look that feels both luxurious and welcoming.</p>

                <h2>2. Natural Wood Finishes</h2>
                <p>The desire for natural, organic materials continues to grow. Light-toned woods like white oak, ash, and maple are particularly popular, bringing warmth, texture, and a sense of calm to the kitchen. This trend embraces the natural grain and imperfections of the wood, adding character and a connection to nature.</p>
                <h3>Key Styles:</h3>
                <ul>
                    <li><strong>Flat-panel (Slab) doors:</strong> To showcase the uninterrupted beauty of the wood grain.</li>
                    <li><strong>Shaker doors:</strong> A timeless style that gets a modern update with a natural finish.</li>
                </ul>

                <h2>3. The Return of the Shaker (with a Twist)</h2>
                <p>The Shaker cabinet is a design chameleon, and it's not going anywhere. However, this year's version comes with subtle updates. We're seeing Shaker doors with thinner frames (known as slim or skinny Shakers) for a more delicate, modern look. Additionally, pairing classic Shaker profiles with bold colors or natural wood finishes keeps this timeless style feeling fresh and relevant.</p>

                <h2>4. Minimalist Hardware (or No Hardware at All)</h2>
                <p>A clean, uncluttered aesthetic is paramount in modern design. This translates to cabinet hardware that is either extremely minimal or completely absent. Integrated handles, push-to-open mechanisms, and discreet channel pulls create a seamless and streamlined look. When hardware is used, it's often simple and elegant, like thin bar pulls in matte black or brushed gold.</p>

                <h2>5. Two-Toned Kitchens</h2>
                <p>Why settle for one color when you can have two? The two-toned kitchen trend remains strong, but with more creative combinations. While the classic approach of dark lower cabinets and light upper cabinets is still popular, we're also seeing:</p>
                <ul>
                    <li><strong>Island as an accent:</strong> Painting the kitchen island a different, often bolder, color than the perimeter cabinets.</li>
                    <li><strong>Material mixing:</strong> Combining painted cabinets with natural wood cabinets for a layered, textured look.</li>
                </ul>
                <p>This approach allows for more personalization and can help to break up a large space or make a small kitchen feel larger and more dynamic. By embracing these trends, you can create a kitchen that is not only on-point for the current year but will remain beautiful and functional for years to come.</p>
            </div>

             <!-- Share Section -->
            <div class="border-t border-b border-secondary my-8 py-6">
                <div class="flex justify-between items-center">
                    <span class="font-semibold">Share this post</span>
                    <div class="flex items-center space-x-4">
                        <a href="#" class="text-gray-500 hover:text-accent"><i data-lucide="twitter"></i></a>
                        <a href="#" class="text-gray-500 hover:text-accent"><i data-lucide="facebook"></i></a>
                        <a href="#" class="text-gray-500 hover:text-accent"><i data-lucide="linkedin"></i></a>
                        <a href="#" class="text-gray-500 hover:text-accent"><i data-lucide="link-2"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </article>
    
    <!-- Related Posts -->
    <section class="bg-[#F8F7F4] py-16">
         <div class="max-w-7xl mx-auto px-6 md:px-10">
            <h2 class="text-3xl font-semibold text-center mb-8">You Might Also Like</h2>
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
                    <p class="text-sm text-gray-600">Our step-by-step guide makes assembling your new cabinets a breeze.</p>
                </a>
                 <!-- Post 2 -->
                <a href="#" class="block group blog-card">
                    <div class="overflow-hidden rounded-lg mb-4">
                        <img src="https://images.unsplash.com/photo-1596731362429-7e4895204b3b?q=80&w=1974&auto=format&fit=crop" 
                             onerror="this.onerror=null;this.src='https://placehold.co/600x400/cccccc/666666?text=Blog+Post';"
                             alt="Different cabinet hardware options" class="w-full h-64 object-cover">
                    </div>
                    <span class="category-tag text-xs">Details</span>
                    <h3 class="text-xl font-semibold my-2 group-hover:text-accent transition-colors">Choosing the Perfect Hardware for Your Cabinets</h3>
                    <p class="text-sm text-gray-600">The right hardware can elevate your entire kitchen.</p>
                </a>
                <!-- Post 3 -->
                <a href="#" class="block group blog-card">
                    <div class="overflow-hidden rounded-lg mb-4">
                        <img src="https://images.unsplash.com/photo-1617806118233-5cf6e722141a?q=80&w=1964&auto=format&fit=crop" 
                             onerror="this.onerror=null;this.src='https://placehold.co/600x400/cccccc/666666?text=Blog+Post';"
                             alt="A kitchen with white cabinets and dark countertops" class="w-full h-64 object-cover">
                    </div>
                    <span class="category-tag text-xs">Color Theory</span>
                    <h3 class="text-xl font-semibold my-2 group-hover:text-accent transition-colors">The Psychology of Kitchen Colors</h3>
                    <p class="text-sm text-gray-600">How do colors affect the mood of your kitchen?</p>
                </a>
            </div>
        </div>
    </section>
</main>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        lucide.createIcons();
    });
</script>
@endsection 