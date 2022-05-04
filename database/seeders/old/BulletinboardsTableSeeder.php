<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BulletinboardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'post_text' => 'cat111',
            'send_date' => '2022-04-30 11:18:11',
            'post_image_id' => 0,
            'send_user_id' => 1,
            'reply_flag' => false,
        ];
        DB::table('bulletinboards')->insert($param);
     
        $param = [
            'post_text' => 'cat222',
            'send_date' => '2022-04-30 11:31:11',
            'post_image_id' => 0,
            'send_user_id' => 1,
            'reply_flag' => true,
        ];
        DB::table('bulletinboards')->insert($param);
    }
}
