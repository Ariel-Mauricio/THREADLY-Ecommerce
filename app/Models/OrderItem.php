<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 
        'product_id', 
        'product_name', 
        'product_sku',
        'size', 
        'color', 
        'quantity', 
        'price', 
        'total'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'total' => 'decimal:2',
        'quantity' => 'integer',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the subtotal for display (same as total)
     */
    public function getSubtotalAttribute()
    {
        return $this->total ?? ($this->price * $this->quantity);
    }
}
