@extends('layouts.app')

@section('title', 'Shop All Cabinets - Aura Cabinets')

@section('styles')
<style>
    /* Shop page specific styles */
    body {
        background-color: #ffffff; /* Page background is now WHITE */
    }
    main {
        flex-grow: 1; 
    }
    
    /* Custom Checkbox */
    .custom-checkbox:checked {
        background-image: url("data:image/svg+xml,%3csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3e%3cpath d='M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z'/%3e%3c/svg%3e");
        background-color: #2D2D2D;
        border-color: #2D2D2D;
    }
    
    /* New Color Filter Item Style */
    .door-color-filter-item img {
        transition: transform 0.2s, box-shadow 0.2s;
        border: 2px solid #EAEAEA;
    }
    .door-color-filter-item.selected img {
        transform: scale(1.1);
        box-shadow: 0 0 0 2px white, 0 0 0 4px #2D2D2D;
    }
    
    /* Price Slider Styles */
    input[type=range] {
        -webkit-appearance: none;
        appearance: none;
        width: 100%;
        background: transparent;
    }
    input[type=range]::-webkit-slider-runnable-track {
        width: 100%;
        height: 4px;
        cursor: pointer;
        background: #EAEAEA;
        border-radius: 5px;
    }
    input[type=range]::-webkit-slider-thumb {
        -webkit-appearance: none;
        height: 18px;
        width: 18px;
        border-radius: 50%;
        background: #2D2D2D;
        cursor: pointer;
        margin-top: -7px;
    }
    input[type=range]::-moz-range-track {
        width: 100%;
        height: 4px;
        cursor: pointer;
        background: #EAEAEA;
        border-radius: 5px;
    }
    input[type=range]::-moz-range-thumb {
        height: 18px;
        width: 18px;
        border-radius: 50%;
        background: #2D2D2D;
        cursor: pointer;
    }

    /* Product Card Redesign */
    .product-card .product-card-image-wrapper {
        overflow: hidden;
        border-radius: 0.5rem;
    }
    .product-card .product-card-image {
        transition: transform 0.4s ease-out;
    }
    .product-card:hover .product-card-image {
        transform: scale(1.05);
    }

    /* Breadcrumb and Navigation */
    .breadcrumb-item {
        transition: color 0.2s;
    }
    .breadcrumb-item:hover {
        color: #2D2D2D;
    }
    .breadcrumb-item.active {
        color: #6B7280;
        cursor: default;
    }

    /* Back Button */
    .back-button {
        transition: all 0.2s;
    }
    .back-button:hover {
        transform: translateX(-2px);
    }

    /* Color Grid */
    .color-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1.5rem;
    }

    /* Loading States */
    .loading-skeleton {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: loading 1.5s infinite;
    }
    @keyframes loading {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
</style>
@endsection

@section('content')
<main>
    <div class="max-w-7xl mx-auto px-6 md:px-10 py-8">
        <!-- Breadcrumb Navigation -->
        <nav id="breadcrumb-nav" class="mb-6">
            <div class="flex items-center space-x-2 text-sm text-gray-600">
                <a href="{{ route('home') }}" class="breadcrumb-item hover:underline">Home</a>
                <span>/</span>
                <span class="breadcrumb-item active">Shop</span>
            </div>
        </nav>

        <!-- Page Header -->
        <div class="text-center py-8">
            <h1 id="page-title" class="text-4xl md:text-5xl font-light">Choose Your Door Style</h1>
            <p id="page-description" class="mt-4 text-gray-600 max-w-2xl mx-auto">Select your preferred door style to see all available colors and start building your perfect kitchen.</p>
        </div>
        
        <div class="flex">
            <!-- Filters Sidebar (Desktop) -->
            <aside id="filters-sidebar" class="hidden lg:block w-1/4 pr-8">
                <div class="sticky top-28">
                     <div id="filter-content" class="bg-[#F8F7F4] p-6 rounded-xl">
                        <!-- Door Style Filter -->
                        <div class="mb-8">
                            <h3 class="font-semibold mb-4">Door Styles</h3>
                            <div id="door-style-filters" class="space-y-3">
                                                                 @foreach($doorStyles as $doorStyle)
                                     @php
                                         $colorCount = isset($doorColorsByStyle[$doorStyle['name']]) ? count($doorColorsByStyle[$doorStyle['name']]) : 0;
                                     @endphp
                                     <label class="flex items-center space-x-3 cursor-pointer">
                                         <input type="checkbox" value="{{ $doorStyle['name'] }}" class="door-style-filter custom-checkbox h-5 w-5 rounded-md border-gray-300 text-gray-900 focus:ring-gray-900">
                                         <span class="text-sm">{{ $doorStyle['name'] }} ({{ $colorCount }} colors)</span>
                                     </label>
                                 @endforeach
                            </div>
                        </div>
                     </div>
                </div>
            </aside>

            <!-- Products Grid -->
            <div class="w-full lg:w-3/4">
                <!-- Top Bar -->
                <div class="flex justify-between items-center mb-6">
                    <button id="mobile-filter-button" class="lg:hidden flex items-center gap-2 rounded-md border border-secondary px-4 py-2 bg-white">
                        <i data-lucide="sliders-horizontal" class="w-4 h-4"></i>
                        <span>Filter</span>
                    </button>
                    <p id="product-count" class="text-sm text-gray-500 hidden lg:block">Loading styles...</p>
                    <select id="sort-by" class="border border-secondary rounded-md px-4 py-2 text-sm focus:outline-none bg-white">
                        <option value="featured">Sort by: Featured</option>
                        <option value="name-asc">Name: A to Z</option>
                        <option value="name-desc">Name: Z to A</option>
                    </select>
                </div>

                <!-- Back to Styles Button (Hidden initially) -->
                <div id="back-to-styles" class="hidden mb-6">
                    <button class="back-button flex items-center space-x-2 text-gray-600 hover:text-gray-900 font-medium">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                        <span>Back to Door Styles</span>
                    </button>
                </div>

                <!-- Product Grid -->
                <div id="product-grid" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-6">
                    <!-- Products populated by JS -->
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Mobile Filter Off-canvas -->
<div id="mobile-filter-backdrop" class="fixed inset-0 bg-black/50 z-[60] hidden opacity-0 transition-opacity duration-300"></div>
<div id="mobile-filter-menu" class="fixed top-0 left-0 h-full w-4/5 max-w-sm bg-white z-[70] transform -translate-x-full transition-transform duration-300 ease-in-out flex flex-col">
    <div class="flex justify-between items-center p-4 border-b border-secondary">
        <h2 class="text-xl font-semibold">Filters</h2>
        <button id="close-mobile-filter">
            <i data-lucide="x" class="w-6 h-6"></i>
        </button>
    </div>
    <div id="mobile-filter-content" class="flex-grow overflow-y-auto p-6">
        <!-- Mobile filter content will be cloned here by JS -->
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // --- DYNAMIC DATA FROM CONTROLLER ---
    const doorStyles = @json($doorStyles);
    const doorColorsByStyle = @json($doorColorsByStyle);

    // --- ELEMENTS ---
    const productGrid = document.getElementById('product-grid');
    const productCount = document.getElementById('product-count');
    const doorStyleFilters = document.getElementById('door-style-filters');
    const sortBy = document.getElementById('sort-by');
    const mobileFilterButton = document.getElementById('mobile-filter-button');
    const mobileFilterMenu = document.getElementById('mobile-filter-menu');
    const mobileFilterBackdrop = document.getElementById('mobile-filter-backdrop');
    const closeMobileFilter = document.getElementById('close-mobile-filter');
    const filterContent = document.getElementById('filter-content');
    const mobileFilterContent = document.getElementById('mobile-filter-content');
    const backToStyles = document.getElementById('back-to-styles');
    const pageTitle = document.getElementById('page-title');
    const pageDescription = document.getElementById('page-description');
    const breadcrumbNav = document.getElementById('breadcrumb-nav');

    // --- STATE ---
    let currentView = 'styles'; // 'styles' or 'colors'
    let selectedDoorStyle = null;
    let currentDoorColors = [];

    // --- RENDER FUNCTIONS ---
    function renderDoorStyles() {
        if (doorStyles.length === 0) {
            productGrid.innerHTML = `<div class="sm:col-span-2 xl:col-span-3 text-center text-gray-500 py-16">
                <p class="font-semibold text-lg">No door styles available</p>
                <p class="mt-2">Please check back later.</p>
            </div>`;
            productCount.textContent = '0 styles';
            return;
        }

        // Apply sorting
        let sortedStyles = [...doorStyles];
        switch(sortBy.value) {
            case 'name-asc':
                sortedStyles.sort((a, b) => a.name.localeCompare(b.name));
                break;
            case 'name-desc':
                sortedStyles.sort((a, b) => b.name.localeCompare(a.name));
                break;
            case 'featured':
            default:
                // Just use the default order
                break;
        }

        productGrid.innerHTML = sortedStyles.map(style => {
            const colorCount = doorColorsByStyle[style.name]?.length || 0;
            
            return `
                <div class="product-card bg-[#F8F7F4] p-4 rounded-xl border border-transparent hover:border-gray-200 hover:shadow-lg transition-all ${colorCount > 0 ? 'cursor-pointer' : 'cursor-not-allowed opacity-60'}" data-style="${style.name}" data-color-count="${colorCount}">
                    <div class="product-card-image-wrapper bg-white rounded-md mb-4">
                        <img src="${style.image_url || 'https://placehold.co/400x400/EAEAEA/333?text=' + encodeURIComponent(style.name)}" 
                             alt="${style.name}" 
                             class="w-full h-auto aspect-square object-cover product-card-image">
                    </div>
                    <div class="text-left">
                        <h3 class="font-semibold text-lg mb-2">${style.name}</h3>
                        <p class="text-sm text-gray-600 mb-3">${colorCount} color${colorCount !== 1 ? 's' : ''} available</p>
                        <button class="btn-minimal inline-block text-sm font-bold py-2 px-5 rounded-md w-full ${colorCount === 0 ? 'opacity-50 cursor-not-allowed' : ''}">
                            ${colorCount > 0 ? 'View Colors' : 'No Colors Available'}
                        </button>
                    </div>
                </div>
            `;
        }).join('');
        
        productCount.textContent = `${sortedStyles.length} styles`;
    }

    function renderDoorColors(doorColors, doorStyleName) {
        if (doorColors.length === 0) {
            productGrid.innerHTML = `<div class="sm:col-span-2 xl:col-span-3 text-center text-gray-500 py-16">
                <p class="font-semibold text-lg">No colors available</p>
                <p class="mt-2">No colors are currently available for ${doorStyleName}.</p>
            </div>`;
            productCount.textContent = '0 colors';
            return;
        }

        // Apply sorting
        let sortedColors = [...doorColors];
        switch(sortBy.value) {
            case 'name-asc':
                sortedColors.sort((a, b) => a.name.localeCompare(b.name));
                break;
            case 'name-desc':
                sortedColors.sort((a, b) => b.name.localeCompare(a.name));
                break;
            case 'featured':
            default:
                // Just use the default order
                break;
        }

        productGrid.innerHTML = sortedColors.map(color => `
            <div class="product-card bg-[#F8F7F4] p-4 rounded-xl border border-transparent hover:border-gray-200 hover:shadow-lg transition-all">
                <a href="#">
                     <div class="product-card-image-wrapper bg-white rounded-md">
                         <img src="${color.image_url}" alt="${color.name}" class="w-full h-auto aspect-square object-cover product-card-image">
                     </div>
                </a>
                <div class="mt-4 text-left">
                     <p class="text-xs text-gray-500">${color.door_style}</p>
                     <h3 class="font-semibold mt-1">${color.name}</h3>
                     <a href="#" class="btn-minimal inline-block text-sm font-bold py-2 px-5 mt-3 rounded-md">
                        View Details
                    </a>
                </div>
            </div>
        `).join('');
        
        productCount.textContent = `${doorColors.length} colors`;
    }

    function updatePageHeader(view, doorStyleName = null) {
        if (view === 'styles') {
            pageTitle.textContent = 'Choose Your Door Style';
            pageDescription.textContent = 'Select your preferred door style to see all available colors and start building your perfect kitchen.';
            backToStyles.classList.add('hidden');
        } else if (view === 'colors') {
            pageTitle.textContent = `${doorStyleName} Colors`;
            pageDescription.textContent = `Browse all available colors for the ${doorStyleName} door style.`;
            backToStyles.classList.remove('hidden');
        }
    }

    function updateBreadcrumb(view, doorStyleName = null) {
        if (view === 'styles') {
            breadcrumbNav.innerHTML = `
                <div class="flex items-center space-x-2 text-sm text-gray-600">
                    <a href="{{ route('home') }}" class="breadcrumb-item hover:underline">Home</a>
                    <span>/</span>
                    <span class="breadcrumb-item active">Shop</span>
                </div>
            `;
        } else if (view === 'colors') {
            breadcrumbNav.innerHTML = `
                <div class="flex items-center space-x-2 text-sm text-gray-600">
                    <a href="{{ route('home') }}" class="breadcrumb-item hover:underline">Home</a>
                    <span>/</span>
                    <a href="#" class="breadcrumb-item hover:underline" id="breadcrumb-shop">Shop</a>
                    <span>/</span>
                    <span class="breadcrumb-item active">${doorStyleName}</span>
                </div>
            `;
        }
    }
    
    // --- LOGIC ---
    function showDoorStyles() {
        currentView = 'styles';
        selectedDoorStyle = null;
        renderDoorStyles();
        updatePageHeader('styles');
        updateBreadcrumb('styles');
    }

    function showDoorColors(doorStyleName) {
        currentView = 'colors';
        selectedDoorStyle = doorStyleName;
        const doorColors = doorColorsByStyle[doorStyleName] || [];
        currentDoorColors = doorColors;
        renderDoorColors(doorColors, doorStyleName);
        updatePageHeader('colors', doorStyleName);
        updateBreadcrumb('colors', doorStyleName);
    }

    // --- EVENT LISTENERS ---
    function setupEventListeners(container) {
        container.addEventListener('change', e => {
            if (e.target.matches('.door-style-filter')) {
                const checkedDoorStyles = [...container.querySelectorAll('.door-style-filter:checked')].map(cb => cb.value);
                
                if (checkedDoorStyles.length > 0) {
                    selectedDoorStyle = checkedDoorStyles[0]; // Take the first selected style
                    const colorCount = doorColorsByStyle[selectedDoorStyle]?.length || 0;
                    
                    if (colorCount > 0) {
                        showDoorColors(selectedDoorStyle);
                    } else {
                        alert('No colors are currently available for this door style. Please check back later.');
                        // Uncheck the filter since there are no colors
                        e.target.checked = false;
                    }
                } else {
                    selectedDoorStyle = null;
                    showDoorStyles();
                }
            }
        });
    }

    // Product grid click handler
    productGrid.addEventListener('click', e => {
        if (currentView === 'styles') {
            const styleCard = e.target.closest('.product-card');
            if (styleCard) {
                const styleName = styleCard.dataset.style;
                const colorCount = parseInt(styleCard.dataset.colorCount) || 0;
                
                if (colorCount > 0) {
                    showDoorColors(styleName);
                } else {
                    // Show a message that no colors are available
                    alert('No colors are currently available for this door style. Please check back later.');
                }
            }
        }
    });

    // Back to styles button
    backToStyles.addEventListener('click', () => {
        showDoorStyles();
    });

    // Breadcrumb navigation
    breadcrumbNav.addEventListener('click', e => {
        if (e.target.id === 'breadcrumb-shop') {
            e.preventDefault();
            showDoorStyles();
        }
    });
    
    sortBy.addEventListener('change', e => {
        if (currentView === 'styles') {
            renderDoorStyles();
        } else if (currentView === 'colors' && selectedDoorStyle) {
            const doorColors = doorColorsByStyle[selectedDoorStyle] || [];
            renderDoorColors(doorColors, selectedDoorStyle);
        }
    });

    // Mobile filter menu toggle
    mobileFilterButton.addEventListener('click', () => {
        mobileFilterBackdrop.classList.remove('hidden');
        setTimeout(() => {
            mobileFilterBackdrop.classList.remove('opacity-0');
            mobileFilterMenu.classList.remove('-translate-x-full');
        }, 10);
    });

    const closeMenu = () => {
        mobileFilterMenu.classList.add('-translate-x-full');
        mobileFilterBackdrop.classList.add('opacity-0');
        setTimeout(() => {
            mobileFilterBackdrop.classList.add('hidden');
        }, 300);
    };
    closeMobileFilter.addEventListener('click', closeMenu);
    mobileFilterBackdrop.addEventListener('click', closeMenu);

    // --- INITIALIZATION ---
    setupEventListeners(document.getElementById('filters-sidebar'));
    setupEventListeners(document.getElementById('mobile-filter-content'));
    
    // Start with door styles view
    showDoorStyles();
    
    lucide.createIcons();
});
</script>
@endsection 