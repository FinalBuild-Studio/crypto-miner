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

        $dashInvestors = investors(Currency::DASH);
        $dashRevenue   = ($dashInvestors[$user->id] ?? 0) * 100;

        view()->share('ethRevenue', $ethRevenue);
        view()->share('btcRevenue', $btcRevenue);
        view()->share('dashRevenue', $dashRevenue);

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
         * DASH
         */
        $dash       = Revenue::who($user->id)->currencyType(Currency::DASH)->sum('amount');
        $dashWallet = Wallet::who($user->id)->currencyType(Currency::DASH)->sum('amount');

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
        view()->share('dash', $dash);
        view()->share('dashWallet', $dashWallet);
        view()->share('twdWallet', $twdWallet);

        $btcPercentage = revenue_diff_percentage(Currency::BTC);
        $ethPercentage = revenue_diff_percentage(Currency::ETH);
        $dashPercentage = revenue_diff_percentage(Currency::DASH);

        view()->share('btcPercentage', $btcPercentage);
        view()->share('ethPercentage', $ethPercentage);
        view()->share('dashPercentage', $dashPercentage);

        $btcChart  = revenue_diff_chart(Currency::BTC);
        $ethChart  = revenue_diff_chart(Currency::ETH);
        $dashChart = revenue_diff_chart(Currency::DASH);

        view()->share('btcChart', $btcChart);
        view()->share('ethChart', $ethChart);
        view()->share('dashChart', $dashChart);

        return view('panel.dashboard');
    }
}
