<?php

namespace App\Http\Controllers\Panel\Admin\Api;

use DB;
use App\Exceptions\GeneralException;
use App\{Currency, Investment, Revenue, Reason, Wallet, WithdrawLog};
use App\Http\Controllers\Controller;

class WithdrawController extends Controller
{

    public function store()
    {
        $currency = request()->json()->get('currency');
        $currency = Currency::name($currency)->firstOrFail();

        if (!$currency->is_crypto) {
            throw new GeneralException(100);
        }

        $transfered = false;
        DB::transaction(function() use ($currency, &$transfered) {
            $deposit  = [];
            $amounts  = [];
            $revenues = Revenue::currencyType($currency->id)->get();
            foreach ($revenues as $revenue) {
                $amounts[$currency->id] = $amount[$currency->id] ?? [];
                $amounts[$currency->id][$revenue->user_id] = $amount[$currency->id][$revenue->user_id] ?? [];
                $amounts[$currency->id][$revenue->user_id] = $revenue;

                $deposit[$currency->id]  = $deposit[$currency->id] ?? 0;
                $deposit[$currency->id] += $revenue->amount;
            }

            foreach ($amounts as $currencyId => $amount) {
                foreach ($amount as $userId => $revenue) {
                    $amountSum = collect($revenue)->sum('amount');
                    $percentage = $sum / $deposit[$currencyId];

                    if ($sum > 0) {
                        Revenue::create([
                            'currency_id' => $currencyId,
                            'amount'      => - $amountSum,
                            'user_id'     => $userId,
                            'reason_id'   => Reason::TRANSFER,
                            'percentage'  => $percentage,
                        ]);

                        Wallet::create([
                            'currency_id' => $currencyId,
                            'amount'      => $amountSum - $percentage * $currency->fee,
                            'user_id'     => $userId,
                            'percentage'  => $percentage,
                        ]);
                    }
                }
            }

            $transfered = true;
        });

        return response()->json(compact('transfered'));
    }
}
