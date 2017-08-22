<?php

namespace App\Http\Controllers\Panel;

use App\{Wallet, Currency};
use App\Http\Controllers\Controller;

class WalletController extends Controller
{

    public function index()
    {
        $user       = request()->user();
        $ethAmount  = Wallet::who($user->id)->currencyType(Currency::ETH)->sum('amount');
        $btcAmount  = Wallet::who($user->id)->currencyType(Currency::BTC)->sum('amount');
        $twdAmount  = Wallet::who($user->id)->currencyType(Currency::TWD)->sum('amount');
        $dashAmount = Wallet::who($user->id)->currencyType(Currency::DASH)->sum('amount');

        $wallets   = Wallet::who($user->id)->latest()->paginate(10);

        view()->share('wallets', $wallets);
        view()->share('ethAmount', $ethAmount);
        view()->share('btcAmount', $btcAmount);
        view()->share('twdAmount', $twdAmount);
        view()->share('dashAmount', $dashAmount);

        return view('panel.wallet');
    }
}
