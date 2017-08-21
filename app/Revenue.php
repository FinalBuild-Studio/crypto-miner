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

    public function reason()
    {
        return $this->belongsTo(Reason::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function getAmountAttribute($value)
    {
        return decimal_value($value);
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
