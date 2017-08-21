<?php

namespace App\Http\Controllers\Panel;

use App\{Revenue, Currency, Wallet};
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{

    public function index()
    {
        $user = request()->user();

        /**
         * get current user percentage
         */
        $ethInvestors = investors(Currency::ETH);
        $ethRevenue   = ($ethInvestors[$user->id] ?? 0) * 100;

        $btcInvestors = investors(Currency::BTC);
        $btcRevenue   = ($btcInvestors[$user->id] ?? 0) * 100;

        view()->share('ethRevenue', $ethRevenue);
        view()->share('btcRevenue', $btcRevenue);

        /**
         * ETH
         */
        $eth       = Revenue::who($user->id)->currencyType(Currency::ETH)->sum('amount');
        $ethWallet = Wallet::who($user->id)->currencyType(Currency::ETH)->sum('amount');

        /**
         * BTC
         */
        $btc       = Revenue::who($user->id)->currencyType(Currency::BTC)->sum('amount');
        $btcWallet = Wallet::who($user->id)->currencyType(Currency::BTC)->sum('amount');

        /**
         * TWD
         */
        $twdWallet = Wallet::who($user->id)->currencyType(Currency::TWD)->sum('amount');

        /**
         * set view variable
         */
        view()->share('eth', $eth);
        view()->share('ethWallet', $ethWallet);
        view()->share('btc', $btc);
        view()->share('btcWallet', $btcWallet);
        view()->share('twdWallet', $twdWallet);

        $btcPercentage = revenue_diff_percentage(Currency::BTC);
        $ethPercentage = revenue_diff_percentage(Currency::ETH);

        view()->share('btcPercentage', $btcPercentage);
        view()->share('ethPercentage', $ethPercentage);

        $btcChart = revenue_diff_chart(Currency::BTC);
        $ethChart = revenue_diff_chart(Currency::ETH);

        view()->share('btcChart', $btcChart);
        view()->share('ethChart', $ethChart);

        return view('panel.dashboard');
    }
}
