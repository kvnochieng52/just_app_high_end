<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertyFeatureGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('property_feature_groups')->insert([
            [
                'feature_group_name' => 'Internal features',
                'is_active' => '1',
                'order' => '1',

            ],
            [
                'condition_name' => 'External features',
                'is_active' => '1',
                'order' => '1',

            ],
            [
                'condition_name' => 'Nearby',
                'is_active' => '1',
                'order' => '1',

            ],

        ]);
    }
}
