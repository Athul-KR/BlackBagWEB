<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RefRelationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('ref_relations')->truncate();
        DB::table('ref_relations')->insert([
            ['id' => '1', 'relation_uuid' => 'm1th45', 'relation' => 'Mother', 'internal_field' => '0'],
            ['id' => '2', 'relation_uuid' => 'fth98r', 'relation' => 'Father', 'internal_field' => '0'],
            ['id' => '3', 'relation_uuid' => 'br098t', 'relation' => 'Brother', 'internal_field' => '0'],
            ['id' => '4', 'relation_uuid' => 'si34sr', 'relation' => 'Daughter', 'internal_field' => '0'],
            ['id' => '5', 'relation_uuid' => 'dau76r', 'relation' => 'Brother', 'internal_field' => '0'],
            ['id' => '6', 'relation_uuid' => 's1o2n3', 'relation' => 'Son', 'internal_field' => '0'],
            ['id' => '7', 'relation_uuid' => 'mat6gm', 'relation' => 'Maternal Grandmother', 'internal_field' => '0'],
            ['id' => '8', 'relation_uuid' => 'mat0gf', 'relation' => 'Maternal Grandfather', 'internal_field' => '0'],
            ['id' => '9', 'relation_uuid' => 'pat1gm', 'relation' => 'Paternal Grandmother', 'internal_field' => '0'],
            ['id' => '10', 'relation_uuid' => 'pat4gf', 'relation' => 'Paternal Grandfather', 'internal_field' => '0'],
            ['id' => '11', 'relation_uuid' => 'maau90', 'relation' => 'Maternal Aunt', 'internal_field' => '0'],
            ['id' => '12', 'relation_uuid' => 'maun45', 'relation' => 'Maternal Uncle', 'internal_field' => '0'],
            ['id' => '13', 'relation_uuid' => 'paau71', 'relation' => 'Paternal Aunt', 'internal_field' => '0'],
            ['id' => '14', 'relation_uuid' => 'paun23', 'relation' => 'Paternal Uncle', 'internal_field' => '0'],
            ['id' => '15', 'relation_uuid' => 'mt121n', 'relation' => 'Maternal Cousin', 'internal_field' => '0'],
            ['id' => '16', 'relation_uuid' => 'pa899n', 'relation' => 'Paternal Cousin', 'internal_field' => '0'],
            ['id' => '17', 'relation_uuid' => 'mitwe1', 'relation' => 'Spouse', 'internal_field' => '0'],
            ['id' => '18', 'relation_uuid' => 'o1t2r3', 'relation' => 'Other', 'internal_field' => '0'],
            ['id' => '19', 'relation_uuid' => 'self34', 'relation' => 'Self', 'internal_field' => '1'],
        ]);
    }
}
