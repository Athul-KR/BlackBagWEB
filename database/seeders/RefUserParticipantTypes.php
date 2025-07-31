<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefUserParticipantTypes extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ref_participant_types')->truncate();
        DB::table('ref_participant_types')->insert([

            ['id' => '1', 'type' => 'Client User'],
            ['id' => '2', 'type' => 'Patient'],

        ]);
    }
}
