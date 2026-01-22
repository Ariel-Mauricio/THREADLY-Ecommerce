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

class DashboardController extends Controller
{
    public function index()
    {
        $totalSales = Order::whereNotIn('status', ['cancelled', 'payment_failed'])->sum('total');
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $totalUsers = User::where('is_admin', false)->count();
        
        // Monthly sales comparison
        $currentMonthSales = Order::whereNotIn('status', ['cancelled', 'payment_failed'])
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total');
            
        $lastMonthSales = Order::whereNotIn('status', ['cancelled', 'payment_failed'])
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->sum('total');
        
        $salesGrowth = $lastMonthSales > 0 
            ? round((($currentMonthSales - $lastMonthSales) / $lastMonthSales) * 100, 1)
            : 100;
        
        // Orders this week
        $weeklyOrders = Order::where('created_at', '>=', Carbon::now()->startOfWeek())->count();
        
        $recentOrders = Order::with(['user', 'items'])
            ->latest()
            ->take(5)
            ->get();
        
        $topProducts = Product::withCount('orderItems')
            ->orderByDesc('order_items_count')
            ->take(5)
            ->get();

        // Promociones activas
        $now = Carbon::now();
        $activePromotions = Product::whereNotNull('discount_percent')
            ->where('discount_percent', '>', 0)
            ->where(function($query) use ($now) {
                $query->whereNull('promotion_starts')
                    ->orWhere('promotion_starts', '<=', $now);
            })
            ->where(function($query) use ($now) {
                $query->whereNull('promotion_ends')
                    ->orWhere('promotion_ends', '>=', $now);
            })
            ->take(8)
            ->get();

        // Low stock products
        $lowStockProducts = Product::where('stock', '<=', 5)
            ->where('is_active', true)
            ->orderBy('stock')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalSales', 'totalOrders', 'totalProducts', 'totalUsers',
            'currentMonthSales', 'lastMonthSales', 'salesGrowth', 'weeklyOrders',
            'recentOrders', 'topProducts', 'activePromotions', 'lowStockProducts'
        ));
    }

    /**
     * Get chart data for sales (AJAX)
     */
    public function salesChartData(Request $request)
    {
        $period = $request->get('period', '7days');
        
        switch ($period) {
            case '30days':
                $startDate = Carbon::now()->subDays(30);
                $groupFormat = '%Y-%m-%d';
                $labelFormat = 'd M';
                break;
            case '12months':
                $startDate = Carbon::now()->subMonths(12);
                $groupFormat = '%Y-%m';
                $labelFormat = 'M Y';
                break;
            case '7days':
            default:
                $startDate = Carbon::now()->subDays(7);
                $groupFormat = '%Y-%m-%d';
                $labelFormat = 'D';
                break;
        }
        
        $sales = Order::select(
                DB::raw("DATE_FORMAT(created_at, '{$groupFormat}') as date"),
                DB::raw('SUM(total) as total'),
                DB::raw('COUNT(*) as orders')
            )
            ->where('created_at', '>=', $startDate)
            ->whereNotIn('status', ['cancelled', 'payment_failed'])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = [];
        $totals = [];
        $orderCounts = [];
        
        foreach ($sales as $sale) {
            $date = Carbon::parse($sale->date);
            $labels[] = $date->format($labelFormat);
            $totals[] = round($sale->total, 2);
            $orderCounts[] = $sale->orders;
        }

        return response()->json([
            'labels' => $labels,
            'sales' => $totals,
            'orders' => $orderCounts,
        ]);
    }

    /**
     * Get chart data for orders by status
     */
    public function ordersStatusChartData()
    {
        $statuses = Order::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        $labels = [];
        $data = [];
        $colors = [];

        $statusColors = [
            'pending' => '#f59e0b',
            'pending_verification' => '#3b82f6',
            'processing' => '#8b5cf6',
            'paid' => '#10b981',
            'shipped' => '#06b6d4',
            'delivered' => '#22c55e',
            'cancelled' => '#ef4444',
            'payment_failed' => '#dc2626',
            'refunded' => '#6b7280',
        ];

        foreach ($statuses as $status) {
            $labels[] = $this->getStatusLabel($status->status);
            $data[] = $status->count;
            $colors[] = $statusColors[$status->status] ?? '#6b7280';
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data,
            'colors' => $colors,
        ]);
    }

    /**
     * Get top categories chart data
     */
    public function categoriesChartData()
    {
        $categories = Category::withCount(['products' => function ($query) {
            $query->whereHas('orderItems');
        }])
        ->having('products_count', '>', 0)
        ->orderByDesc('products_count')
        ->take(6)
        ->get();

        return response()->json([
            'labels' => $categories->pluck('name'),
            'data' => $categories->pluck('products_count'),
        ]);
    }

    private function getStatusLabel($status): string
    {
        return match($status) {
            'pending' => 'Pendiente',
            'pending_verification' => 'Verificando',
            'processing' => 'Procesando',
            'paid' => 'Pagado',
            'shipped' => 'Enviado',
            'delivered' => 'Entregado',
            'cancelled' => 'Cancelado',
            'payment_failed' => 'Pago Fallido',
            'refunded' => 'Reembolsado',
            default => ucfirst($status),
        };
    }
}
