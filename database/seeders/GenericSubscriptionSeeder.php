<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GenericSubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('generic_subscriptions')->truncate();
        $subscriptions = [
            [
                'generic_subscription_uuid' => 'd252c1457',
                'plan_name' => 'Essential care',
                'description' => 'Essential features for small clinics',
                'monthly_amount' => 49.99,
                'annual_amount' => 499.99,
                'plan_icon_id' => '2',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'generic_subscription_uuid' => '8a6bbb4vt',
                'plan_name' => 'Premium care',
                'description' => 'Advanced features for growing clinics',
                'monthly_amount' => 99.99,
                'annual_amount' => 999.99,
                'plan_icon_id' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            // [
            //     'generic_subscription_uuid' => 'bdaa36aw' ,
            //     'plan_name' => 'Enterprise Plan',
            //     'description' => 'Complete solution for large clinics',
            //     'monthly_amount' => 199.99,
            //     'annual_amount' => 1999.99,
            //     'created_at' => Carbon::now(),
            //     'updated_at' => Carbon::now()
            // ],
           
        ];

        foreach ($subscriptions as $subscription) {
            DB::table('generic_subscriptions')->insert($subscription);
        }
    }
} 