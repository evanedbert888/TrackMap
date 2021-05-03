<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('employees')->insert([
            [
                'name'=>'Sulaiman',
                'age'=>28,
                'birth_date'=>Carbon::create('1993','11','02'),
                'sex'=>'male',
                'email'=>'sulaiman132@gmail.com',
                'role'=>'salesman',
                'motto'=>'Your Motto',
                'address'=>'Jl Waru Gg Waru kari No.E6',
                'password'=>Hash::make('salesmamSulaiman')
            ],
            [
                'name'=>'Erwin',
                'age'=>25,
                'birth_date'=>Carbon::create('1996','06','15'),
                'sex'=>'male',
                'email'=>'erwinyanto@gmail.com',
                'role'=>'courier',
                'motto'=>'Your Motto',
                'address'=>'Jl sarimi Gg Karuya No.F1',
                'password'=>Hash::make('salesmamErwin')
            ],
            [
                'name'=>'Yeni',
                'age'=>26,
                'birth_date'=>Carbon::create('1995','05','12'),
                'sex'=>'female',
                'email'=>'yeniyo345@gmail.com',
                'role'=>'salesman',
                'motto'=>'Your Motto',
                'address'=>'Jl sarimi Gg Puncaksari No.A2',
                'password'=>Hash::make('salesmamYeni')
            ],
            [
                'name'=>'Hanif',
                'age'=>25,
                'birth_date'=>Carbon::create('1996','08','11'),
                'sex'=>'male',
                'email'=>'hanifkumal@gmail.com',
                'role'=>'salesman',
                'motto'=>'Your Motto',
                'address'=>'Jl merdeka Gg ratu jaya No.C2',
                'password'=>Hash::make('salesmamHanif')
            ],
            [
                'name'=>'William',
                'age'=>29,
                'birth_date'=>Carbon::create('1992','11','27'),
                'sex'=>'male',
                'email'=>'william777@gmail.com',
                'role'=>'courier',
                'motto'=>'Your Motto',
                'address'=>'Jl pelangi Gg tujuh No.B7',
                'password'=>Hash::make('salesmamWilliam')
            ]
        ]);
    }
}
