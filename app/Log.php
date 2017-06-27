<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{

    protected $fillable = [
        'currency_id',
        'amount',
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function scopeCurrencyType($query, $currencyId)
    {
        return $query->where('currency_id', '=', $currencyId);
    }
}
