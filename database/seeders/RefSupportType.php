<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefSupportType extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ref_support_types')->truncate();
        DB::table('ref_support_types')->insert([

            ['id' => '1', 'type' => 'Bug', 'created_at' => now()],
            ['id' => '2', 'type' => 'Support', 'created_at' => now()],

        ]);
    }
}
