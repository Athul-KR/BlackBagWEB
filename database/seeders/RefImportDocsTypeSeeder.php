<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class RefImportDocsTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ref_import_docs_types')->truncate();
        DB::table('ref_import_docs_types')->insert([
            ['id' => '1', 'import_type' => 'Doctor'],
            ['id' => '2', 'import_type' => 'Nurse'],
          

        ]);
    }
}
