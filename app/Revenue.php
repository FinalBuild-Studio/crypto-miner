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

    protected $casts = [
       'amount' => 'float',
    ];

    public function reason()
    {
        return $this->belongsTo(Reason::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function scopeUser($query, $userId)
    {
        return $query->where('user_id', '=', $userId);
    }

    public function scopeCurrencyType($query, $currencyId)
    {
        return $query->where('currency_id', '=', $currencyId);
    }
}
