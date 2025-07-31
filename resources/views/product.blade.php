@extends('layouts.app')

@section('title', 'Weston Sand Shaker - Aura Cabinets')

@section('styles')
<style>
    /* Product page specific styles */
    body {
        background-color: #ffffff;
        padding-bottom: 80px; /* Add padding for the sticky totals bar */
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
                        <a href="#" class="hover:underline">Home</a> / <span>Weston Sand Shaker</span>
                    </nav>
                    <div class="mb-4">
                        <img id="featured-image" src="https://placehold.co/600x600/D6C7B9/333333?text=Main+View" alt="Main view" class="w-full h-auto rounded-lg">
                    </div>
                    <div class="grid grid-cols-5 gap-2">
                        <a href="https://placehold.co/600x600/D6C7B9/333333?text=Main+View" class="gallery-thumbnail block border-2 rounded-md overflow-hidden active">
                            <img src="https://placehold.co/100x100/D6C7B9/333333?text=View+1" alt="Thumbnail 1" class="w-full h-auto">
                        </a>
                        <a href="https://placehold.co/600x600/A99D8E/FFFFFF?text=Kitchen+Angle" class="gallery-thumbnail block border-2 rounded-md overflow-hidden">
                            <img src="https://placehold.co/100x100/A99D8E/FFFFFF?text=View+2" alt="Thumbnail 2" class="w-full h-auto">
                        </a>
                    </div>
                </div>
                
                <!-- Right Column -->
                <div>
                    <h1 class="text-3xl md:text-4xl font-light mb-6 lg:mt-12 fade-in-section">Weston Sand Shaker</h1>
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
                    
                    <!-- Specifications Section -->
                    <div class="bg-gray-50/50 backdrop-blur-lg border border-gray-200/50 rounded-xl p-6 mb-8 fade-in-section">
                        <h3 class="text-xl font-semibold mb-4">Door Specifications</h3>
                        <dl class="space-y-4 text-sm">
                            <div>
                                <dt class="font-semibold text-gray-800">Door Construction</dt>
                                <dd class="text-gray-600">5 Piece HDF Door/Drawer</dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-gray-800">Overlay</dt>
                                <dd class="text-gray-600">Full Overlay Door/Drawer Front</dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-gray-800">Box Construction</dt>
                                <dd class="text-gray-600">¾" Solid Hardwood Frame, ½" Plywood Box with Matching Interior/Exterior Veneer Finish, 3/16" Plywood Skin on a ½" Plywood Frame Back, 5/8" Solid Wood Dovetailed Drawer Box with ½" Plywood Drawer Bottom</dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-gray-800">Hardware</dt>
                                <dd class="text-gray-600">90 Degree Metal Corner L Brackets, Soft-Close Undermount Drawer Slides, Concealed 6-Way Adjustable Slow-Close Door Hinges, Rubber Door/Drawer Bumpers, Clear Plastic Shelf Brackets</dd>
                            </div>
                            <div>
                                <dt class="font-semibold text-gray-800">Assembly</dt>
                                <dd class="text-gray-600">Metal Brackets, Screws, Finishing Nails, and Staples (optional – with local pick up only)</dd>
                            </div>
                        </dl>
                    </div>
                    
                    <!-- Materials Section -->
                    <div class="bg-gray-50/50 backdrop-blur-lg border border-gray-200/50 rounded-xl p-6 mb-8 fade-in-section">
                         <h3 class="text-xl font-semibold mb-4">Materials</h3>
                         <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-6 gap-y-4 text-sm">
                            <div class="flex items-center"><img src="https://placehold.co/40x40/cccccc/333333?text=ICON" alt="icon" class="w-10 h-10 mr-4"><span class="text-gray-700">Dovetailed Drawer Construction</span></div>
                            <div class="flex items-center"><img src="https://placehold.co/40x40/cccccc/333333?text=ICON" alt="icon" class="w-10 h-10 mr-4"><span class="text-gray-700">Full Overlay</span></div>
                            <div class="flex items-center"><img src="https://placehold.co/40x40/cccccc/333333?text=ICON" alt="icon" class="w-10 h-10 mr-4"><span class="text-gray-700">Soft-Closing Undermount, Full Extension Drawer Glides</span></div>
                            <div class="flex items-center"><img src="https://placehold.co/40x40/cccccc/333333?text=ICON" alt="icon" class="w-10 h-10 mr-4"><span class="text-gray-700">3/4" Plywood Shelves</span></div>
                            <div class="flex items-center"><img src="https://placehold.co/40x40/cccccc/333333?text=ICON" alt="icon" class="w-10 h-10 mr-4"><span class="text-gray-700">Solid Wood Face Frame</span></div>
                            <div class="flex items-center"><img src="https://placehold.co/40x40/cccccc/333333?text=ICON" alt="icon" class="w-10 h-10 mr-4"><span class="text-gray-700">Concealed with Soft Close Hinges</span></div>
                            <div class="flex items-center"><img src="https://placehold.co/40x40/cccccc/333333?text=ICON" alt="icon" class="w-10 h-10 mr-4"><span class="text-gray-700">White Finish/Color</span></div>
                            <div class="flex items-center"><img src="https://placehold.co/40x40/cccccc/333333?text=ICON" alt="icon" class="w-10 h-10 mr-4"><span class="text-gray-700">5/8" Solid Wood Drawer Box</span></div>
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
                            <p class="text-2xl font-bold text-accent">1-800-555-AURA</p>
                        </div>
                        <a href="tel:1-800-555-2872" class="flex items-center justify-center btn-minimal font-bold py-3 px-6">
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
            <h2 class="text-3xl font-semibold">Shop Weston Sand Shaker Collection</h2>
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

        <!-- Product Grid -->
        <div id="product-grid-container" class="hidden">
            <!-- Product Table Header -->
            <div class="hidden lg:grid grid-cols-12 gap-4 items-center font-bold text-xs text-gray-500 mb-4 px-4 uppercase tracking-wider">
                <div class="col-span-2">Product</div>
                <div class="text-center">Stock</div>
                <div class="text-center">Qty</div>
                <div class="col-span-2 text-center">Assembly?</div>
                <div class="text-center">Unit Price</div>
                <div class="text-center">Hinge</div>
                <div class="text-center">Mods</div>
                <div class="text-center">Labor</div>
                <div class="col-span-2 text-right">Sub Total</div>
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
        <button class="bg-gray-900 hover:bg-black font-bold py-3 px-8 rounded-lg text-lg text-white shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">Add to Cart</button>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // --- DATA ---
    const productsData = {
        "base-cabinets": {
            name: "Base Cabinets",
            icon: "https://placehold.co/80x50/8c7a6b/ffffff?text=Base",
            subCategories: {
                "single-door": {
                    name: "Single Door",
                    icon: "https://placehold.co/60x40/a6988d/ffffff?text=1-Door",
                    items: [
                        { id: 1, name: "B12 Base", stock: "In Stock", unitPrice: 150.00, assemblyCost: 30, laborCost: 15, hingeOptions: ['L', 'R'], modifications: true },
                        { id: 2, name: "B15 Base", stock: "In Stock", unitPrice: 175.00, assemblyCost: 35, laborCost: 18, hingeOptions: ['L'], modifications: true },
                    ]
                },
                "double-door": {
                    name: "Double Door",
                    icon: "https://placehold.co/60x40/a6988d/ffffff?text=2-Door",
                    items: [
                        { id: 3, name: "B24 Base", stock: "In Stock", unitPrice: 250.00, assemblyCost: 50, laborCost: 25, hingeOptions: ['N/A'], modifications: true },
                        { id: 4, name: "B30 Base", stock: "In Stock", unitPrice: 280.00, assemblyCost: 55, laborCost: 28, hingeOptions: ['Both'], modifications: true },
                    ]
                },
            }
        },
        "wall-cabinets": {
            name: "Wall Cabinets",
            icon: "https://placehold.co/80x50/8c7a6b/ffffff?text=Wall",
            subCategories: {
                "small-wall": {
                    name: "Small Wall",
                    icon: "https://placehold.co/60x40/a6988d/ffffff?text=Small",
                    items: [
                       { id: 5, name: "W1230 Wall", stock: "Low Stock", unitPrice: 120.00, assemblyCost: 25, laborCost: 12, hingeOptions: ['L', 'R'], modifications: false },
                    ]
                }
            }
        },
    };

    // --- ELEMENTS ---
    const mainFiltersContainer = document.getElementById('main-filters');
    const subFiltersContainer = document.getElementById('sub-filters');
    const productGridContainer = document.getElementById('product-grid-container');
    const productGrid = document.getElementById('product-grid');
    const stickyTotalsBar = document.getElementById('sticky-totals-bar');
    const grandTotalEl = document.getElementById('grand-total');

    // --- STATE ---
    let cart = {};

    // --- HELPER FUNCTIONS ---
    function findProductById(id) {
        for (const categoryKey in productsData) {
            const category = productsData[categoryKey];
            for (const subCategoryKey in category.subCategories) {
                const subCategory = category.subCategories[subCategoryKey];
                const foundItem = subCategory.items.find(item => item.id === parseInt(id));
                if (foundItem) {
                    return foundItem;
                }
            }
        }
        return null;
    }

    // --- RENDER FUNCTIONS ---
    function renderMainFilters() {
        mainFiltersContainer.innerHTML = Object.keys(productsData).map(key => {
            const category = productsData[key];
            return `<button class="filter-button flex-shrink-0 flex flex-col items-center justify-center w-36 h-36 p-4 rounded-lg transition-colors duration-200" data-category="${key}"><img src="${category.icon}" alt="${category.name}" class="h-16 mb-2"><span class="text-sm font-medium">${category.name}</span></button>`;
        }).join('');
    }

    function renderSubFilters(categoryKey) {
        const category = productsData[categoryKey];
        if (!category || !category.subCategories) {
            subFiltersContainer.innerHTML = '';
            subFiltersContainer.classList.add('hidden');
            return;
        }
        subFiltersContainer.innerHTML = Object.keys(category.subCategories).map(key => {
            const subCategory = category.subCategories[key];
            return `<button class="sub-filter-button flex-shrink-0 flex items-center space-x-3 p-3 rounded-lg transition-colors duration-200" data-category="${categoryKey}" data-subcategory="${key}"><img src="${subCategory.icon}" alt="${subCategory.name}" class="h-8"><span class="text-sm font-medium">${subCategory.name}</span></button>`;
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
                subTotal += cartItem.qty * (item.assemblyCost + item.laborCost);
            }
            const assemblyChecked = cartItem.assembly ? 'checked' : '';
            const activeClass = cartItem.qty > 0 ? 'active' : '';
            
            return `
            <div class="product-card border rounded-lg p-4 transition-colors duration-200 ${activeClass}" data-id="${item.id}">
                <!-- Desktop Grid -->
                <div class="hidden lg:grid grid-cols-12 gap-4 items-center">
                    <div class="col-span-2 flex items-center space-x-4">
                        <img src="https://placehold.co/60x60/f0f0f0/333?text=${item.name.split(' ')[0]}" alt="${item.name}" class="w-16 h-16 rounded-md">
                        <div>
                            <p class="font-bold">${item.name}</p>
                            <div class="text-xs text-gray-500 mt-1">
                                <a href="#" class="hover:text-accent hover:underline">View Product</a>
                            </div>
                        </div>
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
                    <div class="col-span-2 text-right font-bold text-lg">$<span class="sub-total">${subTotal.toFixed(2)}</span></div>
                </div>
                <!-- Mobile View -->
                <div class="lg:hidden">
                    <div class="flex items-start justify-between">
                         <div class="flex items-center space-x-4">
                           <img src="https://placehold.co/60x60/f0f0f0/333?text=${item.name.split(' ')[0]}" alt="${item.name}" class="w-16 h-16 rounded-md">
                            <div>
                                <p class="font-bold">${item.name}</p>
                                <p class="text-sm text-gray-500">${item.stock}</p>
                                <div class="text-xs text-gray-500 mt-1">
                                    <a href="#" class="hover:text-accent hover:underline">View Product</a>
                                </div>
                            </div>
                        </div>
                         <div class="text-right">
                            <p class="font-bold text-lg">$<span class="sub-total">${subTotal.toFixed(2)}</span></p>
                            <p class="text-xs text-gray-500">Sub Total</p>
                        </div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-secondary space-y-4">
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
                            <span class="text-gray-600">Hinge</span>
                            <div class="hinge-container">${renderHingeSelector(item)}</div>
                        </div>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-gray-600">Modifications</span>
                            <span class="font-medium">${item.modifications ? `<button class="mod-button"><i data-lucide="edit-2" class="w-4 h-4 text-gray-500 hover:text-accent"></i></button>` : 'N/A'}</span>
                        </div>
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
        const items = productsData[categoryKey].subCategories[subCategoryKey].items;
        renderProductGrid(items);
        productGridContainer.classList.remove('hidden');
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
        const qty = card.querySelector('.qty-input').value; 
        const assembly = card.querySelector('.assembly-toggle-bg').classList.contains('checked');
        
        updateCart(id, parseInt(qty), assembly);
        updateCardUI(card);
        updateGrandTotal();
    }

    function updateCart(id, qty, assembly) {
        if (qty > 0) {
             cart[id] = { qty, assembly };
        } else {
             delete cart[id];
        }
        
        if (Object.keys(cart).length > 0) {
             stickyTotalsBar.classList.remove('translate-y-full');
        } else {
             stickyTotalsBar.classList.add('translate-y-full');
        }
    }
    
    function updateCardUI(card) {
        const id = card.dataset.id
        const product = findProductById(id);
        if (!product) return;

        const qty = parseInt(card.querySelector('.qty-input').value);
        const wantsAssembly = card.querySelector('.assembly-toggle-bg').classList.contains('checked');

        let subTotal = qty * product.unitPrice;
        if (wantsAssembly) {
            subTotal += qty * (product.assemblyCost + product.laborCost);
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
                    itemTotal += cartItem.qty * (product.assemblyCost + product.laborCost);
                }
                total += itemTotal;
            }
        }
        grandTotalEl.textContent = `$${total.toFixed(2)}`;
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
        // Pre-select first main filter
        const firstMainFilter = mainFiltersContainer.querySelector('.filter-button');
        if (firstMainFilter) {
            firstMainFilter.click();
        }
    }
    
    initializeShoppingSection();
    
    mainFiltersContainer.addEventListener('click', handleFilterClick);
    subFiltersContainer.addEventListener('click', handleSubFilterClick);
    productGrid.addEventListener('input', handleProductCardInteraction);
    productGrid.addEventListener('click', handleAssemblyToggle);

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