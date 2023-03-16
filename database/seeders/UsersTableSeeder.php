<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

//factoryで使用
//use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
       $param = [
           'name' => 'test',
           'email' => 'test@test.com',
           'password' => '$2y$10$FNWNl5lXgLP9I9xIJ1tR4OGhZz3jPbTDDHcdB5IVSSOv1Fs4RP5ay',
       ];
       DB::table('users')->insert($param);
       */

       //factory使用時
       //User::factory()->count(5)->create();
    }
}
