<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusinessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('businesses')->insert([
            [
                'name'=>'Health'
            ],
            [
                'name'=>'Technology'
            ],
            [
                'name'=>'Entertainment'
            ],
            [
                'name'=>'Food & Drinks'
            ],
            [
                'name'=>'Sports'
            ],
            [
                'name'=>'Financial & Utility'
            ],
            [
                'name'=>'Tourism'
            ]
        ]);
    }
}
