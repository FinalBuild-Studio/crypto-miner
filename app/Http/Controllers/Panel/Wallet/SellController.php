<?php

namespace App\Http\Controllers\Panel\Wallet;

use DB;
use App\Exceptions\GeneralException;
use App\{Currency, Wallet, Transfer};
use App\Http\Controllers\Controller;

class SellController extends Controller
{

    public function store()
    {
        $user     = request()->user();
        $currency = request()->input('currency');
        $amount   = request()->input('amount', 0);
        $priceAt  = request()->input('price_at', 0);
        $currency = Currency::name($currency)->firstOrFail();

        if (!$currency->is_crypto) {
            throw new GeneralException(100);
        }

        if ($currency->min_sell > $amount) {
            throw new GeneralException(102);
        }

        $wallet = Wallet::who($user->id)
            ->currencyType($currency->id)
            ->sum('amount');

        if ($amount > $wallet) {
            throw new GeneralException(101);
        }

        DB::transaction(function() use ($amount, $currency, $user, $priceAt) {
            Wallet::create([
                'amount'      => - $amount,
                'currency_id' => $currency->id,
                'user_id'     => $user->id,
            ]);

            Transfer::create([
                'amount'      => $amount,
                'currency_id' => $currency->id,
                'user_id'     => $user->id,
                'price_at'    => $priceAt
            ]);
        });

        return back();
    }
}
