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

    public function scopeInvestors($query)
    {
        $investors   = [];
        $investments = $query
            ->whereNotNull('expired_at')
            ->whereDate('expired_at', '>=', Carbon::now())
            ->get();

        foreach ($investments as $investment) {
            $investors[$investment->user_id]   = $investors[$investment->user_id] ?? [];
            $investors[$investment->user_id][] = $investment;
        }

        return $investors;
    }

    public function scopePercentage($query)
    {
        $percentage = [];
        $investors  = $query->investors();
        $amount     = 0;

        foreach ($investors as $userId => $investor) {
            /**
             * calculate sum of investment
             */
            $pluck = array_pluck($investor, 'amount');
            $pluck = array_sum($pluck);

            /**
             * raw percentage data
             */
            $percentage[$userId] = $pluck;

            /**
             * total amount
             */
            $amount += $pluck;
        }

        foreach ($percentage as &$value) {
            $value = round($value / $amount, 5, PHP_ROUND_HALF_DOWN);
        }

        return $percentage;
    }
}
