<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefUserTypes extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ref_user_types')->truncate();
        DB::table('ref_user_types')->insert([

            ['id' => '1', 'user_type_uuid' => 'aea3010928', 'user_type' => 'Admin'],
            ['id' => '2', 'user_type_uuid' => '48h96r49', 'user_type' => 'Provider'],
            ['id' => '3', 'user_type_uuid' => '45t4y7r7', 'user_type' => 'Medical Assistant / Scribe'],
            ['id' => '4', 'user_type_uuid' => '48h967709', 'user_type' => 'Patient'],

        ]);
    }
}
