<?php

namespace App\Http\Controllers\Wallet;

use DB;
use App\Exceptions\GeneralException;
use App\{Wallet, Currency};
use App\Http\Controllers\Controller;

class SellController extends Controller
{

    public function store()
    {
        $user     = request()->user();
        $currency = request()->input('currency');
        $amount   = request()->input('amount', 0);
        $priceAt  = request()->input('price_at', 0);
        $currency = Currency::name($currency);

        $wallet = Wallet::user($user->id, $currency->id);

        if (!$currency->is_crypto) {
            throw new GeneralException(100);
        }

        if ($amount > $wallet) {
            throw new GeneralException(101);

        }

        if ($currency->min_sell > $amount) {
            throw new GeneralException(102);
        }

        DB::transaction(function() use ($amount, $currency, $user, $priceAt) {
            Wallet::createOrFail([
                'amount'      => - $amount,
                'currency_id' => $currency->id,
                'user_id'     => $user->id,
            ]);

            Transfer::createOrFail([
                'amount'      => $amount,
                'currency_id' => $currency->id,
                'user_id'     => $user->id,
                'price_at'    => $priceAt
            ]);
        });

        return back();
    }
}
