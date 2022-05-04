<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReplyboardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'post_text' => 'dog111',
            'send_date' => '2022-05-01 11:18:11',
            'post_image_id' => 0,
            'send_user_id' => 2,
            'src_post_id' => 2,
        ];
        DB::table('replyboards')->insert($param);
     
        $param = [
            'post_text' => 'dog222',
            'send_date' => '2022-05-01 11:18:11',
            'post_image_id' => 0,
            'send_user_id' => 2,
            'src_post_id' => 2,
        ];
        DB::table('replyboards')->insert($param);
    }
}
