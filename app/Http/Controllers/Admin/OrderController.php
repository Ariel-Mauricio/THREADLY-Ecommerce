<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items']);

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('id', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function($q2) use ($request) {
                      $q2->where('name', 'like', '%' . $request->search . '%')
                         ->orWhere('email', 'like', '%' . $request->search . '%');
                  });
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        // Validar los datos
        $request->validate([
            'status' => 'nullable|in:pending,pending_verification,processing,paid,shipped,delivered,cancelled,refunded,payment_failed',
            'notes' => 'nullable|string|max:1000',
        ], [
            'status.in' => 'El estado seleccionado no es válido',
            'notes.max' => 'Las notas no pueden exceder 1000 caracteres',
        ]);

        $data = [];
        
        if ($request->has('status')) {
            $data['status'] = $request->status;
            
            // Set timestamps based on status
            if ($request->status === 'shipped' && !$order->shipped_at) {
                $data['shipped_at'] = now();
            }
            if ($request->status === 'delivered' && !$order->delivered_at) {
                $data['delivered_at'] = now();
            }
        }
        
        if ($request->has('notes')) {
            $data['notes'] = $request->notes;
        }

        $order->update($data);

        return back()->with('success', 'Pedido actualizado correctamente');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,pending_verification,processing,paid,shipped,delivered,cancelled,refunded',
        ], [
            'status.required' => 'El estado es obligatorio',
            'status.in' => 'Estado no válido',
        ]);

        $data = ['status' => $request->status];
        
        if ($request->status === 'shipped' && !$order->shipped_at) {
            $data['shipped_at'] = now();
        }
        if ($request->status === 'delivered' && !$order->delivered_at) {
            $data['delivered_at'] = now();
        }
        if ($request->status === 'paid' && !$order->paid_at) {
            $data['paid_at'] = now();
        }

        $order->update($data);

        return response()->json(['success' => true]);
    }
}
