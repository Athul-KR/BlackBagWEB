<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefFcFoldersTypes extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ref_fc_folders')->truncate();
        DB::table('ref_fc_folders')->insert([

            ['id' => '1', 'folder_name' => 'Lab Results'],
            ['id' => '2', 'folder_name' => 'X-rays'],
            ['id' => '3', 'folder_name' => 'Treatment Plans'],

        ]);
    }
}
