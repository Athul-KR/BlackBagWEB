<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefTemperature extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ref_temperature')->truncate();
        DB::table('ref_temperature')->insert([

            ['temperature_uuid' => '8872bb12d2', 'type' => 'Celsius', 'unit' =>'c' ,'created_at' => now()],
            ['temperature_uuid' => '94f9438f6b', 'type' => 'Farenheit', 'unit' =>'f' ,'created_at' => now()],

        ]);
    }
}
