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
        $eth       = Revenue::user($user->id)->currency(Currency::ETH)->sum('amount');
        $ethWallet = Wallet::user($user->id)->currency(Currency::ETH)->sum('amount');

        /**
         * BTC
         */
        $btc       = Revenue::user($user->id)->currency(Currency::BTC)->sum('amount');
        $btcWallet = Wallet::user($user->id)->currency(Currency::BTC)->sum('amount');

        /**
         * TWD
         */
        $twdWallet = Wallet::user($user->id)->currency(Currency::TWD)->sum('amount');

        /**
         * set view variable
         */
        view()->share('percentage', $percentage);
        view()->share('eth', $eth);
        view()->share('ethWallet', $ethWallet);
        view()->share('btc', $btc);
        view()->share('btcWallet', $btcWallet);
        view()->share('twdWallet', $twdWallet);


        $btcLatest   = Revenue::currency(Currency::BTC)
            ->latest()
            ->first();
        $btcPrevious = Revenue::currency(Currency::BTC)
            ->latest()
            ->skip(1)
            ->take(1)
            ->first();
        $ethLatest   = Revenue::currency(Currency::ETH)
            ->latest()
            ->first();
        $ethPrevious = Revenue::currency(Currency::ETH)
            ->latest()
            ->skip(1)
            ->take(1)
            ->first();

        $btcLatestAmount   = $btcLatest->amount ?? 0;
        $btcPreviousAmount = $btcPrevious->amount ?? 1;
        $ethLatestAmount   = $ethLatest->amount ?? 0;
        $ethPreviousAmount = $ethPrevious->amount ?? 1;
        $btcPercentage     = round($btcLatestAmount / $btcPreviousAmount * 100, 2);
        $ethPercentage     = round($ethLatestAmount / $ethPreviousAmount * 100, 2);

        view()->share('btcPercentage', $btcPercentage);
        view()->share('ethPercentage', $ethPercentage);

        return view('dashboard');
    }
}
