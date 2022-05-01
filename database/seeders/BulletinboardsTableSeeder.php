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
            'post_image_id' => 0,
            'send_user_id' => 0,
            'reply_flag' => false,
        ];
        DB::table('bulletinboards')->insert($param);
     
        $param = [
            'post_text' => 'cat222',
            'post_image_id' => 0,
            'send_user_id' => 0,
            'reply_flag' => false,
        ];
        DB::table('bulletinboards')->insert($param);
    }
}
