<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'image_name' => 'cat.jpg',
            'image_ext' => 'jpg',
            'image_type' => 'image/jpeg',
        ];
        DB::table('images')->insert($param);
     
        $param = [
            'image_name' => 'dog.jpg',
            'image_ext' => 'jpg',
            'image_type' => 'image/jpeg',
        ];
        DB::table('images')->insert($param);
    }
}
