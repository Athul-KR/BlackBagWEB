<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefOnboardingStepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ref_onboarding_steps')->truncate();
        DB::table('ref_onboarding_steps')->insert([
       
            ['step' => 'Business Details','slug' => 'business-details'],
            ['step' => 'Working Hours','slug' => 'working-hours'],
            ['step' => 'Payment Processing','slug' => 'payment-processing'],
            ['step' => 'Patient Subscriptions','slug' => 'patient-subscriptions'],
            ['step' => 'Choose Addons','slug' => 'choose-addons']

        ]);
    }
}
