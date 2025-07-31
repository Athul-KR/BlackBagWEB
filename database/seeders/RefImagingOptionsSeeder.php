<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefImagingOptionsSeeder extends Seeder
{
    public function run()
    {
        DB::table('ref_imaging_options')->truncate();
        DB::table('ref_imaging_options')->insert([
            ['id' => 1, 'name' => 'Left',  'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Right', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'External',   'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Bilateral',   'created_at' => now(), 'updated_at' => now()]
           
        ]);
    }
}
