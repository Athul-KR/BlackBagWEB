<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefPlanIconsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('ref_plan_icons')->truncate();
        DB::table('ref_plan_icons')->insert([
            ['id' => '1', 'icon_path' => 'Badge.png', 'name' => 'Badge'],
            ['id' => '2', 'icon_path' => 'Basic.png', 'name' => 'Basic'],
            ['id' => '3', 'icon_path' => 'Elite.png', 'name' => 'Elite'],
            ['id' => '4', 'icon_path' => 'Gift.png', 'name' => 'Gift'],
            ['id' => '5', 'icon_path' => 'Money.png', 'name' => 'Money'],
            ['id' => '6', 'icon_path' => 'Premium.png', 'name' => 'Premium'],
            ['id' => '7', 'icon_path' => 'Secure.png', 'name' => 'Secure'],
            ['id' => '8', 'icon_path' => 'Standard.png', 'name' => 'Standard'],
            ['id' => '9', 'icon_path' => 'Stars.png', 'name' => 'Stars'],
            ['id' => '10', 'icon_path' => 'Supreme.png', 'name' => 'Supreme']
           

        ]);
    }
}
