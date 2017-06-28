<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeTimestampTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('investments', function (Blueprint $table) {
            $table->dateTimeTz('expired_at')->change();
            $table->dateTimeTz('created_at')->change();
            $table->dateTimeTz('updated_at')->change();
        });

        Schema::table('logs', function (Blueprint $table) {
            $table->dateTimeTz('created_at')->change();
            $table->dateTimeTz('updated_at')->change();
        });

        Schema::table('password_resets', function (Blueprint $table) {
            $table->dateTimeTz('created_at')->change();
        });

        Schema::table('revenues', function (Blueprint $table) {
            $table->dateTimeTz('created_at')->change();
            $table->dateTimeTz('updated_at')->change();
        });

        Schema::table('transfers', function (Blueprint $table) {
            $table->dateTimeTz('created_at')->change();
            $table->dateTimeTz('updated_at')->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dateTimeTz('created_at')->change();
            $table->dateTimeTz('updated_at')->change();
        });

        Schema::table('wallets', function (Blueprint $table) {
            $table->dateTimeTz('created_at')->change();
            $table->dateTimeTz('updated_at')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('investments', function (Blueprint $table) {
            $table->timestamp('expired_at')->change();
            $table->timestamp('created_at')->change();
            $table->timestamp('updated_at')->change();
        });

        Schema::table('logs', function (Blueprint $table) {
            $table->timestamp('created_at')->change();
            $table->timestamp('updated_at')->change();
        });

        Schema::table('password_resets', function (Blueprint $table) {
            $table->timestamp('created_at')->change();
        });

        Schema::table('revenues', function (Blueprint $table) {
            $table->timestamp('created_at')->change();
            $table->timestamp('updated_at')->change();
        });

        Schema::table('transfers', function (Blueprint $table) {
            $table->timestamp('created_at')->change();
            $table->timestamp('updated_at')->change();
        });

        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('created_at')->change();
            $table->timestamp('updated_at')->change();
        });

        Schema::table('wallets', function (Blueprint $table) {
            $table->timestamp('created_at')->change();
            $table->timestamp('updated_at')->change();
        });
    }
}
