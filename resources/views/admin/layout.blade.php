<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>@yield('title', 'BH Cabinetry Admin Panel')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Chart.js for Dashboard Charts -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Google Fonts: Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
        /* Custom scrollbar for a more modern look */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #d1d5db; /* gray-300 */
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #9ca3af; /* gray-400 */
        }
        .sidebar-link.active {
            background-color: #e5e7eb; /* gray-200 */
            color: #111827; /* gray-900 */
            font-weight: 600;
        }
        /* Custom styles for table actions */
        .action-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2rem;
            height: 2rem;
            border-radius: 9999px;
            transition: background-color 0.2s;
        }
        .action-button:hover {
            background-color: #f3f4f6; /* gray-100 */
        }
        .status-pill {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        .status-shipped { background-color: #d1fae5; color: #065f46; } /* green */
        .status-processing { background-color: #fee2e2; color: #991b1b; } /* red */
        .status-pending { background-color: #fef3c7; color: #92400e; } /* amber */
    </style>
    @yield('styles')
</head>
<body class="h-full">

<div class="flex h-full">
    <!-- ===== Sidebar ===== -->
    <aside class="w-64 flex-shrink-0 bg-white border-r border-gray-200 flex flex-col">
        <!-- Logo -->
        <div class="h-16 flex items-center justify-center border-b border-gray-200">
            <h1 class="text-2xl font-bold text-gray-800">BH CABINETRY</h1>
        </div>
        <!-- Navigation -->
        <nav class="flex-grow p-4 space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center px-4 py-2.5 text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-colors {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i data-lucide="layout-dashboard" class="w-5 h-5 mr-3"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.orders') }}" class="sidebar-link flex items-center px-4 py-2.5 text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-colors {{ request()->routeIs('admin.orders') ? 'active' : '' }}">
                <i data-lucide="shopping-cart" class="w-5 h-5 mr-3"></i>
                <span>Orders</span>
                <span class="ml-auto bg-red-500 text-white text-xs font-semibold px-2 py-0.5 rounded-full">3</span>
            </a>
            
            <!-- Product Management Section -->
            <div class="pt-4">
                <h3 class="px-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Product Management</h3>
                <div class="mt-2 space-y-1">
                    <a href="{{ route('admin.door-styles.index') }}" class="sidebar-link flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-colors {{ request()->routeIs('admin.door-styles.*') ? 'active' : '' }}">
                        <i data-lucide="square" class="w-4 h-4 mr-3"></i>
                        <span>Door Styles</span>
                    </a>
                    <a href="{{ route('admin.door-colors.index') }}" class="sidebar-link flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-colors {{ request()->routeIs('admin.door-colors.*') ? 'active' : '' }}">
                        <i data-lucide="palette" class="w-4 h-4 mr-3"></i>
                        <span>Door Colors</span>
                    </a>
                    <a href="{{ route('admin.product-lines.index') }}" class="sidebar-link flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-colors {{ request()->routeIs('admin.product-lines.*') ? 'active' : '' }}">
                        <i data-lucide="layers" class="w-4 h-4 mr-3"></i>
                        <span>Product Lines</span>
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="sidebar-link flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-colors {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <i data-lucide="folder-tree" class="w-4 h-4 mr-3"></i>
                        <span>Categories</span>
                    </a>
                    <a href="{{ route('admin.sub-categories.index') }}" class="sidebar-link flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-colors {{ request()->routeIs('admin.sub-categories.*') ? 'active' : '' }}">
                        <i data-lucide="folder" class="w-4 h-4 mr-3"></i>
                        <span>Sub Categories</span>
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="sidebar-link flex items-center px-4 py-2 text-sm text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-colors {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <i data-lucide="package" class="w-4 h-4 mr-3"></i>
                        <span>Products</span>
                    </a>
                </div>
            </div>
            
            <a href="{{ route('admin.users.index') }}" class="sidebar-link flex items-center px-4 py-2.5 text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-colors {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i data-lucide="users" class="w-5 h-5 mr-3"></i>
                <span>User Management</span>
            </a>
            <a href="{{ route('admin.blog') }}" class="sidebar-link flex items-center px-4 py-2.5 text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-colors {{ request()->routeIs('admin.blog') ? 'active' : '' }}">
                <i data-lucide="file-text" class="w-5 h-5 mr-3"></i>
                <span>Blog</span>
            </a>
        </nav>
        <!-- Footer -->
        <div class="p-4 border-t border-gray-200">
            <a href="{{ route('admin.settings') }}" class="sidebar-link flex items-center px-4 py-2.5 text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-colors {{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                <i data-lucide="settings" class="w-5 h-5 mr-3"></i>
                <span>Settings</span>
            </a>
            <a href="/" class="flex items-center mt-2 px-4 py-2.5 text-gray-600 rounded-lg hover:bg-gray-100 hover:text-gray-900 transition-colors">
                <i data-lucide="log-out" class="w-5 h-5 mr-3"></i>
                <span>Back to Store</span>
            </a>
        </div>
    </aside>

    <!-- ===== Main Content ===== -->
    <main class="flex-grow bg-gray-100 overflow-y-auto">
        @yield('content')
    </main>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Lucide Icons
        lucide.createIcons();
    });
</script>
@yield('scripts')
</body>
</html> 