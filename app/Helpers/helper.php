<?php

use Zttp\Zttp;
use Carbon\Carbon;
use App\{Investment, Revenue, Log, User, Reason};

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
        try {
            $type = strtolower($type);

            $price = Redis::get('price:'.$type);

            if (!$price) {
                switch ($type) {
                    case 'dash':
                        $price = Zttp::get('https://poloniex.com/public?command=returnTicker')->json()['USDT_DASH']['last'] * Swap::latest('USD/TWD')->getValue();
                        break;
                    case 'btc':
                    case 'eth':
                        $price = Zttp::get('https://www.maicoin.com/api/prices/'.$type.'-twd')->json()['raw_sell_price'] / 100000;
                        break;
                }

                Redis::set('price:'.$type, $price);
                Redis::expire('price:'.$type, 15);
            }

            return $price;
        } catch (Exception $e) {
            return crypto_value($type);
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
        foreach (User::all() as $user) {
            $options .= '<option value="'.$user->id.'">'.'('.$user->platform.') '.$user->email.'</option>';
        }

        return $options;
    }
}

if (!function_exists('annual_revenue'))
{

    function annual_revenue(User $user)
    {
        $revenue = $user->revenue->reverse()->take(1)->first();

        $date = $revenue->created_at ?? Carbon::now();

        $revenues = Revenue::who($user->id)
            ->whereIn('reason_id', [Reason::REVENUE, Reason::MAINTENANCE])
            ->whereDate('created_at', '=', $date->toDateString())
            ->get();

        $type  = [];
        $total = 0;
        foreach ($revenues as $value) {
            $currencyId   = $value->currency->id;
            $currencyName = $value->currency->name;

            $type[$currencyId] = $type[$currencyId] ?? crypto_value($currencyName);

            $total += $type[$currencyId] * $value->amount;
        }

        $investments = Swap::latest('USD/TWD')->getValue() * Investment::who($user->id)->valid()->sum('amount');

        return round((($total * 365 - $investments) / ($investments ?: 1)) * 100, 8);
    }
}

if (!function_exists('annual_revenue_type'))
{

    function annual_revenue_type()
    {
        $date = Log::latest()
            ->take(1)
            ->first()
            ->created_at;

        $revenues = Revenue::whereIn('reason_id', [Reason::REVENUE, Reason::MAINTENANCE])
            ->whereDate('created_at', '=', $date->toDateString())
            ->get();

        $type  = [];
        $total = [];
        $map   = [];
        foreach ($revenues as $value) {
            $currencyId   = $value->currency->id;
            $currencyName = $value->currency->name;

            $map[$currencyId]    = $currencyName;
            $type[$currencyId]   = $type[$currencyId] ?? crypto_value($currencyName);
            $total[$currencyId]  = $total[$currencyId] ?? 0;
            $total[$currencyId] += $type[$currencyId] * $value->amount;
        }

        $investments = Investment::valid()
            ->groupBy('currency_id')
            ->select(DB::raw('currency_id, SUM(amount) AS amount'))
            ->get();

        $usd = Swap::latest('USD/TWD')->getValue();

        $result = [];
        foreach ($investments as $investment) {
            $result[$map[$investment->currency_id]] = round((($total[$investment->currency_id] * 365 - $usd * $investment->amount) / ($usd * $investment->amount ?: 1)) * 100, 8);
        }

        return $result;
    }
}
