<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
class Brandseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('brands')->insert([
            'id'=>1,
            'name' =>'samsung',
            'product_id' => 1
        ]);
        DB::table('brands')->insert([
            'id'=>2,
            'name' =>'vivo',
            'product_id' => 1
        ]);
        DB::table('brands')->insert([
            'id'=>3,
            'name' =>'redmi',
            'product_id' => 1
        ]);

        DB::table('brands')->insert([
            'id'=>4,
            'name' =>'gucci',
            'product_id' => 2
        ]);
        
        DB::table('brands')->insert([
            'id'=>5,
            'name' =>'rolex',
            'product_id' => 2
        ]);
        DB::table('brands')->insert([
            'id'=>6,
            'name' =>'swatch',
            'product_id' => 2
        ]);
        DB::table('brands')->insert([
            'id'=>7,
            'name' =>'dell',
            'product_id' => 3
        ]);
        DB::table('brands')->insert([
            'id'=>8,
            'name' =>'asus',
            'product_id' => 3
        ]);
        DB::table('brands')->insert([
            'id'=>9,
            'name' =>'panasonic',
            'product_id' => 3
        ]);
        
    }
}
