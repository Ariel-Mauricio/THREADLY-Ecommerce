<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Response;

class ExportController extends Controller
{
    /**
     * Export orders to CSV
     */
    public function orders(Request $request)
    {
        $query = Order::with(['user', 'items.product']);

        // Date filters
        if ($request->has('from')) {
            $query->where('created_at', '>=', Carbon::parse($request->from)->startOfDay());
        }
        if ($request->has('to')) {
            $query->where('created_at', '<=', Carbon::parse($request->to)->endOfDay());
        }

        // Status filter
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $orders = $query->orderBy('created_at', 'desc')->get();

        $filename = 'ordenes_' . date('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');
            
            // BOM for Excel UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Headers
            fputcsv($file, [
                'ID Orden',
                'Fecha',
                'Cliente',
                'Email',
                'Teléfono',
                'Subtotal',
                'Envío',
                'IVA',
                'Total',
                'Estado',
                'Método Pago',
                'ID Transacción',
                'Dirección',
                'Ciudad',
                'Provincia',
                'Productos',
            ]);

            foreach ($orders as $order) {
                $products = $order->items->map(function ($item) {
                    return $item->product_name . ' x' . $item->quantity;
                })->join('; ');

                fputcsv($file, [
                    $order->id,
                    $order->created_at->format('Y-m-d H:i:s'),
                    $order->user?->name ?? $order->customer_name ?? 'N/A',
                    $order->user?->email ?? $order->customer_email ?? 'N/A',
                    $order->customer_phone ?? 'N/A',
                    number_format($order->subtotal, 2),
                    number_format($order->shipping_cost ?? 0, 2),
                    number_format($order->tax ?? 0, 2),
                    number_format($order->total, 2),
                    $this->getStatusLabel($order->status),
                    $order->payment_method ?? 'N/A',
                    $order->transaction_id ?? 'N/A',
                    $order->shipping_address ?? 'N/A',
                    $order->shipping_city ?? 'N/A',
                    $order->shipping_province ?? 'N/A',
                    $products,
                ]);
            }

            fclose($file);
        };

        ActivityLog::log('export_orders', null, null, [
            'count' => $orders->count(),
            'filters' => $request->only(['from', 'to', 'status']),
        ]);

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Export products to CSV
     */
    public function products(Request $request)
    {
        $query = Product::with('category');

        if ($request->has('category') && $request->category !== 'all') {
            $query->where('category_id', $request->category);
        }

        if ($request->has('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            } elseif ($request->status === 'low_stock') {
                $query->where('stock', '<=', 5);
            }
        }

        $products = $query->orderBy('name')->get();

        $filename = 'productos_' . date('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($products) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($file, [
                'ID',
                'SKU',
                'Nombre',
                'Categoría',
                'Precio',
                'Descuento %',
                'Precio Final',
                'Stock',
                'Tallas',
                'Colores',
                'Estado',
                'Ventas Totales',
                'Creado',
            ]);

            foreach ($products as $product) {
                $salesCount = $product->orderItems()->sum('quantity');
                
                fputcsv($file, [
                    $product->id,
                    $product->sku ?? 'N/A',
                    $product->name,
                    $product->category?->name ?? 'Sin categoría',
                    number_format($product->price, 2),
                    $product->discount_percent ?? 0,
                    number_format($product->final_price, 2),
                    $product->stock,
                    $product->sizes ?? 'N/A',
                    $product->colors ?? 'N/A',
                    $product->is_active ? 'Activo' : 'Inactivo',
                    $salesCount,
                    $product->created_at->format('Y-m-d'),
                ]);
            }

            fclose($file);
        };

        ActivityLog::log('export_products', null, null, [
            'count' => $products->count(),
            'filters' => $request->only(['category', 'status']),
        ]);

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Export users to CSV
     */
    public function users(Request $request)
    {
        $query = User::withCount('orders')
            ->withSum(['orders' => function ($q) {
                $q->whereNotIn('status', ['cancelled', 'payment_failed']);
            }], 'total');

        if ($request->has('role')) {
            if ($request->role === 'admin') {
                $query->where('is_admin', true);
            } elseif ($request->role === 'customer') {
                $query->where('is_admin', false);
            }
        }

        $users = $query->orderBy('created_at', 'desc')->get();

        $filename = 'usuarios_' . date('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            fputcsv($file, [
                'ID',
                'Nombre',
                'Email',
                'Teléfono',
                'Rol',
                'Total Órdenes',
                'Total Gastado',
                'Último Login',
                'Registrado',
            ]);

            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->phone ?? 'N/A',
                    $user->is_admin ? 'Administrador' : 'Cliente',
                    $user->orders_count,
                    number_format($user->orders_sum_total ?? 0, 2),
                    $user->last_login_at?->format('Y-m-d H:i') ?? 'Nunca',
                    $user->created_at->format('Y-m-d'),
                ]);
            }

            fclose($file);
        };

        ActivityLog::log('export_users', null, null, [
            'count' => $users->count(),
        ]);

        return Response::stream($callback, 200, $headers);
    }

    /**
     * Export sales report to CSV
     */
    public function salesReport(Request $request)
    {
        $from = Carbon::parse($request->get('from', now()->startOfMonth()));
        $to = Carbon::parse($request->get('to', now()));

        $orders = Order::with(['items.product'])
            ->whereBetween('created_at', [$from->startOfDay(), $to->endOfDay()])
            ->whereNotIn('status', ['cancelled', 'payment_failed'])
            ->get();

        $filename = 'reporte_ventas_' . $from->format('Ymd') . '_' . $to->format('Ymd') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($orders, $from, $to) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Summary header
            fputcsv($file, ['REPORTE DE VENTAS']);
            fputcsv($file, ['Período:', $from->format('d/m/Y') . ' - ' . $to->format('d/m/Y')]);
            fputcsv($file, ['Generado:', now()->format('d/m/Y H:i:s')]);
            fputcsv($file, ['']);
            
            // Summary stats
            fputcsv($file, ['RESUMEN']);
            fputcsv($file, ['Total Órdenes:', $orders->count()]);
            fputcsv($file, ['Total Ventas:', '$' . number_format($orders->sum('total'), 2)]);
            fputcsv($file, ['Promedio por Orden:', '$' . number_format($orders->avg('total'), 2)]);
            fputcsv($file, ['Total Productos Vendidos:', $orders->flatMap->items->sum('quantity')]);
            fputcsv($file, ['']);
            
            // Detailed orders
            fputcsv($file, ['DETALLE DE ÓRDENES']);
            fputcsv($file, [
                'ID Orden',
                'Fecha',
                'Cliente',
                'Productos',
                'Cantidad Items',
                'Subtotal',
                'Envío',
                'IVA',
                'Total',
                'Estado',
            ]);

            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->id,
                    $order->created_at->format('d/m/Y H:i'),
                    $order->user?->name ?? $order->customer_name ?? 'N/A',
                    $order->items->count(),
                    $order->items->sum('quantity'),
                    '$' . number_format($order->subtotal, 2),
                    '$' . number_format($order->shipping_cost ?? 0, 2),
                    '$' . number_format($order->tax ?? 0, 2),
                    '$' . number_format($order->total, 2),
                    $this->getStatusLabel($order->status),
                ]);
            }

            fclose($file);
        };

        ActivityLog::log('export_sales_report', null, null, [
            'from' => $from->toDateString(),
            'to' => $to->toDateString(),
            'orders_count' => $orders->count(),
        ]);

        return Response::stream($callback, 200, $headers);
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
