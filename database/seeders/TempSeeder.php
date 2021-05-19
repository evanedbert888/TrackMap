<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TempSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('temps')->insert([
           [
               'user_id' => 1,
               'employee_id' => 1,
               'company_id' => 1
           ],
           [
               'user_id' => 1,
               'employee_id' => 2,
               'company_id' => 10
           ],
           [
               'user_id' => 2,
               'employee_id' => 3,
               'company_id' => 4
           ],
           [
               'user_id' => 2,
               'employee_id' => 4,
               'company_id' => 9
           ],
           [
               'user_id' => 2,
               'employee_id' => 5,
               'company_id' => 13
           ],
           [
               'user_id' => 1,
               'employee_id' => 3,
               'company_id' => 8
           ],
           [
               'user_id' => 2,
               'employee_id' => 1,
               'company_id' => 11
           ]
        ]);
    }
}
