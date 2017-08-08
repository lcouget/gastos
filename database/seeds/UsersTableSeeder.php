<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
           'name' => 'Ornela Ganduglia',
           'email' => 'ornela.ganduglia@gmail.com',
           'password' => bcrypt('orne1234%'),
        ]);

        DB::table('users')->insert([
           'name' => 'Luciano Couget',
           'email' => 'luciano.couget@gmail.com',
           'password' => bcrypt('eDfV5%6&'),
        ]);
    }
}
