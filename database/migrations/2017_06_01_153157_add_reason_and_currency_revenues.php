<?php

use App\Reason;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReasonAndCurrencyRevenues extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('revenues', function (Blueprint $table) {
            $table->unsignedInteger('reason_id')->default(Reason::REVENUE);
            $table->foreign('reason_id')->references('id')->on('reasons');
            $table->unsignedInteger('currency_id');
            $table->foreign('currency_id')->references('id')->on('currencies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('revenues', function (Blueprint $table) {
            $table->dropForeign('reason_id');
            $table->dropColumn('reason_id');
            $table->dropForeign('currency_id');
            $table->dropColumn('currency_id');
        });
    }
}
