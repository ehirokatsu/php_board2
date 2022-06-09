<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BoardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'post_text' => 'テスト投稿',
            'send_date' => '2022-04-30 11:18:11',
            'user_id' => 1
        ];
        DB::table('boards')->insert($param);

    }
}
