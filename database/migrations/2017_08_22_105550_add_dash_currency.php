<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDashCurrency extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('currencies')->insert([
            'id'         => 5,
            'name'       => 'DASH',
            'is_crypto'  => true,
            'fee'        => 0,
            'unit_price' => 5.8,
            'is_crypto'  => true,
            'min_sell'   => 0,
            'years'      => 1,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('currencies')->where('id', '=', 5)->delete();
    }
}
