<?php

namespace App\Http\Controllers;

use App\{Revenue, Currency, Wallet};
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        $user = request()->user();

        /**
         * get current user percentage
         */
        $investors  = investors();
        $percentage = ($investors[$user->id] ?? 0) * 100;

        /**
         * ETH
         */
        $eth       = Revenue::user($user->id, Currency::ETH)->sum('amount');
        $ethWallet = Wallet::user($user->id, Currency::ETH)->sum('amount');

        /**
         * BTC
         */
        $btc       = Revenue::user($user->id, Currency::BTC)->sum('amount');
        $btcWallet = Wallet::user($user->id, Currency::BTC)->sum('amount');

        /**
         * TWD
         */
        $twdWallet = Wallet::user($user->id, Currency::TWD)->sum('amount');

        /**
         * set view variable
         */
        view()->share('percentage', $percentage);
        view()->share('eth', $eth);
        view()->share('ethWallet', $ethWallet);
        view()->share('btc', $btc);
        view()->share('btcWallet', $btcWallet);
        view()->share('twdWallet', $twdWallet);

        return view('dashboard');
    }
}
