<?php

use Zttp\Zttp;
use Carbon\Carbon;
use App\{Investment, Revenue, Log};

if (!function_exists('investors'))
{

    function investors($currency)
    {
        $investors   = [];
        $investments = Investment::valid()->currencyType($currency)->get();

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
            $pluck = collect($investor)->sum('amount');

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
            $value = percentage($value, $amount);
        }

        return $percentage;
    }
}

if (!function_exists('percentage'))
{

    function percentage($child, $mother)
    {
        return floor($child / $mother * pow(10, 5)) / pow(10, 5);;
    }
}

if (!function_exists('decimal_mul'))
{

    function decimal_mul($valueA, $valueB)
    {
        return number_format($valueA * $valueB, decimal($valueA) + decimal($valueB));
    }
}

if (!function_exists('revenue_diff_percentage'))
{

    function revenue_diff_percentage($currency)
    {
        $day = revenue_chart_day($currency);

        $latestAmount = Log::currencyType($currency)
            ->whereDate('created_at', '=', $day->toDateString())
            ->sum('amount');

        $previousAmount = Log::currencyType($currency)
            ->whereDate('created_at', '=', $day->subDay()->toDateString())
            ->sum('amount') ?: 1;

        $diffAmount = $latestAmount ? 1 : 0;

        return round((($latestAmount / $previousAmount) - $diffAmount) * 100, 2);
    }
}

if (!function_exists('revenue_chart_day'))
{

    function revenue_chart_day($currency)
    {
        return Log::currencyType($currency)->latest()->first()->created_at ?? Carbon::now();
    }
}

if (!function_exists('revenue_diff_chart'))
{

    function revenue_diff_chart($currency)
    {
        $twoWeeks = revenue_chart_day($currency)->subDays(14)->toDateString();

        $revenue = Log::currencyType($currency)
            ->latest()
            ->whereDate('created_at', '>=', $twoWeeks)
            ->get();

        $chart = [];
        foreach ($revenue as $value) {
            $createdAt = $value->created_at->format('m/d');

            $chart[$createdAt] = ($chart[$createdAt] ?? 0) + $value->amount;
        }

        ksort($chart);

        return $chart;
    }
}

if (!function_exists('amount_output'))
{

    function amount_output($amount)
    {
        $html   = '<font color="%s">%s</font>';
        $color  = $amount < 0 ? 'red' : 'green';
        $color  = $amount == 0 ? 'black' : $color;
        $amount = str_replace('-', '', $amount);

        return sprintf($html, $color, $amount);
    }
}

if (!function_exists('javascript'))
{

    function javascript(array $input)
    {
        JavaScript::put($input);
    }
}

if (!function_exists('form'))
{

    function form(array $input)
    {
        javascript(['form' => $input]);
    }
}

if (!function_exists('decimal'))
{

    function decimal($value)
    {
        if (strrpos($value, 'E') > -1) {
            $nodec = str_replace('.', '', $value);

            list($num, $exp) = explode('E', $nodec);

            if ($exp < 0) {
                $value = '0.' . str_repeat('0', - ($exp + 1)) . $num;
            } elseif ($exp > 0) {
                $value = $num . str_repeat('0', $exp);
            }
        }

        return strlen(substr(rtrim($value, '0'), strpos(rtrim($value, '0'), '.') + 1));
    }
}

if (!function_exists('decimal_value'))
{

    function decimal_value($value)
    {
        $value = rtrim($value, '0');

        return substr($value, -1) === '.' ? substr($value, 0, -1) : $value;
    }
}

if (!function_exists('crypto_value'))
{

    function crypto_value($type)
    {
        $type = strtolower($type);

        switch ($type) {
            case 'btc':
            case 'eth':
                return Zttp::get('https://www.maicoin.com/api/prices/'.$type.'-twd')->json()['raw_sell_price'] / 100000;
        }

        return 0;
    }
}

if (!function_exists('crypto_sum'))
{

    function crypto_sum(array $crypto)
    {
        $sum = 0;
        foreach ($crypto as $type => $value) {
            $sum += (crypto_value($type) * (rtrim($value, '0') ?: 0));
        }

        return $sum;;
    }
}

if (!function_exists('member_search_options'))
{

    function member_search_options()
    {
        $options = '<option>請輸入要轉讓的對象</option>';
        foreach (App\User::all() as $user) {
            $options .= '<option value="'.$user->id.'">'.$user->email.'</option>';
        }

        return $options;
    }
}
