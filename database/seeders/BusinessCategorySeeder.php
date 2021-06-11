<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusinessCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('business_categories')->insert([
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
