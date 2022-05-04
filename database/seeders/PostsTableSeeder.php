<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'post_id' => 1,
            'reply_flag' => false,
        ];
        DB::table('posts')->insert($param);

        $param = [
            'post_id' => 2,
            'reply_flag' => true,
        ];
        DB::table('posts')->insert($param);
    }
}
