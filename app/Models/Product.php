<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'description', 'price', 'original_price',
        'discount_percent', 'promotion_starts', 'promotion_ends', 'promotion_label',
        'image', 'gallery', 'sizes', 'colors', 'stock', 'sku',
        'is_featured', 'is_active', 'is_new'
    ];

    protected $casts = [
        'gallery' => 'array',
        'sizes' => 'array',
        'colors' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'is_new' => 'boolean',
        'price' => 'decimal:2',
        'original_price' => 'decimal:2',
        'promotion_starts' => 'datetime',
        'promotion_ends' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($product) {
            if (!$product->slug) {
                $product->slug = Str::slug($product->name);
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(Review::class)->where('is_approved', true);
    }

    public function wishlistedBy()
    {
        return $this->belongsToMany(User::class, 'wishlists')->withTimestamps();
    }

    /**
     * Get average rating
     */
    public function getAverageRatingAttribute(): float
    {
        return round($this->approvedReviews()->avg('rating') ?? 0, 1);
    }

    /**
     * Get total reviews count
     */
    public function getReviewsCountAttribute(): int
    {
        return $this->approvedReviews()->count();
    }

    /**
     * Get rating distribution
     */
    public function getRatingDistributionAttribute(): array
    {
        $distribution = [];
        for ($i = 5; $i >= 1; $i--) {
            $distribution[$i] = $this->approvedReviews()->where('rating', $i)->count();
        }
        return $distribution;
    }

    public function getFinalPriceAttribute()
    {
        // Si hay promoción activa, calcular precio con descuento
        if ($this->isOnPromotion()) {
            return round($this->original_price * (1 - ($this->discount_percent / 100)), 2);
        }
        return $this->price;
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->discount_percent) {
            return $this->discount_percent;
        }
        if ($this->original_price && $this->original_price > $this->price) {
            return round((($this->original_price - $this->price) / $this->original_price) * 100);
        }
        return 0;
    }

    public function isOnPromotion()
    {
        if (!$this->discount_percent || !$this->promotion_starts || !$this->promotion_ends) {
            return false;
        }
        $now = Carbon::now();
        return $now->between($this->promotion_starts, $this->promotion_ends);
    }

    public function getPromotionStatusAttribute()
    {
        if (!$this->discount_percent) {
            return 'none';
        }
        if (!$this->promotion_starts || !$this->promotion_ends) {
            return 'permanent';
        }
        $now = Carbon::now();
        if ($now->lt($this->promotion_starts)) {
            return 'scheduled';
        }
        if ($now->gt($this->promotion_ends)) {
            return 'expired';
        }
        return 'active';
    }
}
