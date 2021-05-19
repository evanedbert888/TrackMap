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
                'role'=>'admin',
                'birth_date'=>Carbon::create('1994','04','27'),
                'address'=>'Jalan Purwakarto Gg Suri No D5'
            ],
            [
                'name'=>'Rina',
                'email'=>'Rina135@gmail.com',
                'password'=>Hash::make('trythisnow'),
                'age'=>29,
                'sex'=>'female',
                'role'=>'admin',
                'birth_date'=>Carbon::create('1992','07','20'),
                'address'=>'Jalan Merpati Gg Pustaka No A2'
            ],
            [
                'name'=>'Sulaiman',
                'email'=>'sulaiman132@gmail.com',
                'password'=>Hash::make('salesmanSulaiman'),
                'age'=>28,
                'sex'=>'male',
                'role'=>'employee',
                'birth_date'=>Carbon::create('1993','11','02'),
                'address'=>'Jl Waru Gg Waru kari No.E6',
            ],
            [
                'name'=>'Erwin',
                'email'=>'erwinyanto@gmail.com',
                'password'=>Hash::make('salesmanErwin'),
                'age'=>25,
                'sex'=>'male',
                'role'=>'employee',
                'birth_date'=>Carbon::create('1996','06','15'),
                'address'=>'Jl sarimi Gg Karuya No.F1',
            ],
            [
                'name'=>'Yeni',
                'email'=>'yeniyo345@gmail.com',
                'password'=>Hash::make('salesmanYeni'),
                'age'=>26,
                'sex'=>'female',
                'role'=>'employee',
                'birth_date'=>Carbon::create('1995','05','12'),
                'address'=>'Jl sarimi Gg Puncaksari No.A2',
            ],
            [
                'name'=>'Hanif',
                'email'=>'hanifkumal@gmail.com',
                'password'=>Hash::make('salesmanHanif'),
                'age'=>25,
                'sex'=>'male',
                'role'=>'employee',
                'birth_date'=>Carbon::create('1996','08','11'),
                'address'=>'Jl merdeka Gg ratu jaya No.C2',
            ],
            [
                'name'=>'William',
                'email'=>'william777@gmail.com',
                'password'=>Hash::make('salesmanWilliam'),
                'age'=>29,
                'sex'=>'male',
                'role'=>'employee',
                'birth_date'=>Carbon::create('1992','11','27'),
                'address'=>'Jl pelangi Gg tujuh No.B7',
            ]
        ]);
    }
}
