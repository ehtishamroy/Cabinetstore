@extends('layouts.app')

@section('title', $doorColor->name . ' - BH Cabinetry')

@section('styles')
<style>
    /* Product page specific styles */
    body {
        background-color: #ffffff;
    }
    
    .info-box { position: relative; }
    .info-box .tooltip {
        visibility: hidden; width: 220px; background-color: #333; color: #fff; text-align: center;
        border-radius: 6px; padding: 8px; position: absolute; z-index: 1; bottom: 125%;
        left: 50%; margin-left: -110px; opacity: 0; transition: opacity 0.3s;
    }
    .info-box .tooltip::after {
        content: ""; position: absolute; top: 100%; left: 50%; margin-left: -5px;
        border-width: 5px; border-style: solid; border-color: #333 transparent transparent transparent;
    }
    .info-box:hover .tooltip { visibility: visible; opacity: 1; }
    
    .gallery-thumbnail.active { border-color: #2D2D2D; }

    .fade-in-section { opacity: 0; transform: translateY(20px); transition: opacity 0.6s ease-out, transform 0.6s ease-out; }
    .fade-in-section.is-visible { opacity: 1; transform: translateY(0); }

    .accordion-content { max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out, padding 0.3s ease-out; padding-top: 0; padding-bottom: 0; }
    .accordion-item.active .accordion-content { max-height: 500px; padding-top: 0.5rem; padding-bottom: 1rem; }
    .accordion-item .accordion-icon { transition: transform 0.3s ease-out; }
    .accordion-item.active .accordion-icon { transform: rotate(45deg); }
    
    .filter-button.active, .sub-filter-button.active { background-color: #F8F7F4; color: #333333; }
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    
    /* Assembly Toggle Switch */
    .assembly-toggle-bg {
        background-color: #e5e7eb; /* gray-200 */
        transition: background-color 0.2s ease-in-out;
    }
    .assembly-toggle-bg.checked {
        background-color: #34d399; /* emerald-400 */
    }
    .assembly-toggle-handle {
        transform: translateX(0);
        transition: transform 0.2s ease-in-out;
    }
    .assembly-toggle-handle.checked {
        transform: translateX(100%);
    }

    /* Sticky totals bar "Glossy" style */
    #sticky-totals-bar {
        background-color: rgba(255, 255, 255, 0.7); /* Semi-transparent white */
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        color: #111827; /* gray-900 */
        border-top: 1px solid rgba(0,0,0,0.05);
        box-shadow: 0 -5px 25px -5px rgba(0,0,0,0.1);
    }
    
    .product-card.active {
        background-color: #F9FAFB; /* bg-gray-50 */
        border-color: #D1D5DB; /* border-gray-300 */
    }

    /* Hinge Indicator */
    .hinge-indicator-btn {
        background-color: #374151;
        color: #FFFFFF;
    }
</style>
@endsection

@section('content')
<!-- ===== Sub-Header ===== -->
<div id="sub-header-bar" class="bg-white text-primary text-sm font-medium text-center py-3 w-full border-b border-secondary sticky z-40">
    <span id="sub-header-text" class="transition-opacity duration-500 opacity-0"></span>
</div>

<main class="bg-white">
    <div class="px-6 md:px-10 py-8">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                
                <!-- Left Column -->
                <div class="lg:sticky lg:top-36 self-start">
                    <nav class="text-sm mb-4 text-gray-500">
                        <a href="{{ route('home') }}" class="hover:underline">Home</a> / 
                        <a href="{{ route('shop') }}" class="hover:underline">Shop</a> / 
                        <span>{{ $doorColor->name }}</span>
                    </nav>
                    <div class="mb-4">
                        <img id="featured-image" 
                             src="{{ $doorColor->main_image_url ?? $doorColor->image_url ?? 'https://placehold.co/600x600/D6C7B9/333333?text=Main+View' }}" 
                             alt="{{ $doorColor->name }}" 
                             class="w-full h-[400px] md:h-[500px] rounded-lg object-contain">
                    </div>
                    <div class="grid grid-cols-5 gap-2">
                        @if($doorColor->main_image_url)
                            <a href="{{ $doorColor->main_image_url }}" class="gallery-thumbnail block border-2 rounded-md overflow-hidden active">
                                <img src="{{ $doorColor->main_image_url }}" alt="{{ $doorColor->name }}" class="w-full h-20 object-cover">
                            </a>
                        @endif
                        @if($doorColor->gallery_images_urls && count($doorColor->gallery_images_urls) > 0)
                            @foreach($doorColor->gallery_images_urls as $galleryImage)
                                <a href="{{ $galleryImage }}" class="gallery-thumbnail block border-2 rounded-md overflow-hidden">
                                    <img src="{{ $galleryImage }}" alt="{{ $doorColor->name }}" class="w-full h-20 object-cover">
                                </a>
                            @endforeach
                        @endif
                        @if(!$doorColor->main_image_url && !$doorColor->gallery_images_urls)
                        <a href="https://placehold.co/600x600/D6C7B9/333333?text=Main+View" class="gallery-thumbnail block border-2 rounded-md overflow-hidden active">
                                <img src="https://placehold.co/100x100/D6C7B9/333333?text=View+1" alt="Thumbnail 1" class="w-full h-20 object-cover">
                        </a>
                        <a href="https://placehold.co/600x600/A99D8E/FFFFFF?text=Kitchen+Angle" class="gallery-thumbnail block border-2 rounded-md overflow-hidden">
                                <img src="https://placehold.co/100x100/A99D8E/FFFFFF?text=View+2" alt="Thumbnail 2" class="w-full h-20 object-cover">
                        </a>
                        @endif
                    </div>
                </div>
                
                <!-- Right Column -->
                <div>
                    <h1 class="text-3xl md:text-4xl font-light mb-6 lg:mt-12 fade-in-section">{{ $doorColor->name }}</h1>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mb-8 fade-in-section">
                       <div class="info-box flex items-center bg-gray-100 p-3 rounded-md">
                           <i data-lucide="warehouse" class="w-5 h-5 mr-3 text-gray-600"></i>
                           <p class="text-sm text-gray-700">Leaves warehouse in ~3 days</p>
                           <span class="tooltip">For RTA orders.</span>
                       </div>
                       <div class="info-box flex items-center bg-gray-100 p-3 rounded-md">
                           <i data-lucide="box" class="w-5 h-5 mr-3 text-gray-600"></i>
                           <p class="text-sm text-gray-700">Assembled ships in 7-10 days</p>
                           <span class="tooltip">We assemble for you!</span>
                       </div>
                    </div>
                    <a href="#product-list" class="w-full flex items-center justify-center btn-minimal font-bold py-4 px-8 text-lg mb-8 fade-in-section">
                        START SHOPPING NOW
                        <i data-lucide="arrow-down" class="ml-3 w-6 h-6 animate-bounce"></i>
                    </a>
                    
                    <!-- Dynamic Description Section -->
                    @if($doorColor->description)
                    <div class="backdrop-blur-lg border border-gray-200/50 rounded-xl p-6 mb-8 fade-in-section" style="background-color:#F6F5F3;">
                            <h3 class="text-xl font-semibold mb-4">Product Description</h3>
                            <div class="text-sm text-gray-700 leading-relaxed">
                                {!! $doorColor->description !!}
                            </div>
                            </div>
                    @endif
                    

                    
                    <!-- Materials Section -->
                    <div class="bg-gray-50/50 backdrop-blur-lg border border-gray-200/50 rounded-xl p-6 mb-8 fade-in-section">
                         <h3 class="text-xl font-semibold mb-4">Materials</h3>
                         <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                            <div class="flex items-center">
                                <img src="{{ asset('uploads/material/1.png') }}" alt="Dovetailed Drawer Construction" class="w-10 h-10 mr-4">
                                <span class="text-gray-700">Dovetailed Drawer Construction</span>
                            </div>
                            <div class="flex items-center">
                                <img src="{{ asset('uploads/material/2.png') }}" alt="Full Overlay" class="w-10 h-10 mr-4">
                                <span class="text-gray-700">Full Overlay</span>
                            </div>
                            <div class="flex items-center">
                                <img src="{{ asset('uploads/material/3.png') }}" alt="Sand Finish/Color" class="w-10 h-10 mr-4">
                                <span class="text-gray-700">Sand Finish/Color</span>
                            </div>
                            <div class="flex items-center">
                                <img src="{{ asset('uploads/material/4.png') }}" alt="3/4&quot; Plywood Shelves" class="w-10 h-10 mr-4">
                                <span class="text-gray-700">3/4&quot; Plywood Shelves</span>
                            </div>
                            <div class="flex items-center">
                                <img src="{{ asset('uploads/material/5.png') }}" alt="Soft-Closing Undermount, Full Extension Drawer Glides" class="w-10 h-10 mr-4">
                                <span class="text-gray-700">Soft-Closing Undermount, Full Extension Drawer Glides</span>
                            </div>
                            <div class="flex items-center">
                                <img src="{{ asset('uploads/material/6.png') }}" alt="Concealed with Soft Close Hinges" class="w-10 h-10 mr-4">
                                <span class="text-gray-700">Concealed with Soft Close Hinges</span>
                            </div>
                         </div>
                    </div>

                    <div class="border-t border-secondary mt-8 pt-8 fade-in-section">
                        <!-- Accordion FAQ -->
                        <div class="accordion-item border-b border-secondary">
                            <button class="accordion-button w-full flex justify-between items-center py-4 text-left font-semibold">
                                <span>What tools do I need for assembly?</span>
                                <i data-lucide="plus" class="accordion-icon w-5 h-5 text-gray-500"></i>
                            </button>
                            <div class="accordion-content text-gray-600 text-sm">
                                <p>You'll typically need a screwdriver or drill, a rubber mallet, and a tape measure. All other hardware like screws and brackets are included.</p>
                            </div>
                        </div>
                         <div class="accordion-item border-b border-secondary">
                            <button class="accordion-button w-full flex justify-between items-center py-4 text-left font-semibold">
                                <span>What is your return policy?</span>
                                <i data-lucide="plus" class="accordion-icon w-5 h-5 text-gray-500"></i>
                            </button>
                            <div class="accordion-content text-gray-600 text-sm">
                                <p>We offer a 30-day return policy on all unopened items. Please see our Shipping & Returns page for full details.</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-100 rounded-lg p-6 mt-8 flex items-center justify-between gap-4 fade-in-section">
                        <div>
                            <p class="font-semibold">Still have questions?</p>
                            <p class="text-2xl font-bold text-accent">(832) 422-5140</p>
                        </div>
                        <a href="tel:+18324225140" class="flex items-center justify-center btn-minimal font-bold py-3 px-6">
                            <i data-lucide="phone" class="mr-2 w-4 h-4"></i>
                            Call Now
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Shopping Collection Section -->
<section id="product-list" class="py-16 bg-white border-t border-secondary">
    <div class="max-w-7xl mx-auto px-6 md:px-10">
        <div class="text-center mb-6">
            <h2 class="text-3xl font-semibold">Shop {{ $doorColor->name }} Collection</h2>
            <p class="text-gray-600 mt-2">Select the cabinets you need to build your perfect kitchen.</p>
        </div>
        <div class="text-center mb-12 text-sm text-gray-500 flex items-center justify-center">
             <i data-lucide="info" class="w-4 h-4 mr-2"></i>
            <span id="filter-guide">Select a category to view items.</span>
        </div>
        
        <div id="main-filters" class="flex overflow-x-auto space-x-4 pb-4 mb-6 no-scrollbar md:flex-wrap md:justify-center md:gap-6 md:space-x-0">
            <!-- Main filters populated by JS -->
        </div>

        <!-- Sub-Filter Bar -->
        <div id="sub-filters" class="hidden flex overflow-x-auto space-x-4 pb-4 mb-12 no-scrollbar md:flex-wrap md:justify-center md:gap-4 md:space-x-0">
            <!-- Sub-filters populated by JS -->
        </div>

        <!-- Sub-Category Showcase -->
        <div id="subcategory-showcase" class="hidden mb-12 text-center transition-all duration-500 ease-in-out">
            <div class="max-w-xl mx-auto">
                <img id="subcategory-showcase-image" src="" alt="" class="w-full rounded-lg shadow-lg mb-4 h-80 object-contain">
                <h3 id="subcategory-showcase-title" class="text-2xl font-semibold text-gray-800"></h3>
            </div>
        </div>

        <!-- Product Grid -->
        <div id="product-grid-container" class="hidden">
            <!-- Product Table Header -->
            <div class="hidden lg:grid grid-cols-12 gap-4 items-center font-bold text-xs text-gray-500 mb-4 px-4 uppercase tracking-wider">
                <div class="col-span-3">Product</div>
                <div class="text-center">Stock</div>
                <div class="text-center">Qty</div>
                <div class="col-span-2 text-center">Assembly?</div>
                <div class="text-center">Unit Price</div>
                <div class="text-center">Hinge</div>
                <div class="text-center">Mods</div>
                <div class="text-center">Labor</div>
                <div class="text-right">Sub Total</div>
            </div>
            <div id="product-grid" class="grid grid-cols-1 gap-4">
                <!-- Product cards populated by JS -->
            </div>
        </div>
    </div>
</section>

<!-- ===== Sticky Totals Bar ===== -->
<div id="sticky-totals-bar" class="fixed bottom-0 left-0 right-0 p-4 z-50 transform translate-y-full transition-transform duration-300">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <div>
            <span class="text-lg font-semibold">Grand Total:</span>
            <span id="grand-total" class="text-2xl font-bold ml-2">$0.00</span>
        </div>
        <button id="add-to-cart-btn" class="bg-gray-900 hover:bg-black font-bold py-3 px-8 rounded-lg text-lg text-white shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">Add to Cart</button>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // --- DATA ---
    // productsData is now populated dynamically from the backend via Blade
    const categoriesData = @json($categories); // This is the new dynamic data source
    const doorColorId = {{ $doorColor->id }};

    // Map categoriesData to the old productsData structure for compatibility with existing JS
    const productsData = {};
    categoriesData.forEach(category => {
        const categoryKey = category.name.toLowerCase().replace(/\s/g, '-');
        productsData[categoryKey] = {
            name: category.name,
            icon: category.image_url,
            subCategories: {}
        };
        category.sub_categories.forEach(subCategory => {
            const subCategoryKey = subCategory.name.toLowerCase().replace(/\s/g, '-');
            productsData[categoryKey].subCategories[subCategoryKey] = {
                name: subCategory.name,
                icon: subCategory.image_url,
                items: [] // Products will be loaded dynamically later
            };
        });
    });

    // --- ELEMENTS ---
    const mainFiltersContainer = document.getElementById('main-filters');
    const subFiltersContainer = document.getElementById('sub-filters');
    const productGridContainer = document.getElementById('product-grid-container');
    const productGrid = document.getElementById('product-grid');
    const stickyTotalsBar = document.getElementById('sticky-totals-bar');
    const grandTotalEl = document.getElementById('grand-total');
    const subcategoryShowcase = document.getElementById('subcategory-showcase');
    const subcategoryShowcaseImage = document.getElementById('subcategory-showcase-image');
    const subcategoryShowcaseTitle = document.getElementById('subcategory-showcase-title');

    // --- STATE ---
    let cart = {};
    let productCache = {};

    // --- HELPER FUNCTIONS ---
    function findProductById(id) {
        return productCache[id] || null;
    }

    // --- RENDER FUNCTIONS ---
    function renderMainFilters() {
        mainFiltersContainer.innerHTML = categoriesData.map(category => {
            const categoryKey = category.name.toLowerCase().replace(/\s/g, '-');
            return `<button class="filter-button flex-shrink-0 flex flex-col items-center justify-center w-36 h-36 p-4 rounded-lg transition-colors duration-200" data-category="${categoryKey}" data-category-id="${category.id}"><img src="${category.image_url}" alt="${category.name}" class="h-16 mb-2"><span class="text-sm font-medium">${category.name}</span></button>`;
        }).join('');
    }

    function renderSubFilters(categoryKey) {
        const category = categoriesData.find(cat => cat.name.toLowerCase().replace(/\s/g, '-') === categoryKey);
        if (!category || !category.sub_categories) {
            subFiltersContainer.innerHTML = '';
            subFiltersContainer.classList.add('hidden');
            return;
        }
        subFiltersContainer.innerHTML = category.sub_categories.map(subCategory => {
            const subCategoryKey = subCategory.name.toLowerCase().replace(/\s/g, '-');
            return `<button class="sub-filter-button flex-shrink-0 flex items-center space-x-3 p-3 rounded-lg transition-colors duration-200" data-category="${categoryKey}" data-subcategory="${subCategoryKey}" data-category-id="${category.id}" data-subcategory-id="${subCategory.id}"><img src="${subCategory.image_url}" alt="${subCategory.name}" class="h-8"><span class="text-sm font-medium">${subCategory.name}</span></button>`;
        }).join('');
        subFiltersContainer.classList.remove('hidden');
    }
    
    function renderHingeSelector(item) {
        const options = item.hingeOptions;
        if (options.includes('Both')) {
             return `<div class="flex items-center justify-center space-x-1 p-1 bg-gray-200 rounded-md cursor-default">
                <span class="hinge-indicator-btn text-xs font-semibold px-2 py-0.5 rounded-md">L</span>
                <span class="hinge-indicator-btn text-xs font-semibold px-2 py-0.5 rounded-md">R</span>
            </div>`;
        } else if (options.length > 1) {
            // This case can be used for selectable L/R in the future if needed
             return `<span class="text-sm font-medium">${options.join('/')}</span>`;
        } else {
            return `<span class="text-sm font-medium">${options[0] || 'N/A'}</span>`;
        }
    }

    function renderProductGrid(items) {
        productGrid.innerHTML = items.map(item => {
            const cartItem = cart[item.id] || { qty: 0, assembly: false };
            let subTotal = cartItem.qty * item.unitPrice;
            if (cartItem.assembly) {
                subTotal += cartItem.qty * item.laborCost;
            }
            const assemblyChecked = cartItem.assembly ? 'checked' : '';
            const activeClass = cartItem.qty > 0 ? 'active' : '';
            
            return `
            <div class="product-card border rounded-lg p-4 transition-colors duration-200 ${activeClass}" data-id="${item.id}">
                <!-- Desktop Grid -->
                <div class="hidden lg:grid grid-cols-12 gap-4 items-center">
                    <div class="col-span-3">
                            <p class="font-bold">${item.name}</p>
                    </div>
                    <div class="text-center text-sm">${item.stock}</div>
                    <div class="flex justify-center"><input type="number" value="${cartItem.qty}" min="0" class="qty-input w-16 text-center border border-gray-300 rounded-md p-1 bg-white"></div>
                    <div class="col-span-2 flex justify-center items-center space-x-2">
                        <span class="text-sm">No</span>
                        <button class="assembly-toggle relative inline-flex items-center h-6 rounded-full w-11"><span class="assembly-toggle-bg ${assemblyChecked} absolute w-full h-full rounded-full"></span><span class="assembly-toggle-handle ${assemblyChecked} absolute left-0 inline-block w-5 h-5 bg-white rounded-full shadow transform"></span></button>
                        <span class="text-sm">Yes</span>
                    </div>
                    <div class="text-center">$${item.unitPrice.toFixed(2)}</div>
                    <div class="text-center hinge-container">${renderHingeSelector(item)}</div>
                    <div class="flex justify-center">${item.modifications ? `<button class="mod-button"><i data-lucide="edit-2" class="w-4 h-4 text-gray-500 hover:text-accent"></i></button>` : 'N/A'}</div>
                    <div class="text-center text-sm text-gray-500">$<span class="labor-cost">${item.laborCost.toFixed(2)}</span></div>
                    <div class="text-right font-bold text-lg">$<span class="sub-total">${subTotal.toFixed(2)}</span></div>
                </div>
                <!-- Mobile View -->
                <div class="lg:hidden">
                    <p class="font-bold text-lg mb-4">${item.name}</p>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <label class="font-medium text-sm">Quantity</label>
                            <input type="number" value="${cartItem.qty}" min="0" class="qty-input w-20 text-center border border-gray-300 rounded-md p-1 bg-white">
                        </div>
                        <div class="flex justify-between items-center">
                            <label class="font-medium text-sm">Assembly?</label>
                            <div class="flex items-center space-x-2">
                                <span class="text-sm">No</span>
                                <button class="assembly-toggle relative inline-flex items-center h-6 rounded-full w-11"><span class="assembly-toggle-bg ${assemblyChecked} absolute w-full h-full rounded-full"></span><span class="assembly-toggle-handle ${assemblyChecked} absolute left-0 inline-block w-5 h-5 bg-white rounded-full shadow transform"></span></button>
                                <span class="text-sm">Yes</span>
                            </div>
                        </div>
                         <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Unit Price</span>
                            <span class="font-medium">$${item.unitPrice.toFixed(2)}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Labor</span>
                            <span class="font-medium">$${item.laborCost.toFixed(2)}</span>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Hinge</span>
                            <div class="hinge-container">${renderHingeSelector(item)}</div>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Modifications</span>
                            <span class="font-medium">${item.modifications ? `<button class="mod-button"><i data-lucide="edit-2" class="w-4 h-4 text-gray-500 hover:text-accent"></i></button>` : 'N/A'}</span>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t-2 border-gray-200 flex justify-between items-center">
                        <span class="font-semibold text-lg">Sub Total</span>
                        <span class="font-bold text-xl">$<span class="sub-total">${subTotal.toFixed(2)}</span></span>
                    </div>
                </div>
            </div>
        `;
        }).join('');
        lucide.createIcons();
    }

    // --- EVENT HANDLERS & LOGIC ---
    function handleFilterClick(e) {
        const button = e.target.closest('.filter-button');
        if (!button) return;
        document.querySelectorAll('.filter-button').forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');
        productGridContainer.classList.add('hidden');
        const categoryKey = button.dataset.category;
        renderSubFilters(categoryKey);
        // Auto-click the first sub-filter
        subFiltersContainer.querySelector('.sub-filter-button')?.click();
    }

    function handleSubFilterClick(e) {
        const button = e.target.closest('.sub-filter-button');
        if (!button) return;
        document.querySelectorAll('.sub-filter-button').forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');
        const categoryKey = button.dataset.category;
        const subCategoryKey = button.dataset.subcategory;
        
        // Update showcase
        const categoryKeyForFilter = button.dataset.category;
        const category = productsData[categoryKeyForFilter];
        if (category && category.subCategories[subCategoryKey]) {
            const subCategory = category.subCategories[subCategoryKey];
            subcategoryShowcaseImage.src = subCategory.icon;
            subcategoryShowcaseImage.alt = subCategory.name;
            subcategoryShowcaseTitle.textContent = subCategory.name;
            subcategoryShowcase.classList.remove('hidden');
        } else {
            subcategoryShowcase.classList.add('hidden');
        }
        
        // Get the category and subcategory IDs from the data attributes
        const categoryId = button.dataset.categoryId;
        const subcategoryId = button.dataset.subcategoryId;
        
        // Load products dynamically based on subcategory
        loadProductsBySubcategory(subcategoryId);
    }
    
    function loadProductsBySubcategory(subcategoryId) {
        // Show loading state
        productGrid.innerHTML = '<div class="text-center py-8"><div class="animate-spin rounded-full h-8 w-8 border-b-2 border-gray-900 mx-auto"></div><p class="mt-2 text-gray-600">Loading products...</p></div>';
        productGridContainer.classList.remove('hidden');
        
        // Fetch products from the backend
        fetch(`/products/by-subcategory/${subcategoryId}?doorColorId=${doorColorId}`)
            .then(response => response.json())
            .then(data => {
                if (data.products && data.products.length > 0) {
                    // Cache the loaded products
                    data.products.forEach(product => {
                        productCache[product.id] = product;
                    });
                    renderProductGrid(data.products);
                    // Update grand total after loading new products
                    updateGrandTotal();
                } else {
                    productGrid.innerHTML = '<div class="text-center py-8"><p class="text-gray-600">No products found for this category.</p></div>';
                }
            })
            .catch(error => {
                console.error('Error loading products:', error);
                productGrid.innerHTML = '<div class="text-center py-8"><p class="text-red-600">Error loading products. Please try again.</p></div>';
            });
    }

    function handleProductCardInteraction(e) {
        const card = e.target.closest('.product-card');
        if (!card) return;

        // Sync inputs between mobile and desktop views
        const qtyInputs = card.querySelectorAll('.qty-input');
        if (e.target.matches('.qty-input')) {
            const value = e.target.value;
            qtyInputs.forEach(input => input.value = value);
        }

        const id = card.dataset.id;
        const qty = parseInt(card.querySelector('.qty-input').value) || 0; 
        const assembly = card.querySelector('.assembly-toggle-bg').classList.contains('checked');
        
        updateCart(id, qty, assembly);
        updateCardUI(card);
        updateGrandTotal();
    }

    function updateCart(id, qty, assembly) {
        if (qty > 0) {
             cart[id] = { qty, assembly };
        } else {
             delete cart[id];
        }
    }
    
    function updateCardUI(card) {
        const id = card.dataset.id;
        const product = findProductById(id);
        if (!product) return;

        const qty = parseInt(card.querySelector('.qty-input').value) || 0;
        const wantsAssembly = card.querySelector('.assembly-toggle-bg').classList.contains('checked');

        let subTotal = qty * product.unitPrice;
        if (wantsAssembly) {
            subTotal += qty * product.laborCost;
        }
        
        card.querySelectorAll('.sub-total').forEach(el => {
            el.textContent = subTotal.toFixed(2);
        });
        
        if (qty > 0) {
            card.classList.add('active');
        } else {
            card.classList.remove('active');
        }
    }

    function updateGrandTotal() {
        let total = 0;
        for (const id in cart) {
            const cartItem = cart[id];
            const product = findProductById(id);
            if (product) {
                let itemTotal = cartItem.qty * product.unitPrice;
                if (cartItem.assembly) {
                    itemTotal += cartItem.qty * product.laborCost;
                }
                total += itemTotal;
            }
        }
        grandTotalEl.textContent = `$${total.toFixed(2)}`;
        
        // Show/hide sticky totals bar based on cart items
        if (Object.keys(cart).length > 0 && total > 0) {
            stickyTotalsBar.classList.remove('translate-y-full');
        } else {
            stickyTotalsBar.classList.add('translate-y-full');
        }
    }

    function handleAssemblyToggle(e) {
        const button = e.target.closest('.assembly-toggle');
        if (!button) return;

        const card = button.closest('.product-card');
        const toggles = card.querySelectorAll('.assembly-toggle');

        toggles.forEach(toggle => {
            toggle.querySelector('.assembly-toggle-bg').classList.toggle('checked');
            toggle.querySelector('.assembly-toggle-handle').classList.toggle('checked');
        });
        
        handleProductCardInteraction(e);
    }

    // --- INITIALIZATION ---
    function initializeShoppingSection() {
        renderMainFilters();
        // Use a small timeout to ensure the DOM is fully ready for the clicks
        setTimeout(() => {
        const firstMainFilter = mainFiltersContainer.querySelector('.filter-button');
        if (firstMainFilter) {
            firstMainFilter.click();
        }
        }, 100);
    }
    
    initializeShoppingSection();
    
    mainFiltersContainer.addEventListener('click', handleFilterClick);
    subFiltersContainer.addEventListener('click', handleSubFilterClick);
    productGrid.addEventListener('input', handleProductCardInteraction);
    productGrid.addEventListener('click', handleAssemblyToggle);

    // Initialize grand total on page load
    updateGrandTotal();

    // Add to cart functionality
    const addToCartBtn = document.getElementById('add-to-cart-btn');
    addToCartBtn.addEventListener('click', () => {
        const cartItems = Object.keys(cart);
        if (cartItems.length === 0) {
            alert('Please add some items to your cart first');
            return;
        }

        // Add each cart item to the global cart
        cartItems.forEach(productId => {
            const product = findProductById(productId);
            if (product) {
                const cartItem = cart[productId];
                const productData = {
                    name: product.name,
                    qty: cartItem.qty,
                    unitPrice: product.unitPrice,
                    laborCost: product.laborCost,
                    assembly: cartItem.assembly,
                    doorColorId: doorColorId,
                    imageUrl: product.imageUrl
                };
                
                // Use the global addToCart function from the header
                if (window.addToCart) {
                    window.addToCart(productId, productData);
                }
            }
        });

        // Clear the local cart
        cart = {};
        updateGrandTotal();
        
        // Redirect to cart page
        window.location.href = '{{ route('cart') }}';
    });

    // --- Other page logic ---
    const subHeaderAnnouncements = ["FREE SHIPPING ON ORDERS OVER $2,500", "LIFETIME LIMITED WARRANTY"];
    let subHeaderIndex = 0;
    const subHeaderTextEl = document.getElementById("sub-header-text");
    
    function cycleSubHeaderAnnouncements() {
        if (!subHeaderTextEl) return;
        subHeaderTextEl.style.opacity = "0";
        setTimeout(() => {
            subHeaderIndex = (subHeaderIndex + 1) % subHeaderAnnouncements.length;
            subHeaderTextEl.textContent = subHeaderAnnouncements[subHeaderIndex];
            subHeaderTextEl.style.opacity = "1";
        }, 500);
    }
    
    if (subHeaderTextEl) {
        subHeaderTextEl.textContent = subHeaderAnnouncements[0];
        subHeaderTextEl.style.opacity = "1";
        setInterval(cycleSubHeaderAnnouncements, 4000);
    }
    
    // Gallery functionality
    const featuredImage = document.getElementById("featured-image");
    const galleryThumbnails = document.querySelectorAll(".gallery-thumbnail");
    
    galleryThumbnails.forEach(thumbnail => {
        thumbnail.addEventListener("click", (e) => {
            e.preventDefault();
            const newSrc = e.currentTarget.href;
            if (featuredImage) {
                featuredImage.src = newSrc;
            }
            galleryThumbnails.forEach(t => t.classList.remove("active"));
            e.currentTarget.classList.add("active");
        });
    });
    
    // Accordion functionality
    const accordionButtons = document.querySelectorAll(".accordion-button");
    accordionButtons.forEach(button => {
        button.addEventListener("click", () => {
            button.parentElement.classList.toggle("active");
        });
    });
    
    // Fade in animations
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add("is-visible");
            }
        });
    }, { threshold: 0.1 });
    
    document.querySelectorAll(".fade-in-section").forEach(section => {
        observer.observe(section);
    });
    
    lucide.createIcons();
});
</script>
@endsection 