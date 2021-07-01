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
                'user_id' => 3,
//                'section_id' => 2,
            ],
            [
                'user_id' => 4,
//                'section_id' => 1,
            ],
            [
                'user_id' => 5,
//                'section_id' => 1,
            ],
            [
                'user_id' => 6,
//                'section_id' => 2,
            ],
            [
                'user_id' => 7,
//                'section_id' => 1,
            ],
        ]);
    }
}
