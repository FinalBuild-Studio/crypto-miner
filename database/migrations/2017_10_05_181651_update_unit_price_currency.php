<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUnitPriceCurrency extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('currencies')->whereName('BTC')->update(['unit_price' => 1.5]);
        DB::table('currencies')->whereName('DASH')->update(['unit_price' => 3.2]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('currencies')->whereName('BTC')->update(['unit_price' => 1.2]);
        DB::table('currencies')->whereName('DASH')->update(['unit_price' => 5.8]);
    }
}
