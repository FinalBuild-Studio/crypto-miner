<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{

    protected $fillable = [
        'currency_id',
        'amount',
        'user_id',
        'percentage',
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function scopeWho($query, $userId)
    {
        return $query->where('user_id', '=', $userId);
    }

    public function scopeCurrencyType($query, $currencyId)
    {
        return $query->where('currency_id', '=', $currencyId);
    }
}
