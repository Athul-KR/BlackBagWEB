<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefMedicinesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('ref_medicines')->truncate();
       
        $csvFile = fopen(base_path('database/data/ref_medicines.csv'), 'r');
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ',')) !== false) {
            if (! $firstline) {
                DB::table('ref_medicines')->insert([
                    'medicine_uuid' => $data['1'],
                    'medicine' => $data['2'],
                ]);
            }
            $firstline = false;
        }
        fclose($csvFile);
    }
}
