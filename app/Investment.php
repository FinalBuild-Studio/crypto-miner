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

    public function scopeValid($query)
    {
        return $query->whereNotNull('expired_at')
            ->whereDate('expired_at', '>=', Carbon::now());
    }
}
