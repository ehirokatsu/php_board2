<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $param = [
           'user_name' => 'cat',
           'user_mail' => 'cat@cat.com',
           'user_pass' => 'cat',
           'user_image_id' => 0,
       ];
       DB::table('users')->insert($param);
    
       $param = [
        'user_name' => 'dog',
        'user_mail' => 'dog@dog.com',
        'user_pass' => 'dog',
        'user_image_id' => 0,
    ];
    DB::table('users')->insert($param);
    }
}
