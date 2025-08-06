<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get total revenue (sum of all paid orders)
        $totalRevenue = Order::where('payment_status', 'paid')
            ->sum('total_amount');

        // Get total orders count
        $totalOrders = Order::count();

        // Get new orders (orders from last 30 days)
        $newOrders = Order::where('created_at', '>=', now()->subDays(30))
            ->count();

        // Get conversion rate (orders with status 'completed' vs total orders)
        $completedOrders = Order::where('status', 'completed')->count();
        $conversionRate = $totalOrders > 0 ? round(($completedOrders / $totalOrders) * 100, 2) : 0;

        // Get recent orders (last 5 orders)
        $recentOrders = Order::with('orderItems')
            ->latest()
            ->take(5)
            ->get();

        // Get total products
        $totalProducts = Product::count();

        // Get total blog posts
        $totalBlogPosts = Blog::count();

        // Get monthly revenue for chart (last 6 months)
        $monthlyRevenue = Order::where('payment_status', 'paid')
            ->where('created_at', '>=', now()->subMonths(6))
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, SUM(total_amount) as revenue')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalOrders',
            'newOrders',
            'conversionRate',
            'recentOrders',
            'totalProducts',
            'totalBlogPosts',
            'monthlyRevenue'
        ));
    }
} 