<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        // Sales summary
        $todaySales = Order::whereDate('created_at', today())
            ->whereNotIn('status', ['cancelled', 'payment_failed'])
            ->sum('total');
            
        $weekSales = Order::where('created_at', '>=', now()->startOfWeek())
            ->whereNotIn('status', ['cancelled', 'payment_failed'])
            ->sum('total');
            
        $monthSales = Order::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->whereNotIn('status', ['cancelled', 'payment_failed'])
            ->sum('total');
            
        $yearSales = Order::whereYear('created_at', now()->year)
            ->whereNotIn('status', ['cancelled', 'payment_failed'])
            ->sum('total');

        // Orders summary
        $todayOrders = Order::whereDate('created_at', today())->count();
        $weekOrders = Order::where('created_at', '>=', now()->startOfWeek())->count();
        $monthOrders = Order::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        
        // Top products
        $topProducts = Product::withCount('orderItems')
            ->orderByDesc('order_items_count')
            ->take(10)
            ->get();

        // Top categories
        $topCategories = Category::withCount(['products' => function($query) {
                $query->whereHas('orderItems');
            }])
            ->orderByDesc('products_count')
            ->take(5)
            ->get();

        // Customer stats
        $newCustomers = User::where('is_admin', false)
            ->whereMonth('created_at', now()->month)
            ->count();
            
        $totalCustomers = User::where('is_admin', false)->count();

        // Monthly sales chart data
        $monthlySales = Order::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('SUM(total) as total'),
                DB::raw('COUNT(*) as orders')
            )
            ->where('created_at', '>=', now()->subMonths(12))
            ->whereNotIn('status', ['cancelled', 'payment_failed'])
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.reports.index', compact(
            'todaySales', 'weekSales', 'monthSales', 'yearSales',
            'todayOrders', 'weekOrders', 'monthOrders',
            'topProducts', 'topCategories',
            'newCustomers', 'totalCustomers', 'monthlySales'
        ));
    }
}
