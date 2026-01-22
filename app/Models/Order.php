<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = [
        'order_number', 
        'user_id', 
        'customer_name',
        'customer_email',
        'customer_phone',
        'shipping_address',
        'address_reference',
        'city',
        'province',
        'subtotal',
        'shipping_cost',
        'tax',
        'total', 
        'status', 
        'payment_method', 
        'payment_id',
        'payment_voucher',
        'notes',
        'ip_address',
        'user_agent',
        'shipped_at', 
        'delivered_at',
        'paid_at'
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'paid_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($order) {
            if (!$order->order_number) {
                $order->order_number = 'ORD-' . strtoupper(Str::random(8)) . '-' . time();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Pendiente',
            'pending_verification' => 'Verificando Pago',
            'processing' => 'Procesando',
            'paid' => 'Pagado',
            'shipped' => 'Enviado',
            'delivered' => 'Entregado',
            'cancelled' => 'Cancelado',
            'payment_failed' => 'Pago Fallido',
            'refunded' => 'Reembolsado',
            default => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'warning',
            'pending_verification' => 'info',
            'processing' => 'info',
            'paid' => 'success',
            'shipped' => 'primary',
            'delivered' => 'success',
            'cancelled' => 'danger',
            'payment_failed' => 'danger',
            'refunded' => 'secondary',
            default => 'secondary',
        };
    }

    public function getPaymentMethodLabelAttribute()
    {
        return match($this->payment_method) {
            'card' => 'Tarjeta de Crédito/Débito',
            'payphone' => 'PayPhone',
            'transfer' => 'Transferencia Bancaria',
            'cash' => 'Pago Contra Entrega',
            default => ucfirst($this->payment_method ?? 'No especificado'),
        };
    }

    public function isPending()
    {
        return in_array($this->status, ['pending', 'pending_verification']);
    }

    public function isPaid()
    {
        return in_array($this->status, ['paid', 'shipped', 'delivered']);
    }

    public function canBeCancelled()
    {
        return in_array($this->status, ['pending', 'pending_verification', 'processing']);
    }

    public function getVoucherUrlAttribute()
    {
        if ($this->payment_voucher) {
            return asset('storage/' . $this->payment_voucher);
        }
        return null;
    }
}
