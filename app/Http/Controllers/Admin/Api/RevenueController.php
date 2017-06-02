<?php

namespace App\Http\Controllers\Admin\Api;

use DB;
use Illuminate\Http\Request;
use App\{Currency, Investment, Revenue, Log};
use App\Http\Controllers\Controller;

class RevenueController extends Controller
{

    public function store()
    {
        $json     = request()->json();
        $currency = $json->get('currency');
        $amount   = $json->get('amount');

        $currency = Currency::name($currency);

        if (!$currency->is_crypto) {
            // throw
        }

        $transfered  = false;
        $percentages = Investment::percentage();

        DB::transaction(function() use ($percentages, $currency, $amount, &$transfered) {
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
