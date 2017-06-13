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
        'currency_id',
        'user_id',
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function scopeValid($query)
    {
        return $query->whereNotNull('expired_at')
            ->whereDate('expired_at', '>=', Carbon::now());
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
