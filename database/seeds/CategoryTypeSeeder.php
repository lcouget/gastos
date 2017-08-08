<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class CategoryTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category_types')->insert([
           'category_type' => 'ingreso',
           'active' => 1,
        ]);

        DB::table('category_types')->insert([
           'category_type' => 'gasto',
           'active' => 1,
        ]);
    }
}
