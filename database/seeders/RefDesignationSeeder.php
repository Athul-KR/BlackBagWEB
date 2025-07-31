<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefDesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('ref_designations')->truncate();
        DB::table('ref_designations')->insert([
            ['id' => '1', 'designation_uuid' => '243hjdy5', 'type' => 'doctor', 'name' => 'MD'],
            ['id' => '2', 'designation_uuid' => '8e710aa3', 'type' => 'doctor', 'name' => 'DO'],
            ['id' => '3', 'designation_uuid' => 'd4199e49', 'type' => 'doctor', 'name' => 'GP'],
            ['id' => '4', 'designation_uuid' => '9e4f9f67', 'type' => 'doctor', 'name' => 'Pediatrician']
           

        ]);
    }
}
