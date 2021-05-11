<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert([
            [
                'company_name'=>"Rumah Sakit Mitra Medika",
                'business'=>'Health',
                'address'=>'Jl. Slt. Abdurrahman No.25, Sungai Bangkong, Kec. Pontianak Kota, Kota Pontianak, Kalimantan Barat 78113',
                'email'=>'mitramedia@mm.co.id',
                'latitude'=>'-0.0366396002310127',
                'longitude'=>'109.32923988720279',
                'description'=>'Rumah Sakit Mitra Medika'
            ],
            [
                'company_name'=>"Avatar Games",
                'business'=>'Entertainment',
                'address'=>'Jl. P. Natakusuma No.2, Sungai Bangkong, Pontianak, Kota Pontianak, Kalimantan Barat 78113',
                'email'=>'avatergames@gmail.com',
                'latitude'=>'-0.038607713657094235',
                'longitude'=>'109.31536715838614',
                'description'=>'Avatar Games'
            ],
            [
                'company_name'=>"Rumah Shabby & Roof Top Cafe",
                'business'=>'Entertainment',
                'address'=>'Jl. P. Natakusuma, Sungai Bangkong, Kec. Pontianak Kota, Kota Pontianak, Kalimantan Barat 78116',
                'email'=>'shabbynrooftop@gmail.com',
                'latitude'=>'-0.03504574089089836',
                'longitude'=>'109.31781333313462',
                'description'=>'Rumah Shabby & Roof Top Cafe'
            ],
            [
                'company_name'=>"Aming Coffee 2",
                'business'=>'Food & Drinks',
                'address'=>'Jl. Slt. Abdurrahman No.25, Sungai Bangkong, Kec. Pontianak Kota, Kota Pontianak, Kalimantan Barat 78113',
                'email'=>'amingcoffee2@gmail.com',
                'latitude'=>'-0.05355410187953165',
                'longitude'=>'109.30573647586529',
                'description'=>'Aming Coffee 2'
            ],
            [
                'company_name'=>"BNI KK M.Yamin",
                'business'=>'Financial & Utility',
                'address'=>'Jl. Prof. M.Yamin, Sungai Bangkong, Kec. Pontianak Kota, Kota Pontianak, Kalimantan Barat 78115',
                'email'=>'bnimyamin@bank.co.id',
                'latitude'=>'-0.05863977283944164',
                'longitude'=>'109.307524407686294',
                'description'=>'BNI KK M.Yamin'
            ],
            [
                'company_name'=>"Hotel Merpati",
                'business'=>'Tourism',
                'address'=>'Jl. Imam Bonjol No.111, Benua Melayu Laut, Kec. Pontianak Sel., Kota Pontianak, Kalimantan Barat 78243',
                'email'=>'merpatihotel@merpati.co.id',
                'latitude'=>'-0.04629945926496524',
                'longitude'=>',109.35517009007846',
                'description'=>'Hotel Merpati'
            ],
            [
                'company_name'=>"Amazon Coffee",
                'business'=>'Food & Drinks',
                'address'=>'Jl. Reformasi No.8A, Bansir Laut, Kec. Pontianak Tenggara, Kota Pontianak, Kalimantan Barat 78113',
                'email'=>'amzoncoffee@gmail.com',
                'latitude'=>'-0.0626526847682696',
                'longitude'=>'109.33795898542238',
                'description'=>'Amazon Coffee'
            ],
            [
                'company_name'=>"Mr Cakes And Bakery",
                'business'=>'Food & Drinks',
                'address'=>'Gg. Sukma 8, Sungai Jawi, Kec. Pontianak Kota, Kota Pontianak, Kalimantan Barat 78113',
                'email'=>'mrcakesnbakery@bakery.co.id',
                'latitude'=>'-0.040094832322255504',
                'longitude'=>'109.30594911202155',
                'description'=>'Mr Cakes And Bakery'
            ],
            [
                'company_name'=>"You Computer",
                'business'=>'Technology',
                'address'=>'Jl. Prof. M.Yamin No.20, Kota Baru, Kec. Pontianak Sel., Kota Pontianak, Kalimantan Barat 78116',
                'email'=>'youcomputer@gmail.com',
                'latitude'=>'-0.05113046196673768',
                'longitude'=>'109.31503372225269',
                'description'=>'You Computer'
            ],
            [
                'company_name'=>"Cakra Arena GOR bulutangkis",
                'business'=>'Sports',
                'address'=>'Gg. Karya Baru 6 No.34, Parit Tokaya, Kec. Pontianak Sel., Kota Pontianak, Kalimantan Barat 78115',
                'email'=>'cakraarena@gmail.com',
                'latitude'=>'-0.056096937593034774',
                'longitude'=>'109.33573400320833',
                'description'=>'Cakra Arena GOR bulutangkis'
            ],
            [
                'company_name'=>"Laboratorium Klinik Prodia",
                'business'=>'Health',
                'address'=>'Jl. Jenderal Ahmad Yani No.6C, Benua Melayu Darat, Kec. Pontianak Sel., Kota Pontianak, Kalimantan Barat 78113',
                'email'=>'prodialb@gmail.com',
                'latitude'=>'-0.036707814397645935',
                'longitude'=>'109.33509829295529',
                'description'=>'Laboratorium Klinik Prodia'
            ],
            [
                'company_name'=>"PT Leo Perdana Mandiri",
                'business'=>'Technology',
                'address'=>'Jl. nusa indah baru no A8 - A9, Tengah, Kec. Pontianak Kota, Kota Pontianak, Kalimantan Barat 78243',
                'email'=>'leoperdanamandiri@gmail.com',
                'latitude'=>'-0.02408421472162801',
                'longitude'=>'109.33804476774064',
                'description'=>'PT Leo Perdana Mandiri'
            ],
            [
                'company_name'=>"Pizza Hut Delivery - PHD Indonesia",
                'business'=>'Food & Drinks',
                'address'=>'Jl. Prof. M.Yamin No.1 Kel, Kota Baru, Kec. Pontianak Sel., Kota Pontianak, Kalimantan Barat 78121',
                'email'=>'pizzahut@pdh.co.id',
                'latitude'=>'-0.05040203300332711',
                'longitude'=>'109.31641940329007',
                'description'=>'Pizza Hut Delivery - PHD Indonesia'
            ],
            [
                'company_name'=>"Kolam Renang Delta Kapuas",
                'business'=>'Sports',
                'address'=>'Jl. Nipah Kuning Dalam, Pal Lima, Kec. Pontianak Bar., Kota Pontianak, Kalimantan Barat 78244',
                'email'=>'deltakapuas@gmail.com',
                'latitude'=>'-0.01713917637230021',
                'longitude'=>'109.29353785910433',
                'description'=>'Kolam Renang Delta Kapuas'
            ],
            [
                'company_name'=>"Yellow Ponsel Pancasila",
                'business'=>'Technology',
                'address'=>'Jl. Gusti Hamzah No.3, Sungai Bangkong, Kec. Pontianak Kota, Kota Pontianak, Kalimantan Barat 78244',
                'email'=>'yellowponsel@gmail.com',
                'latitude'=>'-0.021172746888143863',
                'longitude'=>'109.31805486487787',
                'description'=>'Yellow Ponsel Pancasila'
            ]
        ]);
    }
}
