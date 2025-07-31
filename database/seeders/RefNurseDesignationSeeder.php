<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefNurseDesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ref_nurses_designations')->truncate();
        DB::table('ref_nurses_designations')->insert([
            ['id' => '1', 'nurse_designation_uuid' => '243hfty5', 'designation' => 'Registered Nurse (RN)'],
            ['id' => '2', 'nurse_designation_uuid' => '8e71gra3', 'designation' => 'Nurse Practitioner (NP)'],
            ['id' => '3', 'nurse_designation_uuid' => 'd4196r49', 'designation' => 'Certified Nurse (CN)'],

        ]);
    }
}
