<?php

namespace App\Http\Controllers\Admin\Api;

use DB;
use App\Exceptions\GeneralException;
use App\{Currency, Investment, Revenue, Reason, Wallet};
use App\Http\Controllers\Controller;

class WithdrawController extends Controller
{

    public function store()
    {
        $json     = request()->json();
        $currency = $json->get('currency');
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
