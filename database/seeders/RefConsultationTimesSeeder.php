<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefConsultationTimesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ref_consultation_times')->truncate();
        
        $times = [
            '10 mins',
            '15 mins',
            '20 mins',
            '30 mins',
            '45 mins',
            '60 mins',
            'Custom'
        ];

        foreach ($times as $time) {
            DB::table('ref_consultation_times')->insert([
                'consultation_time' => $time,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
} 