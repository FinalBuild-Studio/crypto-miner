<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTableDecimal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transfers', function (Blueprint $table) {
            $table->decimal('amount', 15, 12)->change();
        });

        Schema::table('logs', function (Blueprint $table) {
            $table->decimal('amount', 15, 12)->change();
        });

        Schema::table('revenues', function (Blueprint $table) {
            $table->decimal('amount', 15, 12)->change();
        });

        Schema::table('investments', function (Blueprint $table) {
            $table->decimal('amount', 15, 12)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transfers', function (Blueprint $table) {
            $table->double('amount')->change();
        });

        Schema::table('logs', function (Blueprint $table) {
            $table->double('amount')->change();
        });

        Schema::table('revenues', function (Blueprint $table) {
            $table->double('amount')->change();
        });

        Schema::table('investments', function (Blueprint $table) {
            $table->double('amount')->change();
        });
    }
}
