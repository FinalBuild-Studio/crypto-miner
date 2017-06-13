<?php

namespace App\Http\Controllers\Panel;

use App\{Wallet, Currency};
use App\Http\Controllers\Controller;

class WalletController extends Controller
{

    public function index()
    {
        $user      = request()->user();
        $ethAmount = Wallet::user($user->id)->currency(Currency::ETH)->sum('amount');
        $btcAmount = Wallet::user($user->id)->currency(Currency::BTC)->sum('amount');
        $twdAmount = Wallet::user($user->id)->currency(Currency::TWD)->sum('amount');

        $wallets   = Wallet::user($user->id)->paginate(10);

        view()->share('wallets', $wallets);
        view()->share('ethAmount', $ethAmount);
        view()->share('btcAmount', $btcAmount);
        view()->share('twdAmount', $twdAmount);

        return view('panel.wallet');
    }
}
