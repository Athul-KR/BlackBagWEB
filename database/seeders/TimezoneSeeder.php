<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimezoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ref_timezones')->truncate();

        DB::table('ref_timezones')->insert([
            [
                'timezone' => 'Western European Time (WET)',
                'timezone_format' => 'Europe/Lisbon',
            ],
            [
                'timezone' => 'British Summer Time (BST)',
                'timezone_format' => 'Europe/London',
            ],
            [
                'timezone' => 'Central Time (CT)',
                'timezone_format' => 'America/Chicago',
            ],
            [
                'timezone' => 'Central European Summer Time (CEST)',
                'timezone_format' => 'Europe/Paris',
            ],
            [
                'timezone' => 'Central European Time (CET)',
                'timezone_format' => 'Europe/Berlin',
            ],
            [
                'timezone' => 'Eastern Time (ET)',
                'timezone_format' => 'America/New_York',
            ],
            [
                'timezone' => 'Eastern European Time (EET)',
                'timezone_format' => 'Europe/Bucharest',
            ],
            [
                'timezone' => 'Greenwich Mean Time (GMT)',
                'timezone_format' => 'UTC',
            ],
            [
                'timezone' => 'Gulf Standard Time (GST)',
                'timezone_format' => 'Asia/Dubai',
            ],
            [
                'timezone' => 'Hawaii-Aleutian Standard Time (HAST)',
                'timezone_format' => 'Pacific/Honolulu',
            ],
            [
                'timezone' => 'Hawaii Standard Time (HST)',
                'timezone_format' => 'Pacific/Honolulu',
            ],
            [
                'timezone' => 'Indian Standard Time (IST)',
                'timezone_format' => 'Asia/Kolkata',
               
            ],
            [
                'timezone' => 'Mountain Time (MT)',
                'timezone_format' => 'America/Denver',
            ],
            [
                'timezone' => 'Pacific Time (PT)',
                'timezone_format' => 'America/Los_Angeles',
            ],
            [
                'timezone' => 'South African Standard Time (SAST)',
                'timezone_format' => 'Africa/Johannesburg',
            ],
            [
                'timezone' => 'Singapore Time (SGT)',
                'timezone_format' => 'Asia/Singapore',
            ],
            [
                'timezone' => 'Eastern European Standard Time  (EEST)',
                'timezone_format' => 'europe/helsinki',
            ],
            
        ]);
    }
}

