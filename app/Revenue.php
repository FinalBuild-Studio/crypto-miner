<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Revenue extends Model
{

    protected $fillable = [
        'currency_id',
        'amount',
        'user_id',
        'percentage',
        'reason_id',
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function scopeUser($query, $userId)
    {
        return $query->where('user_id', '=', $userId);
    }

    public function scopeCurrency($query, $currencyId)
    {
        return $query->where('currency_id', '=', $currencyId);
    }
}
