<?php

namespace App\Console\Commands;

use Zttp\Zttp;
use App\{Transfer, Currency, Wallet};
use Illuminate\Console\Command;

class SellCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transfer:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sell crypto coins with specified price';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $transfers = Transfer::waiting()
            ->where('amount', '>', 0)
            ->where('price_at', '>=', 0)
            ->get();

        $price      = [];
        $currencies = [];
        $wallet     = [];
        $handle     = [];

        $this->line('取得目前賣價...');
        $price[Currency::ETH] = Zttp::get('https://www.maicoin.com/api/prices/eth-twd')->json()['raw_sell_price'] / 100000;
        $price[Currency::BTC] = Zttp::get('https://www.maicoin.com/api/prices/btc-twd')->json()['raw_sell_price'] / 100000;
        $this->info('已經取得目前賣價!');

        $this->line('處理請求中的訂單...');
        foreach ($transfers as $transfer) {
            $transfer->update(['status' => Transfer::PROCESSING]);

            $userId      = $transfer->user_id;
            $currencyId  = $transfer->currency_id;
            $priceAt     = $transfer->price_at;
            $amount      = $transfer->amount;
            $cryptoPrice = $price[$currencyId];
            $twdAmount   = decimal_mul($cryptoPrice, $amount);

            $currencies[$currencyId] = $currencies[$currencyId] ?? $transfer->currency;

            if ($priceAt == 0 || $cryptoPrice > $priceAt) {
                $this->comment('交易訂單已接受，編號: '.$transfer->id);

                $handle[$currencyId]   = $handle[$currencyId] ?? [];
                $handle[$currencyId][] = $transfer;
                $wallet[$currencyId]   = $wallet[$currencyId] ?? [];

                $wallet[$currencyId][$userId] = $wallet[$currencyId][$userId] ?? 0 + $twdAmount;
            }
        }

        $this->line('處理賣單...');
        foreach ($handle as $currencyId => $transfers) {
            $cryptoPrice = $price[$currencyId];
            $currency    = $currencies[$currencyId];
            $total       = collect($transfers)->sum('amount');

            $this->comment($currency->name.': '.$total);

            if ($total > $currency->min_sell) {
                exec('node '.base_path("scripts/sell.js").' '.$currency->name.' '.$total);

                foreach ($transfers as $transfer) {
                    $transfer->update([
                        'status'    => Transfer::DONE,
                        'twd_price' => $cryptoPrice,
                    ]);
                }
            } else {
                unset($wallet[$currencyId]);
            }
        }

        $this->line('匯入台幣帳戶中...');
        foreach ($wallet as $currencyId => $transfers) {
            foreach ($transfers as $userId => $twdAmount) {
                $twdAmount = round($twdAmount);

                Wallet::create([
                    'user_id'     => $userId,
                    'currency_id' => Currency::TWD,
                    'amount'      => $twdAmount,
                ]);
            }
        }
    }
}
