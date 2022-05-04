<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserboardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'user_id' => 1,
            'post_id' => 1,
        ];
        DB::table('userboards')->insert($param);

        $param = [
            'user_id' => 2,
            'post_id' => 2,
        ];
        DB::table('userboards')->insert($param);
    }
}
