<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppointmentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('appointment_types')->truncate();
        DB::table('appointment_types')->insert([
            // ['id' => '1', 'appointment_type_uuid' => '243hfty5', 'appointment_name' => 'Consultation'],
            // ['id' => '2', 'appointment_type_uuid' => '8e71gra3', 'appointment_name' => 'Checkup'],
            // ['id' => '3', 'appointment_type_uuid' => 'd4196hd9', 'appointment_name' => 'Hospitalize'],
            ['id' => '1', 'appointment_type_uuid' => 'd41oeyu0', 'appointment_name' => 'Online Appointment'],
            ['id' => '2', 'appointment_type_uuid' => '48h96r49', 'appointment_name' => 'In-person Appointment'],

        ]);
    }
}
