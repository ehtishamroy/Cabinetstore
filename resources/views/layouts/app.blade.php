<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BH Cabinetry - Modern Kitchens, Simply Delivered')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Swiper.js for Testimonial Slider -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Google Fonts: Inter & Instrument Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* Applying custom design tokens from the brief */
        body {
            background-color: #F8F7F4;
            font-family: 'Inter', sans-serif;
            color: #333333;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Instrument Sans', sans-serif;
            font-weight: 500; /* Lighter font weight for headings */
        }
        .bg-primary-background { background-color: #F8F7F4; }
        .bg-dark-section { background-color: #2D2D2D; }
        .text-primary { color: #333333; }
        .bg-primary-cta { background-color: #E86A33; }
        .hover\:bg-cta-hover:hover { background-color: #F18E6A; }
        .border-secondary { border-color: #EAEAEA; }
        .text-accent { color: #E86A33; }

        /* Smooth scroll behavior */
        html {
            scroll-behavior: smooth;
        }
        
        /* Header transition */
        #main-header {
            transition: background-color 0.3s ease-in-out, box-shadow 0.3s ease-in-out, top 0.3s ease-in-out;
        }

        /* Swiper custom styles */
        .swiper-button-next, .swiper-button-prev {
            color: #333333; /* Darker color for arrows */
            background-color: white;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 9999px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            transition: opacity 0.3s, transform 0.3s;
            opacity: 0;
        }
        .swiper-button-next:after, .swiper-button-prev:after {
            font-size: 1rem;
            font-weight: 700;
        }
        .swiper:hover .swiper-button-next, .swiper:hover .swiper-button-prev {
            opacity: 1;
        }
        .swiper-button-next:hover, .swiper-button-prev:hover {
            transform: scale(1.1);
        }
        .swiper-pagination-bullet-active {
            background-color: #333333 !important;
        }
        
        /* CTA Button styles */
        .cta-button-container {
            position: relative;
            display: inline-block;
        }
        .cta-button-base {
            display: block;
            width: 100%;
            height: 100%;
            background: white;
            border-radius: 9999px;
            box-shadow: 0 10px 20px -5px rgba(0,0,0,0.2);
            transition: transform 0.2s ease-out;
        }
        .cta-button-link {
            position: absolute;
            top: -5px;
            left: 0;
            width: 100%;
            height: 100%;
            transition: transform 0.2s ease-out;
        }
        .cta-button-container:active .cta-button-base {
            transform: translateY(2px);
            box-shadow: 0 4px 10px -3px rgba(0,0,0,0.2);
        }
        .cta-button-container:active .cta-button-link {
            transform: translateY(3px);
        }
        
        /* "Designed for Your Life" section styles */
        .feature-image-card {
            position: relative;
            overflow: hidden;
            height: 500px; /* Fixed height for portrait look */
        }
        .feature-image-card .content {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 2rem;
            background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0) 100%);
            color: white;
        }
        .feature-image-card img {
            transition: transform 0.4s ease-out;
        }
        .feature-image-card:hover img {
            transform: scale(1.05);
        }
        
        /* New minimal button style */
        .btn-minimal {
            background-color: #2D2D2D;
            color: white;
        }
        .btn-minimal:hover {
            background-color: #000000;
        }

    </style>
    @yield('styles')
</head>
<body class="bg-primary-background">

    <!-- ===== Announcement Bar ===== -->
    <div id="announcement-bar" class="bg-dark-section text-white text-sm font-medium text-center py-2.5 w-full relative z-[60]">
        <span id="announcement-text" class="transition-opacity duration-500 ease-in-out opacity-0"></span>
    </div>

    <!-- ===== Header ===== -->
    <header id="main-header" class="fixed left-0 right-0 z-50 py-4 px-6 md:px-10">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <!-- Logo -->
            <a href="/" class="text-2xl font-bold" id="logo">BH CABINETRY</a>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center space-x-8">
                <a href="/shop" class="hover:text-accent transition-colors duration-300">Shop</a>
                <a href="/product" class="hover:text-accent transition-colors duration-300">Products</a>
                <a href="/about" class="hover:text-accent transition-colors duration-300">About Us</a>
                <a href="/blog" class="hover:text-accent transition-colors duration-300">Blog</a>
                <a href="/contact" class="hover:text-accent transition-colors duration-300">Contact</a>
            </nav>

            <!-- Icons -->
            <div class="hidden md:flex items-center space-x-6">
                @auth
                    <div class="relative group">
                        <button class="hover:text-accent transition-colors duration-300 flex items-center">
                            <i data-lucide="user"></i>
                            <span class="ml-1 text-sm">{{ Auth::user()->name }}</span>
                        </button>
                        <!-- Extended hover area -->
                        <div class="absolute -top-2 -left-2 -right-2 -bottom-2 bg-transparent"></div>
                        <div class="absolute right-0 top-full pt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 ease-in-out">
                            @if(Auth::user()->isAdmin())
                                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-150">Admin Dashboard</a>
                            @endif
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-150">My Account</a>
                            <form action="{{ route('logout') }}" method="POST" class="block">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors duration-150">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="hover:text-accent transition-colors duration-300"><i data-lucide="user"></i></a>
                @endauth
                <button id="cart-button" class="hover:text-accent transition-colors duration-300 relative group">
                    <i data-lucide="shopping-cart"></i>
                    <span id="cart-count" class="absolute -top-2 -right-2 bg-accent text-white text-xs w-5 h-5 rounded-full flex items-center justify-center">0</span>
                    
                    <!-- Cart Dropdown -->
                    <div id="cart-dropdown" class="absolute right-0 top-full pt-2 w-80 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 ease-in-out">
                        <div id="cart-items" class="max-h-64 overflow-y-auto">
                            <!-- Cart items will be populated here -->
                        </div>
                        <div id="cart-footer" class="border-t border-gray-200 p-3">
                            <div class="flex justify-between items-center mb-3">
                                <span class="font-semibold">Total:</span>
                                <span id="cart-total" class="font-bold">$0.00</span>
                            </div>
                            <button id="view-cart-btn" class="w-full bg-gray-900 text-white py-2 px-4 rounded-md hover:bg-black transition-colors duration-200 text-sm font-semibold">
                                View Cart
                            </button>
                        </div>
                    </div>
                </button>
            </div>

            <!-- Mobile Menu Button -->
            <button id="mobile-menu-button" class="md:hidden">
                <i data-lucide="menu"></i>
            </button>
        </div>
    </header>
    
    <!-- Mobile Menu -->
    <div id="mobile-menu" class="hidden fixed top-0 right-0 h-full w-3/4 bg-primary-background shadow-lg z-50 p-8 transform translate-x-full transition-transform duration-300 ease-in-out">
        <button id="close-menu-button" class="absolute top-6 right-6">
            <i data-lucide="x"></i>
        </button>
        <nav class="flex flex-col space-y-6 text-lg mt-12">
            <a href="/shop" class="hover:text-accent transition-colors duration-300">Shop</a>
            <a href="/product" class="hover:text-accent transition-colors duration-300">Products</a>
            <a href="/about" class="hover:text-accent transition-colors duration-300">About Us</a>
            <a href="/blog" class="hover:text-accent transition-colors duration-300">Blog</a>
            <a href="/contact" class="hover:text-accent transition-colors duration-300">Contact</a>
            <hr class="border-secondary"/>
            <a href="/cart" class="hover:text-accent transition-colors duration-300 flex items-center"><i data-lucide="shopping-cart" class="mr-2"></i> Cart</a>
            @auth
                <div class="space-y-2">
                    <div class="text-sm text-gray-600">{{ Auth::user()->name }}</div>
                    @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-accent transition-colors duration-300 flex items-center"><i data-lucide="shield" class="mr-2"></i> Admin Dashboard</a>
                    @endif
                    <a href="#" class="hover:text-accent transition-colors duration-300 flex items-center"><i data-lucide="user" class="mr-2"></i> My Account</a>
                    <form action="{{ route('logout') }}" method="POST" class="block">
                        @csrf
                        <button type="submit" class="w-full text-left hover:text-accent transition-colors duration-300 flex items-center"><i data-lucide="log-out" class="mr-2"></i> Logout</button>
                    </form>
                </div>
            @else
                <a href="{{ route('login') }}" class="hover:text-accent transition-colors duration-300 flex items-center"><i data-lucide="user" class="mr-2"></i> Account</a>
            @endauth
        </nav>
    </div>

    <!-- ===== Main Content ===== -->
    @yield('content')

    <!-- ===== Footer ===== -->
    <footer class="bg-dark-section text-gray-300 pt-16 pb-8">
        <div class="px-6 md:px-10">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Column 1: Brand -->
                <div class="md:col-span-1">
                    <h3 class="text-2xl font-bold text-white mb-4">BH CABINETRY</h3>
                    <p class="text-sm">Our mission is to make beautiful, high-quality kitchen design accessible to everyone.</p>
                </div>
                <!-- Column 2: Shop -->
                <div>
                    <h4 class="font-semibold text-white mb-4">Shop</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition-colors">All Cabinet Styles</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Shaker Cabinets</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Modern Cabinets</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Bathroom Vanities</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Order Samples</a></li>
                    </ul>
                </div>
                <!-- Column 3: Support -->
                <div>
                    <h4 class="font-semibold text-white mb-4">Support</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition-colors">Contact Us</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">FAQ</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Assembly Guides</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">Shipping & Returns</a></li>
                        <li><a href="#" class="hover:text-white transition-colors">My Account</a></li>
                    </ul>
                </div>
                <!-- Column 4: Newsletter -->
                <div>
                    <h4 class="font-semibold text-white mb-4">Join Our Newsletter</h4>
                    <p class="text-sm mb-4">Get design inspiration and exclusive offers straight to your inbox.</p>
                    <form class="flex">
                        <input type="email" placeholder="Your email" class="w-full p-2 text-gray-800 focus:outline-none">
                        <button type="submit" class="btn-minimal text-white font-bold py-2 px-4 transition-colors">
                            <i data-lucide="arrow-right"></i>
                        </button>
                    </form>
                </div>
            </div>
            <hr class="border-gray-700 my-8">
            <div class="text-center text-sm text-gray-500">
                &copy; 2025 BH Cabinetry. All Rights Reserved.
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize Lucide Icons
            lucide.createIcons();

            // --- Announcement Bar & Header Logic ---
            const announcements = [
                "Free Delivery On All Orders Over $1500",
                "Use Coupon 'SUMMER25' for 25% Off",
                "New Modern Grey Styles Arriving Weekly!"
            ];
            let announcementIndex = 0;
            const announcementTextEl = document.getElementById('announcement-text');
            const announcementBar = document.getElementById('announcement-bar');
            const mainHeader = document.getElementById('main-header');
            const logo = document.getElementById('logo');
            const mobileMenuBtn = document.getElementById('mobile-menu-button');

            function cycleAnnouncements() {
                if (!announcementTextEl) return;
                announcementTextEl.style.opacity = '0';
                
                setTimeout(() => {
                    announcementIndex = (announcementIndex + 1) % announcements.length;
                    announcementTextEl.textContent = announcements[announcementIndex];
                    announcementTextEl.style.opacity = '1';
                }, 500);
            }
            
            const updateHeaderStyle = () => {
                const barHeight = announcementBar ? announcementBar.offsetHeight : 0;
                const isHomePage = window.location.pathname === '/';
                
                if (window.scrollY > 50) {
                    mainHeader.style.top = '0px'; // Stick to the very top
                    mainHeader.classList.add('bg-primary-background', 'shadow-md', 'text-primary');
                    mainHeader.classList.remove('text-white');
                    logo.classList.add('text-primary');
                    logo.classList.remove('text-white');
                    mobileMenuBtn.classList.add('text-primary');
                    mobileMenuBtn.classList.remove('text-white');
                } else {
                    mainHeader.style.top = `${barHeight}px`; // Sit below announcement bar
                    
                    if (isHomePage) {
                        // Homepage: White text on transparent background
                        mainHeader.classList.remove('bg-primary-background', 'shadow-md', 'text-primary');
                        mainHeader.classList.add('text-white');
                        logo.classList.remove('text-primary');
                        logo.classList.add('text-white');
                        mobileMenuBtn.classList.remove('text-primary');
                        mobileMenuBtn.classList.add('text-white');
                    } else {
                        // Other pages: Black text on white background
                        mainHeader.classList.add('bg-white', 'shadow-md', 'text-primary');
                        mainHeader.classList.remove('text-white');
                        logo.classList.add('text-primary');
                        logo.classList.remove('text-white');
                        mobileMenuBtn.classList.add('text-primary');
                        mobileMenuBtn.classList.remove('text-white');
                    }
                }
            };

            // Initial setup for announcement bar
            if (announcementTextEl) {
                announcementTextEl.textContent = announcements[0];
                announcementTextEl.style.opacity = '1';
                setInterval(cycleAnnouncements, 5000);
            }

            // Initial check and event listeners
            updateHeaderStyle();
            window.addEventListener('scroll', updateHeaderStyle);
            window.addEventListener('resize', updateHeaderStyle);

            // --- Mobile Menu Logic ---
            const mobileMenu = document.getElementById('mobile-menu');
            const closeMenuBtn = document.getElementById('close-menu-button');

            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.remove('hidden');
                setTimeout(() => {
                    mobileMenu.classList.remove('translate-x-full');
                }, 10);
            });

            const closeMenu = () => {
                mobileMenu.classList.add('translate-x-full');
                setTimeout(() => {
                    mobileMenu.classList.add('hidden');
                }, 300);
            };

            closeMenuBtn.addEventListener('click', closeMenu);
            
            mobileMenu.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', closeMenu);
            });

            // --- Cart System ---
            const cartCount = document.getElementById('cart-count');
            const cartItems = document.getElementById('cart-items');
            const cartTotal = document.getElementById('cart-total');
            const viewCartBtn = document.getElementById('view-cart-btn');
            const cartFooter = document.getElementById('cart-footer');

            // Cart data structure
            let cart = JSON.parse(localStorage.getItem('cart')) || {};

            // Update cart display
            function updateCartDisplay() {
                const itemCount = Object.keys(cart).length;
                cartCount.textContent = itemCount;
                
                if (itemCount === 0) {
                    cartCount.style.display = 'none';
                    cartItems.innerHTML = '<div class="p-4 text-center text-gray-500">Your cart is empty</div>';
                    cartFooter.style.display = 'none';
                    viewCartBtn.style.display = 'none';
                } else {
                    cartCount.style.display = 'flex';
                    cartFooter.style.display = 'block';
                    viewCartBtn.style.display = 'block';
                    
                    let total = 0;
                    let itemsHtml = '';
                    
                    Object.keys(cart).forEach(productId => {
                        const item = cart[productId];
                        const itemTotal = item.qty * item.unitPrice + (item.assembly ? item.qty * item.laborCost : 0);
                        total += itemTotal;
                        
                        itemsHtml += `
                            <div class="flex items-center justify-between p-3 border-b border-gray-100">
                                <div class="flex-1">
                                    <div class="font-medium text-sm">${item.name}</div>
                                    <div class="text-xs text-gray-500">Qty: ${item.qty} | ${item.assembly ? 'Assembly: Yes' : 'Assembly: No'}</div>
                                </div>
                                <div class="text-right">
                                    <div class="font-medium text-sm">$${itemTotal.toFixed(2)}</div>
                                    <button onclick="removeFromCart('${productId}')" class="text-xs text-red-500 hover:text-red-700">Remove</button>
                                </div>
                            </div>
                        `;
                    });
                    
                    cartItems.innerHTML = itemsHtml;
                    cartTotal.textContent = `$${total.toFixed(2)}`;
                }
                
                // Save to localStorage
                localStorage.setItem('cart', JSON.stringify(cart));
            }

            // Add to cart function (will be called from product pages)
            window.addToCart = function(productId, productData) {
                cart[productId] = productData;
                updateCartDisplay();
            };

            // Remove from cart function
            window.removeFromCart = function(productId) {
                delete cart[productId];
                updateCartDisplay();
            };

            // Initialize cart display
            updateCartDisplay();

            // Clear cart function for testing (you can remove this later)
            window.clearCart = function() {
                cart = {};
                localStorage.removeItem('cart');
                updateCartDisplay();
            };

            // View cart button
            viewCartBtn.addEventListener('click', () => {
                // Redirect to cart page
                window.location.href = '/cart';
            });
        });
    </script>
    @yield('scripts')
</body>
</html> 