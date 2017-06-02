<?php

namespace App\Http\Controllers;

use App\{Investment, Revenue, Currency};
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        $user = request()->user();

        /**
         * get current user percentage
         */
        $percentages = Investment::percentage();
        $percentage  = $percentages[$user->id] * 100;

        /**
         * ETH
         */
        $eth       = Revenue::user($user->id, Currency::ETH);
        $ethWallet = Wallet::user($user->id, Currency::ETH);

        /**
         * BTC
         */
        $btc       = Revenue::user($user->id, Currency::BTC);
        $btcWallet = Wallet::user($user->id, Currency::BTC);

        /**
         * TWD
         */
        $twdWallet = Wallet::user($user->id, Currency::TWD);

        /**
         * set view variable
         */
        view()->share('percentage', $percentage);
        view()->share('eth', $eth);
        view()->share('ethWallet', $ethWallet);
        view()->share('btc', $btc);
        view()->share('btcWallet', $btcWallet);
        view()->share('twd', $twdWallet);

        return view('dashboard');
    }
}
