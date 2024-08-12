<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertyFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('property_features')->insert([
            [
                'feature_name' => 'AirCon',
                'property_feature_group_id' => '1',
                'is_active' => '1',
                'order' => '1',

            ],
            [
                'feature_name' => 'Alarm',
                'property_feature_group_id' => '1',
                'is_active' => '1',
                'order' => '1',

            ],
            [
                'feature_name' => 'Backup Generator',
                'property_feature_group_id' => '1',
                'is_active' => '1',
                'order' => '1',

            ],

            [
                'feature_name' => 'Master Ensuite',
                'property_feature_group_id' => '1',
                'is_active' => '1',
                'order' => '1',

            ],

            [
                'feature_name' => 'Fiber Internet',
                'property_feature_group_id' => '1',
                'is_active' => '1',
                'order' => '1',

            ],

            [
                'feature_name' => 'Open Kitchen',
                'property_feature_group_id' => '1',
                'is_active' => '1',
                'order' => '1',

            ],





            [
                'feature_name' => 'Balcony',
                'property_feature_group_id' => '2',
                'is_active' => '1',
                'order' => '1',

            ],
            [
                'feature_name' => 'BBQ',
                'property_feature_group_id' => '2',
                'is_active' => '1',
                'order' => '1',

            ],
            [
                'feature_name' => 'CCTV',
                'property_feature_group_id' => '2',
                'is_active' => '1',
                'order' => '1',

            ],

            [
                'feature_name' => 'Borehole',
                'property_feature_group_id' => '2',
                'is_active' => '1',
                'order' => '1',

            ],

            [
                'feature_name' => 'Swimming Pool',
                'property_feature_group_id' => '2',
                'is_active' => '1',
                'order' => '1',

            ],

            [
                'feature_name' => 'Parking',
                'property_feature_group_id' => '2',
                'is_active' => '1',
                'order' => '1',

            ],







            [
                'feature_name' => 'Bus Stop',
                'property_feature_group_id' => '3',
                'is_active' => '1',
                'order' => '1',

            ],
            [
                'feature_name' => 'Shopping Mall/Super Market',
                'property_feature_group_id' => '3',
                'is_active' => '1',
                'order' => '1',

            ],
            [
                'feature_name' => 'School',
                'property_feature_group_id' => '3',
                'is_active' => '1',
                'order' => '1',

            ],

            [
                'feature_name' => 'Sea View',
                'property_feature_group_id' => '3',
                'is_active' => '1',
                'order' => '1',

            ],

            [
                'feature_name' => 'Swimming Pool',
                'property_feature_group_id' => '3',
                'is_active' => '1',
                'order' => '1',

            ],

            [
                'feature_name' => 'Golf Course',
                'property_feature_group_id' => '3',
                'is_active' => '1',
                'order' => '1',

            ],


        ]);
    }
}
