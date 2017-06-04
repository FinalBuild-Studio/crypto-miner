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

    public function scopeUser($query, $userId, $currencyId)
    {
        return $query
            ->where('user_id', '=', $userId)
            ->where('currency_id', '=', $currencyId);
    }
}
