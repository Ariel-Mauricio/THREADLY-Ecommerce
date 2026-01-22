<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'recipient_name',
        'phone',
        'address',
        'address_reference',
        'city',
        'province',
        'postal_code',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Set this address as default and unset others
     */
    public function setAsDefault(): void
    {
        // Unset other defaults for this user
        static::where('user_id', $this->user_id)
            ->where('id', '!=', $this->id)
            ->update(['is_default' => false]);
        
        $this->update(['is_default' => true]);
    }

    /**
     * Get formatted address string
     */
    public function getFullAddressAttribute(): string
    {
        $parts = [$this->address];
        
        if ($this->address_reference) {
            $parts[] = "Ref: {$this->address_reference}";
        }
        
        $parts[] = "{$this->city}, {$this->province}";
        
        if ($this->postal_code) {
            $parts[] = "CP: {$this->postal_code}";
        }
        
        return implode(' - ', $parts);
    }
}
