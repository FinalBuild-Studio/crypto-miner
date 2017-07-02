<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{

    public const UNCONFIRMED = 0;
    public const ENABLED     = 1;
    public const EXPIRED     = 2;

    protected $dates = [
        'expired_at',
    ];

    protected $fillable = [
        'amount',
        'status',
        'currency_id',
        'user_id',
        'code',
        'expired_at',
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getAmountAttribute($value)
    {
        return decimal_value($value);
    }

    public function scopeValid($query)
    {
        return $query->whereNotNull('expired_at')
            ->whereDate('expired_at', '>=', Carbon::now());
    }

    public function scopeWho($query, $userId)
    {
        return $query->where('user_id', '=', $userId);
    }

    public function scopeCurrencyType($query, $currencyId)
    {
        return $query->where('currency_id', '=', $currencyId);
    }

    public function scopeUnconfirmed($query)
    {
        return $query->where('status', '=', self::UNCONFIRMED);
    }
}
