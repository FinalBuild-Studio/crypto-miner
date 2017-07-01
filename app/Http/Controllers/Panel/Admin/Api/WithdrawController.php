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
            $deposit  = 0;
            $amounts  = [];
            $revenues = Revenue::select(DB::raw('SUM(amount) as amount'), 'user_id')
                ->currencyType($currency->id)
                ->groupBy('user_id')
                ->get();

            $deposit = collect($revenues)->sum('amount');

            foreach ($revenues as $revenue) {
                $userId     = $revenue->user_id;
                $amountSum  = $revenue->amount;
                $percentage = percentage($amountSum, $deposit);

                if ($amountSum > 0) {
                    Revenue::create([
                        'currency_id' => $currency->id,
                        'amount'      => - $amountSum,
                        'user_id'     => $userId,
                        'reason_id'   => Reason::TRANSFER,
                        'percentage'  => $percentage,
                    ]);

                    Wallet::create([
                        'currency_id' => $currency->id,
                        'amount'      => $amountSum - decimal_mul($currency->fee, $percentage),
                        'user_id'     => $userId,
                        'percentage'  => $percentage,
                    ]);

                    $deposit -= $amountSum;
                }
            }

            $transfered = true;
        });

        return response()->json(compact('transfered'));
    }
}
