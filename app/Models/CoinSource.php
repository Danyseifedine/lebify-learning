<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CoinSource extends Model
{
    protected $fillable = [
        'name',
        'code',
        'type',
        'description',
        'default_amount',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(CoinTransaction::class, 'source_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeEarning($query)
    {
        return $query->where('type', 'earn');
    }

    public function scopeSpending($query)
    {
        return $query->where('type', 'spend');
    }
}
