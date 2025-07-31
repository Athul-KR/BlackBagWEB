<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AddonsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('addons')->truncate();
        DB::table('addons')->insert([

            ['id' => '1', 'addon_uuid' => 'cdce6fdc34',  'title' => 'ePrescribe', 'description' => 'ePrescribe', 'amount' => '79.00','one_time_setup_amount' => '250.00'],
          
        ]);
    }
}
