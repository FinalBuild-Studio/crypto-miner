<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRecordToReason extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('reasons')->insert([
            'id'   => 5,
            'name' => '轉讓'
        ]);

        DB::table('reasons')->insert([
            'id'   => 6,
            'name' => '接收'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('reasons')->where('id', '=', 5)->delete();
        DB::table('reasons')->where('id', '=', 6)->delete();
    }
}
