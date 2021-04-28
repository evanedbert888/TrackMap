<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name'=>'Bambang',
                'email'=>'Bambang12@gmail.com',
                'password'=>Hash::make('trythisnow'),
                'age'=>27,
                'sex'=>'male',
                'birth_date'=>Carbon::create('1994','04','27'),
                'address'=>'Jalan Purwakarto Gg Suri No D5'
            ],
            [
                'name'=>'Rina',
                'email'=>'Rina135@gmail.com',
                'password'=>Hash::make('trythisnow'),
                'age'=>29,
                'sex'=>'female',
                'birth_date'=>Carbon::create('1992','07','20'),
                'address'=>'Jalan Merpati Gg Pustaka No A2'
            ]
        ]);
    }
}
