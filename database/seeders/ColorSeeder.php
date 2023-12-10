<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('colors')->insert([
            'id'=>1,
            'name'=>'black'
        ]);
        DB::table('colors')->insert([
            'id'=>2,
            'name'=>'white'
        ]);
        DB::table('colors')->insert([
            'id'=>3,
            'name'=>'golden'
        ]);
        DB::table('colors')->insert([
            'id'=>4,
            'name'=>'gray'
        ]);
    }
}
