@extends('layouts.app')

@section('title', 'Server Error - BH Cabinetry')

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
    
    .contact-info {
        margin-top: 3rem;
        padding: 2rem;
        background-color: #F8F7F4;
        border-radius: 1rem;
        text-align: left;
    }
    
    .contact-info h3 {
        color: #2D2D2D;
        font-size: 1.25rem;
        margin-bottom: 1rem;
        font-weight: 600;
    }
    
    .contact-details {
        color: #6B7280;
        line-height: 1.6;
    }
    
    .contact-details p {
        margin-bottom: 0.5rem;
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
            <!-- 500 Number -->
            <div class="error-number">500</div>
            
            <!-- Error Message -->
            <h1 class="error-message">Server Error</h1>
            
            <!-- Error Description -->
            <p class="error-description">
                Something went wrong on our end. We're working to fix this issue. Please try again in a few moments.
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
            
            <!-- Contact Information -->
            <div class="contact-info">
                <h3>Need immediate assistance?</h3>
                <div class="contact-details">
                    <p><strong>Email:</strong> info@bhcabinetry.com</p>
                    <p><strong>Phone:</strong> (832) 422-5140</p>
                    <p><strong>Hours:</strong> Monday-Friday, 9AM-6PM EST</p>
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