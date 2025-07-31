<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefConditionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('ref_conditions')->truncate();
       
        $csvFile = fopen(base_path('database/data/ref_conditions.csv'), 'r');
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ',')) !== false) {
            if (! $firstline) {
                DB::table('ref_conditions')->insert([
                    'condition_uuid' => $data['1'],
                    'condition' => $data['2'],
                ]);
            }
            $firstline = false;
        }
        fclose($csvFile);
    }
}
