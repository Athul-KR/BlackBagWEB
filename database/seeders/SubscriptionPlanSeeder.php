<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subscription_plans')->truncate();
        DB::table('subscription_plans')->insert([

            ['id' => '1', 'plan_uuid' => '2432cfsd',  'plan_name' => 'Pay As You Go', 'amount' => '0.00', 'tenure_type_id' => '1','sort_order' => '1'],
          
        ]);
    }
}
