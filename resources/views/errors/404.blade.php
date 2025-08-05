@extends('layouts.app')

@section('title', 'Page Not Found - BH Cabinetry')

@section('styles')
<style>
    body {
        background-color: #ffffff;
    }
    main {
        flex-grow: 1;
    }
    
    .error-container {
        min-height: 60vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .error-content {
        text-align: center;
        max-width: 600px;
        padding: 2rem;
    }
    
    .error-number {
        font-size: 8rem;
        font-weight: 300;
        color: #E86A33;
        line-height: 1;
        margin-bottom: 1rem;
        font-family: 'Instrument Sans', serif;
    }
    
    .error-message {
        font-size: 1.5rem;
        color: #2D2D2D;
        margin-bottom: 1rem;
        font-weight: 400;
    }
    
    .error-description {
        color: #6B7280;
        margin-bottom: 2rem;
        line-height: 1.6;
    }
    
    .error-actions {
        display: flex;
        flex-direction: column;
        gap: 1rem;
        align-items: center;
    }
    
    .btn-primary {
        background-color: #E86A33;
        color: white;
        padding: 0.75rem 2rem;
        border-radius: 0.5rem;
        text-decoration: none;
        font-weight: 600;
        transition: background-color 0.3s;
        display: inline-block;
    }
    
    .btn-primary:hover {
        background-color: #F18E6A;
    }
    
    .btn-secondary {
        background-color: transparent;
        color: #2D2D2D;
        padding: 0.75rem 2rem;
        border: 2px solid #2D2D2D;
        border-radius: 0.5rem;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s;
        display: inline-block;
    }
    
    .btn-secondary:hover {
        background-color: #2D2D2D;
        color: white;
    }
    
    .search-suggestions {
        margin-top: 3rem;
        padding: 2rem;
        background-color: #F8F7F4;
        border-radius: 1rem;
        text-align: left;
    }
    
    .search-suggestions h3 {
        color: #2D2D2D;
        font-size: 1.25rem;
        margin-bottom: 1rem;
        font-weight: 600;
    }
    
    .suggestion-links {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .suggestion-link {
        background-color: white;
        color: #2D2D2D;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        text-decoration: none;
        font-size: 0.875rem;
        border: 1px solid #E5E7EB;
        transition: all 0.3s;
    }
    
    .suggestion-link:hover {
        background-color: #E86A33;
        color: white;
        border-color: #E86A33;
    }
    
    @media (max-width: 768px) {
        .error-number {
            font-size: 6rem;
        }
        
        .error-message {
            font-size: 1.25rem;
        }
        
        .error-actions {
            flex-direction: column;
        }
        
        .btn-primary,
        .btn-secondary {
            width: 100%;
            text-align: center;
        }
    }
</style>
@endsection

@section('content')
<main>
    <div class="error-container">
        <div class="error-content">
            <!-- 404 Number -->
            <div class="error-number">404</div>
            
            <!-- Error Message -->
            <h1 class="error-message">Page Not Found</h1>
            
            <!-- Error Description -->
            <p class="error-description">
                Sorry, the page you're looking for doesn't exist. It might have been moved, deleted, or you entered the wrong URL.
            </p>
            
            <!-- Action Buttons -->
            <div class="error-actions">
                <a href="{{ route('home') }}" class="btn-primary">
                    <i data-lucide="home" class="w-4 h-4 inline mr-2"></i>
                    Go to Homepage
                </a>
                <a href="{{ route('shop') }}" class="btn-secondary">
                    <i data-lucide="shopping-bag" class="w-4 h-4 inline mr-2"></i>
                    Browse Our Products
                </a>
            </div>
            
            <!-- Search Suggestions -->
            <div class="search-suggestions">
                <h3>Looking for something specific?</h3>
                <div class="suggestion-links">
                    <a href="{{ route('shop') }}" class="suggestion-link">Shop All Cabinets</a>
                    <a href="{{ route('about') }}" class="suggestion-link">About Us</a>
                    <a href="{{ route('contact') }}" class="suggestion-link">Contact</a>
                    <a href="{{ route('track-order') }}" class="suggestion-link">Track Order</a>
                    <a href="{{ route('blog') }}" class="suggestion-link">Blog</a>
                    <a href="{{ route('privacy') }}" class="suggestion-link">Privacy Policy</a>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        lucide.createIcons();
    });
</script>
@endsection 