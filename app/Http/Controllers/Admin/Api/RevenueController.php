<?php

namespace App\Http\Controllers\Admin\Api;

use DB;
use App\Exceptions\GeneralException;
use App\{Currency, Investment, Revenue, Log};
use App\Http\Controllers\Controller;

class RevenueController extends Controller
{

    public function store()
    {
        $json     = request()->json();
        $currency = $json->get('currency');
        $amount   = $json->get('amount');

        $currency = Currency::name($currency)->firstOrFail();

        if (!$currency->is_crypto) {
            throw new GeneralException(100);
        }

        $transfered = false;
        DB::transaction(function() use ($currency, $amount, &$transfered) {
            $percentages = Investment::percentage();
            foreach ($percentages as $userId => $percentage) {
                Revenue::createOrFail([
                    'currency_id' => $currency->id,
                    'amount'      => $amount * $percentage,
                    'user_id'     => $userId,
                    'percentage'  => $percentage,
                ]);
            }

            Log::createOrFail([
                'currency_id' => $currency->id,
                'amount'      => $amount,
            ]);

            $transfered = true;
        });

        return response()->json(compact('transfered'));
    }
}
