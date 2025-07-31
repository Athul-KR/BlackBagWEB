<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefSourceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('ref_source_types')->truncate();
        DB::table('ref_source_types')->insert([
            ['id' => '1', 'source_type_uuid' => 'st57326ef1', 'source_type' => 'Intake Form', 'created_at' => now()],
            ['id' => '2', 'source_type_uuid' => 'st57326ef2', 'source_type' => 'Patient', 'created_at' => now()],
            ['id' => '3', 'source_type_uuid' => 'st57326ef3', 'source_type' => 'Clinic', 'created_at' => now()],
            ['id' => '4', 'source_type_uuid' => '4r57326ef3', 'source_type' => 'RPM', 'created_at' => now()],
            ['id' => '5', 'source_type_uuid' => '1890826eg6', 'source_type' => 'eprescribe', 'created_at' => now()],
        ]);
    }
}
