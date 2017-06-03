<?php

use Illuminate\Database\Seeder;

class CurrencyTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('currencies')->insert([
            'id'         => 1,
            'name'       => 'ETH',
            'fee'        => 0.0006,
            'unit_price' => 2.2,
            'is_crypto'  => true,
            'min_sell'   => 0.1,
        ]);

        DB::table('currencies')->insert([
            'id'         => 2,
            'name'       => 'BTC',
            'fee'        => 0.0013,
            'unit_price' => 1.2,
            'is_crypto'  => true,
            'min_sell'   => 0.001,
        ]);

        DB::table('currencies')->insert([
            'id'   => 3,
            'name' => 'USD'
        ]);

        DB::table('currencies')->insert([
            'id'   => 4,
            'name' => 'TWD',
        ]);
    }
}
