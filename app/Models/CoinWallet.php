<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class CoinWallet extends Model
{
    protected $fillable = [
        'user_id',
        'coins',
        'lifetime_earned',
        'lifetime_spent',
        'last_earned_at'
    ];

    protected $casts = [
        'last_earned_at' => 'datetime'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(CoinTransaction::class, 'wallet_id');
    }

    public function awardCoins(CoinSource $source, string $description = null, $reference = null): CoinTransaction
    {
        if (!$source->is_active || $source->type !== 'earn') {
            throw new \Exception('Invalid coin source');
        }

        return DB::transaction(function () use ($source, $description, $reference) {
            $amount = $source->default_amount;

            $this->coins += $amount;
            $this->lifetime_earned += $amount;
            $this->last_earned_at = now();
            $this->save();

            return $this->transactions()->create([
                'source_id' => $source->id,
                'type' => 'earned',
                'amount' => $amount,
                'balance_after' => $this->coins,
                'description' => $description ?? $source->name,
                'reference_type' => $reference ? get_class($reference) : null,
                'reference_id' => $reference ? $reference->id : null,
            ]);
        });
    }

    public function spendCoins(CoinSource $source, string $description = null, $reference = null): CoinTransaction
    {
        if (!$source->is_active || $source->type !== 'spend') {
            throw new \Exception('Invalid coin source');
        }

        $amount = $source->default_amount;

        if ($this->coins < $amount) {
            throw new \Exception('Not enough coins');
        }

        return DB::transaction(function () use ($source, $amount, $description, $reference) {
            $this->coins -= $amount;
            $this->lifetime_spent += $amount;
            $this->save();

            return $this->transactions()->create([
                'source_id' => $source->id,
                'type' => 'spent',
                'amount' => $amount,
                'balance_after' => $this->coins,
                'description' => $description ?? $source->name,
                'reference_type' => $reference ? get_class($reference) : null,
                'reference_id' => $reference ? $reference->id : null,
            ]);
        });
    }
}
