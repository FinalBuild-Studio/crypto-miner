<?php

namespace App\Http\Controllers\Admin\Api;

use DB;
use Illuminate\Http\Request;
use App\{Currency, Investment, Revenue, Reason, Wallet};
use App\Http\Controllers\Controller;

class WithdrawController extends Controller
{

    public function store()
    {
        $json     = request()->json();
        $currency = $json->get('currency');
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
                    'amount'      => - ($percentage * $amount),
                    'user_id'     => $userId,
                    'reason_id'   => Reason::TRANSFER,
                    'percentage'  => $percentage,
                ]);

                Wallet::createOrFail([
                    'currency_id' => $currency->id,
                    'amount'      => $percentage * ($amount - $currency->fee),
                    'user_id'     => $userId,
                    'percentage'  => $percentage,
                ]);
            }

            $transfered = true;
        });

        return response()->json(compact('transfered'));
    }
}
