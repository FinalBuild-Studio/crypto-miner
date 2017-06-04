<?php

use App\Investment;

if (!function_exists('investors'))
{

    function investors()
    {
        $investors   = [];
        $investments = Investment::valid()->get();

        foreach ($investments as $investment) {
            $investors[$investment->user_id]   = $investors[$investment->user_id] ?? [];
            $investors[$investment->user_id][] = $investment;
        }

        $percentage = [];
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
