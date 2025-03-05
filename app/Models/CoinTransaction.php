<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class CoinTransaction extends Model
{
    protected $fillable = [
        'wallet_id',
        'source_id',
        'type',
        'amount',
        'balance_after',
        'description',
        'reference_type',
        'reference_id'
    ];

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(CoinWallet::class, 'wallet_id');
    }

    public function source(): BelongsTo
    {
        return $this->belongsTo(CoinSource::class, 'source_id');
    }

    public function reference(): MorphTo
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->wallet->user();
    }
}
