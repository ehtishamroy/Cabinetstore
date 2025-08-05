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
        @if($featuredPost)
        <!-- Featured Post -->
        <a href="{{ route('blog.show', $featuredPost->slug) }}" class="block group mb-12 blog-card">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                <div class="overflow-hidden rounded-lg">
                    <img src="{{ $featuredPost->featured_image_url }}"
                         alt="{{ $featuredPost->title }}" class="w-full h-full object-cover">
                </div>
                <div>
                    <span class="category-tag mb-4 inline-block">{{ $featuredPost->category }}</span>
                    <h2 class="text-3xl md:text-4xl font-semibold mb-4 group-hover:text-accent transition-colors">{{ $featuredPost->title }}</h2>
                    <p class="text-gray-600 mb-4 leading-relaxed">{{ $featuredPost->excerpt ?: Str::limit(strip_tags($featuredPost->content), 200) }}</p>
                    <div class="flex items-center text-sm text-gray-500">
                        <i data-lucide="calendar" class="w-4 h-4 mr-2"></i>
                        <span>{{ $featuredPost->formatted_published_at }}</span>
                        <span class="mx-2">|</span>
                        <i data-lucide="clock" class="w-4 h-4 mr-2"></i>
                        <span>{{ $featuredPost->read_time }} min read</span>
                    </div>
                </div>
            </div>
        </a>
        @endif

        <!-- Posts Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($posts as $post)
            <a href="{{ route('blog.show', $post->slug) }}" class="block group blog-card">
                <div class="overflow-hidden rounded-lg mb-4">
                    <img src="{{ $post->featured_image_url }}"
                         alt="{{ $post->title }}" class="w-full h-64 object-cover">
                </div>
                <span class="category-tag text-xs">{{ $post->category }}</span>
                <h3 class="text-xl font-semibold my-2 group-hover:text-accent transition-colors">{{ $post->title }}</h3>
                <p class="text-sm text-gray-600">{{ $post->excerpt ?: Str::limit(strip_tags($post->content), 120) }}</p>
                <div class="flex items-center text-xs text-gray-500 mt-2">
                    <i data-lucide="calendar" class="w-3 h-3 mr-1"></i>
                    <span>{{ $post->formatted_published_at }}</span>
                    <span class="mx-2">|</span>
                    <i data-lucide="clock" class="w-3 h-3 mr-1"></i>
                    <span>{{ $post->read_time }} min read</span>
                </div>
            </a>
            @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500">No blog posts available yet.</p>
            </div>
            @endforelse
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