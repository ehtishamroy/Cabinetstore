@extends('layouts.app')

@section('title', $post->meta_title ?: $post->title . ' - BH Cabinetry')

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
                <a href="{{ route('blog') }}" class="category-tag mb-4 inline-block">{{ $post->category }}</a>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-light leading-tight">{{ $post->title }}</h1>
                <div class="flex items-center justify-center text-sm text-gray-500 mt-6">
                    <img src="https://placehold.co/48x48/cccccc/666666?text={{ substr($post->author, 0, 1) }}"
                         alt="Author avatar" class="w-10 h-10 rounded-full mr-3">
                    <span>By {{ $post->author }}</span>
                    <span class="mx-2">|</span>
                    <i data-lucide="calendar" class="w-4 h-4 mr-2"></i>
                    <span>{{ $post->formatted_published_at }}</span>
                    <span class="mx-2">|</span>
                    <i data-lucide="clock" class="w-4 h-4 mr-2"></i>
                    <span>{{ $post->read_time }} min read</span>
                </div>
            </div>
        </header>

                <!-- Featured Image -->
        <div class="max-w-6xl mx-auto px-6 md:px-10 mb-12">
            <div class="aspect-w-16 aspect-h-9 rounded-lg overflow-hidden">
                 <img src="{{ $post->featured_image_url }}"
                          alt="{{ $post->title }}" class="w-full h-full object-cover">
            </div>
        </div>

        <!-- Article Body -->
        <div class="max-w-3xl mx-auto px-6 md:px-10 pb-16">
            <div class="article-content text-lg text-gray-800">
                {!! $post->content !!}
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
    
    @if($relatedPosts->count() > 0)
    <!-- Related Posts -->
    <section class="bg-[#F8F7F4] py-16">
         <div class="max-w-7xl mx-auto px-6 md:px-10">
            <h2 class="text-3xl font-semibold text-center mb-8">You Might Also Like</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($relatedPosts as $relatedPost)
                <a href="{{ route('blog.show', $relatedPost->slug) }}" class="block group blog-card">
                    <div class="overflow-hidden rounded-lg mb-4">
                        <img src="{{ $relatedPost->featured_image_url }}"
                             alt="{{ $relatedPost->title }}" class="w-full h-64 object-cover">
                    </div>
                    <span class="category-tag text-xs">{{ $relatedPost->category }}</span>
                    <h3 class="text-xl font-semibold my-2 group-hover:text-accent transition-colors">{{ $relatedPost->title }}</h3>
                    <p class="text-sm text-gray-600">{{ $relatedPost->excerpt ?: Str::limit(strip_tags($relatedPost->content), 120) }}</p>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</main>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        lucide.createIcons();
    });
</script>
@endsection 