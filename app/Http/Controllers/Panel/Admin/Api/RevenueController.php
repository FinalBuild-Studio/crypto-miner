<?php

namespace App\Http\Controllers\Panel\Admin\Api;

use DB;
use App\Exceptions\GeneralException;
use App\{Currency, Investment, Revenue, Log, Reason};
use App\Http\Controllers\Controller;

class RevenueController extends Controller
{

    public function store()
    {
        $json        = request()->json();
        $currency    = $json->get('currency');
        $amount      = $json->get('amount');
        $maintenance = $json->get('maintenance', 0);

        $currency = Currency::name($currency)->firstOrFail();

        if (!$currency->is_crypto) {
            throw new GeneralException(100);
        }

        if ($amount <= 0 || $maintenance < 0) {
            throw new GeneralException(104);
        }

        $transfered = false;
        DB::transaction(function() use ($currency, $amount, $maintenance, &$transfered) {
            $percentages = investors($currency->id);
            foreach ($percentages as $userId => $percentage) {
                Revenue::create([
                    'currency_id' => $currency->id,
                    'amount'      => $amount * $percentage,
                    'user_id'     => $userId,
                    'percentage'  => $percentage,
                    'reason_id'   => Reason::REVENUE,
                ]);

                if ($maintenance > 0) {
                    Revenue::create([
                        'currency_id' => $currency->id,
                        'amount'      => - $maintenance * $percentage,
                        'user_id'     => $userId,
                        'percentage'  => $percentage,
                        'reason_id'   => Reason::MAINTENANCE,
                    ]);
                }
            }

            Log::create([
                'currency_id' => $currency->id,
                'amount'      => $amount,
            ]);

            $transfered = true;
        });

        return response()->json(compact('transfered'));
    }
}
