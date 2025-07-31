<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefMedicationDispenseUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ref_medication_dispense_units')->truncate();
        $csvFile = fopen(base_path('database/data/ref_medication_dispense_units.csv'), 'r');
        $firstline = true;
        while (($data = fgetcsv($csvFile, 2000, ',')) !== false) {
            if (! $firstline) {
                DB::table('ref_medication_dispense_units')->insert([
                    'id' => $data['0'],
                    'form' => $data['1'],
                    'quantity' => $data['2'],
                ]);
            }
            $firstline = false;
        }
        fclose($csvFile);
    }
}
