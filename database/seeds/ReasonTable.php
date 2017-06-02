<?php

use Illuminate\Database\Seeder;

class ReasonTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('reasons')->insert([
            'id'   => 1,
            'name' => '收益'
        ]);

        DB::table('reasons')->insert([
            'id'   => 2,
            'name' => '轉入錢包'
        ]);
    }
}
