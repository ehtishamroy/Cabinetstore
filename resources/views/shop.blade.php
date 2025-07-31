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
    .color-filter-item img {
        transition: transform 0.2s, box-shadow 0.2s;
        border: 2px solid #EAEAEA;
    }
    .color-filter-item.selected img {
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
</style>
@endsection

@section('content')
<main>
    <div class="max-w-7xl mx-auto px-6 md:px-10 py-8">
        <!-- Page Header -->
        <div class="text-center py-8">
            <h1 class="text-4xl md:text-5xl font-light">All Cabinet Styles</h1>
            <p class="mt-4 text-gray-600 max-w-2xl mx-auto">From timeless shaker designs to sleek modern aesthetics, find the perfect foundation for your dream kitchen. Each collection is crafted for quality, style, and simplicity.</p>
        </div>
        
        <div class="flex">
            <!-- Filters Sidebar (Desktop) -->
            <aside id="filters-sidebar" class="hidden lg:block w-1/4 pr-8">
                <div class="sticky top-28">
                     <div id="filter-content" class="bg-[#F8F7F4] p-6 rounded-xl">
                        <!-- Category Filter -->
                        <div class="mb-8">
                            <h3 class="font-semibold mb-4">Category</h3>
                            <div id="category-filters" class="space-y-3">
                                <!-- Populated by JS -->
                            </div>
                        </div>

                        <!-- Color Filter -->
                        <div class="mb-8">
                            <h3 class="font-semibold mb-4">Color</h3>
                            <div id="color-filters" class="grid grid-cols-4 gap-4">
                                <!-- Populated by JS -->
                            </div>
                        </div>
                        
                        <!-- Price Range Filter -->
                        <div>
                            <h3 class="font-semibold mb-4">Price Range</h3>
                            <div class="relative">
                                 <input type="range" id="price-range" min="0" max="2000" value="2000" class="w-full">
                                 <div class="flex justify-between text-sm text-gray-500 mt-2">
                                     <span>$0</span>
                                     <span id="price-value">$2000</span>
                                 </div>
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
                    <p id="product-count" class="text-sm text-gray-500 hidden lg:block">Loading products...</p>
                    <select id="sort-by" class="border border-secondary rounded-md px-4 py-2 text-sm focus:outline-none bg-white">
                        <option value="featured">Sort by: Featured</option>
                        <option value="price-asc">Price: Low to High</option>
                        <option value="price-desc">Price: High to Low</option>
                    </select>
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
    // --- MOCK DATA ---
    const allProducts = [
        { id: 1, name: 'Classic White Shaker', price: 1250, category: 'Shaker', subCategory: 'Standard', color: 'White', colorHex: '#FFFFFF', imageUrl: 'https://placehold.co/400x400/FFFFFF/333?text=White+Shaker' },
        { id: 2, name: 'Modern Gray Slab', price: 1600, category: 'Modern', subCategory: 'Slab Door', color: 'Gray', colorHex: '#9CA3AF', imageUrl: 'https://placehold.co/400x400/9CA3AF/FFFFFF?text=Gray+Slab' },
        { id: 3, name: 'Navy Blue Shaker', price: 1450, category: 'Shaker', subCategory: 'Deep Color', color: 'Blue', colorHex: '#3B82F6', imageUrl: 'https://placehold.co/400x400/3B82F6/FFFFFF?text=Blue+Shaker' },
        { id: 4, name: 'Natural Oak Raised', price: 1800, category: 'Traditional', subCategory: 'Raised Panel', color: 'Wood', colorHex: '#D6C7B9', imageUrl: 'https://placehold.co/400x400/D6C7B9/333?text=Oak+Raised' },
        { id: 5, name: 'Charcoal Modern', price: 1700, category: 'Modern', subCategory: 'SuperMatte', color: 'Black', colorHex: '#374151', imageUrl: 'https://placehold.co/400x400/374151/FFFFFF?text=Charcoal+Modern' },
        { id: 6, name: 'Light Gray Shaker', price: 1300, category: 'Shaker', subCategory: 'Standard', color: 'Gray', colorHex: '#E5E7EB', imageUrl: 'https://placehold.co/400x400/E5E7EB/333?text=Light+Gray' },
        { id: 7, name: 'Espresso Traditional', price: 1550, category: 'Traditional', subCategory: 'Raised Panel', color: 'Wood', colorHex: '#5d4037', imageUrl: 'https://placehold.co/400x400/5d4037/FFFFFF?text=Espresso' },
        { id: 8, name: 'Matte Black Slab', price: 1950, category: 'Modern', subCategory: 'Slab Door', color: 'Black', colorHex: '#1F2937', imageUrl: 'https://placehold.co/400x400/1F2937/FFFFFF?text=Matte+Black' },
        { id: 9, name: 'Sage Green Shaker', price: 1500, category: 'Shaker', subCategory: 'Deep Color', color: 'Green', colorHex: '#86EFAC', imageUrl: 'https://placehold.co/400x400/86EFAC/333?text=Sage+Green' },
    ];

    const categories = [...new Set(allProducts.map(p => p.category))];
    const colors = [...new Map(allProducts.map(p => [p.color, {color: p.color, hex: p.colorHex}])).values()];

    // --- ELEMENTS ---
    const productGrid = document.getElementById('product-grid');
    const productCount = document.getElementById('product-count');
    const categoryFilters = document.getElementById('category-filters');
    const colorFilters = document.getElementById('color-filters');
    const priceRange = document.getElementById('price-range');
    const priceValue = document.getElementById('price-value');
    const sortBy = document.getElementById('sort-by');
    const mobileFilterButton = document.getElementById('mobile-filter-button');
    const mobileFilterMenu = document.getElementById('mobile-filter-menu');
    const mobileFilterBackdrop = document.getElementById('mobile-filter-backdrop');
    const closeMobileFilter = document.getElementById('close-mobile-filter');
    const filterContent = document.getElementById('filter-content');
    const mobileFilterContent = document.getElementById('mobile-filter-content');

    // --- STATE ---
    let filters = {
        categories: [],
        colors: [],
        maxPrice: 2000,
        sort: 'featured'
    };

    // --- RENDER FUNCTIONS ---
    function renderFilters() {
        // Categories
        categoryFilters.innerHTML = categories.map(cat => `
            <label class="flex items-center space-x-3 cursor-pointer">
                <input type="checkbox" value="${cat}" class="category-filter custom-checkbox h-5 w-5 rounded-md border-gray-300 text-gray-900 focus:ring-gray-900">
                <span class="text-sm">${cat}</span>
            </label>
        `).join('');
        
        // Colors
        colorFilters.innerHTML = colors.map(c => `
            <button class="color-filter-item flex flex-col items-center group" data-color="${c.color}">
                <img src="https://placehold.co/48x48/${c.hex.substring(1)}/${c.hex.substring(1)}?text=" alt="${c.color}" class="w-12 h-12 rounded-full object-cover">
                <span class="text-xs text-gray-600 mt-2 group-hover:text-black">${c.color}</span>
            </button>
        `).join('');

        // Clone filters for mobile
        mobileFilterContent.innerHTML = filterContent.innerHTML;
    }

    function renderProducts(productsToRender) {
        if (productsToRender.length === 0) {
            productGrid.innerHTML = `<div class="sm:col-span-2 xl:col-span-3 text-center text-gray-500 py-16">
                <p class="font-semibold text-lg">No products found</p>
                <p class="mt-2">Try adjusting your filters.</p>
            </div>`;
            productCount.textContent = '0 products';
            return;
        }

        productGrid.innerHTML = productsToRender.map(p => `
            <div class="product-card bg-[#F8F7F4] p-4 rounded-xl border border-transparent hover:border-gray-200 hover:shadow-lg transition-all">
                <a href="#">
                     <div class="product-card-image-wrapper bg-white rounded-md">
                         <img src="${p.imageUrl}" alt="${p.name}" class="w-full h-auto aspect-square object-cover product-card-image">
                     </div>
                </a>
                <div class="mt-4 text-left">
                     <p class="text-xs text-gray-500">${p.category} / ${p.subCategory}</p>
                     <h3 class="font-semibold mt-1">${p.name}</h3>
                     <p class="text-gray-800 mt-1">$${p.price.toFixed(2)}</p>
                     <a href="#" class="btn-minimal inline-block text-sm font-bold py-2 px-5 mt-3 rounded-md">
                        View Details
                    </a>
                </div>
            </div>
        `).join('');
        
        productCount.textContent = `${productsToRender.length} products`;
    }
    
    // --- LOGIC ---
    function applyFiltersAndSort() {
        let filtered = [...allProducts];

        // Category filter
        if (filters.categories.length > 0) {
            filtered = filtered.filter(p => filters.categories.includes(p.category));
        }
        
        // Color filter
        if (filters.colors.length > 0) {
            filtered = filtered.filter(p => filters.colors.includes(p.color));
        }
        
        // Price filter
        filtered = filtered.filter(p => p.price <= filters.maxPrice);

        // Sorting
        switch(filters.sort) {
            case 'price-asc':
                filtered.sort((a, b) => a.price - b.price);
                break;
            case 'price-desc':
                filtered.sort((a, b) => b.price - a.price);
                break;
            case 'featured':
            default:
                // Just use the default order for now
                break;
        }

        renderProducts(filtered);
    }

    // --- EVENT LISTENERS ---
    function setupEventListeners(container) {
        container.addEventListener('change', e => {
            if (e.target.matches('.category-filter')) {
                const checkedCategories = [...container.querySelectorAll('.category-filter:checked')].map(cb => cb.value);
                filters.categories = checkedCategories;
                applyFiltersAndSort();
            }
        });

        container.addEventListener('click', e => {
            const colorButton = e.target.closest('.color-filter-item');
            if (colorButton) {
                colorButton.classList.toggle('selected');
                const selectedColors = [...container.querySelectorAll('.color-filter-item.selected')].map(btn => btn.dataset.color);
                filters.colors = selectedColors;
                applyFiltersAndSort();
            }
        });
        
        const priceRangeInput = container.querySelector('#price-range');
        if(priceRangeInput) {
            priceRangeInput.addEventListener('input', e => {
                filters.maxPrice = parseInt(e.target.value);
                const priceValueSpan = container.querySelector('#price-value');
                if(priceValueSpan) priceValueSpan.textContent = `$${filters.maxPrice}`;
                applyFiltersAndSort();
            });
        }
    }
    
    sortBy.addEventListener('change', e => {
        filters.sort = e.target.value;
        applyFiltersAndSort();
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
    renderFilters();
    applyFiltersAndSort();
    setupEventListeners(document.getElementById('filters-sidebar'));
    setupEventListeners(document.getElementById('mobile-filter-content'));
    lucide.createIcons();
});
</script>
@endsection 