<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefInvoiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ref_invoice_types')->truncate();
        DB::table('ref_invoice_types')->insert([
            ['id' => '1', 'invoice_type' => 'ePrescribe'],
            ['id' => '2', 'invoice_type' => 'Subscription'],
            ['id' => '3', 'invoice_type' => 'RPM Order'],
        ]);
    }
}
