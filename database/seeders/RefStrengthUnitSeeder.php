<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefStrengthUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ref_strength_units')->truncate();
        DB::table('ref_strength_units')->insert([
            ['id' => '1', 'strength_unit' => 'mg', 'created_at' => now()],
            ['id' => '2', 'strength_unit' => 'mcg', 'created_at' => now()],
        ]);
    }
}
