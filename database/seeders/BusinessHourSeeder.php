<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusinessHourSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clinicId = session('user.clinicID');
        DB::table('bussiness_hours')->truncate();
        DB::table('bussinesshours_times')->truncate();
        DB::table('bussiness_hours')->insert([

            ['id' => '1', 'bussinesshour_uuid' => 'aea30109', 'day' => 'Sunday', 'clinic_id' => $clinicId],
            ['id' => '2', 'bussinesshour_uuid' => '48h96r49', 'day' => 'Monday', 'clinic_id' => $clinicId],
            ['id' => '3', 'bussinesshour_uuid' => '45t4y7r7', 'day' => 'Tuesday', 'clinic_id' => $clinicId],
            ['id' => '4', 'bussinesshour_uuid' => '48h967g9', 'day' => 'Wednesday', 'clinic_id' => $clinicId],
            ['id' => '5', 'bussinesshour_uuid' => '48h9677i', 'day' => 'Thursday', 'clinic_id' => $clinicId],
            ['id' => '6', 'bussinesshour_uuid' => '48h96je7', 'day' => 'Friday', 'clinic_id' => $clinicId],
            ['id' => '7', 'bussinesshour_uuid' => '48h96775', 'day' => 'Saturday', 'clinic_id' => $clinicId],

        ]);
        DB::table('bussinesshours_times')->insert([

            ['id' => '1', 'bussinesshour_time_uuid' => 'rea30109', 'bussiness_hour_id' => '1'],
            ['id' => '2', 'bussinesshour_time_uuid' => 'g8h96r49', 'bussiness_hour_id' => '2'],
            ['id' => '3', 'bussinesshour_time_uuid' => 'h5t4y7r7', 'bussiness_hour_id' => '3'],
            ['id' => '4', 'bussinesshour_time_uuid' => 'h8h967g9', 'bussiness_hour_id' => '4'],
            ['id' => '5', 'bussinesshour_time_uuid' => 'k8h9677i', 'bussiness_hour_id' => '5'],
            ['id' => '6', 'bussinesshour_time_uuid' => 'b8h96je7', 'bussiness_hour_id' => '6'],
            ['id' => '7', 'bussinesshour_time_uuid' => 'a8h96775', 'bussiness_hour_id' => '7'],

        ]);
    }
}
