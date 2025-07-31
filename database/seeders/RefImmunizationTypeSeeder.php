<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefImmunizationTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('ref_immunization_types')->truncate();
        DB::table('ref_immunization_types')->insert([
            ['id' => '1', 'immunization_type_uuid' => 'c83436ef05', 'immunization_type' => 'DTap/Tdap (Diphtheria, Tetanus, Pertussis)'],
            ['id' => '2', 'immunization_type_uuid' => 'd8fe9cfe0d', 'immunization_type' => 'Hepatitis A'],
            ['id' => '3', 'immunization_type_uuid' => '73d03f4c36', 'immunization_type' => 'Hepatitis B'],
            ['id' => '4', 'immunization_type_uuid' => '4987a85194', 'immunization_type' => 'Hib'],
            ['id' => '5', 'immunization_type_uuid' => '9ad7927dda', 'immunization_type' => 'HPV (Human PapillomaVirus)'],
            ['id' => '6', 'immunization_type_uuid' => '02bd5d3c67', 'immunization_type' => 'Influenza'],
            ['id' => '7', 'immunization_type_uuid' => '6ac353d683', 'immunization_type' => 'IPV'],
            ['id' => '8', 'immunization_type_uuid' => '0eaf34a917', 'immunization_type' => 'MCV4'],
            ['id' => '9', 'immunization_type_uuid' => '8104a4a050', 'immunization_type' => 'MMR (Measles, Mumps, Rubella)'],
            ['id' => '10', 'immunization_type_uuid' => 'aecbe9aee9', 'immunization_type' => 'PCV'],
            ['id' => '11', 'immunization_type_uuid' => '12065025c5', 'immunization_type' => 'Pneumovax (Pneumonia)'],
            ['id' => '12', 'immunization_type_uuid' => 'f8a2b656ec', 'immunization_type' => 'Polio'],
            ['id' => '13', 'immunization_type_uuid' => '215a35db7b', 'immunization_type' => 'RV (Rotavirus)'],
            ['id' => '14', 'immunization_type_uuid' => '55057afdf2', 'immunization_type' => 'Varicella (Chickenpox)'],
            ['id' => '15', 'immunization_type_uuid' => 'cv09dy63rf', 'immunization_type' => 'Covid 19'],
        ]);
    }
}
