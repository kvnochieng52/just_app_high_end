<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('property_types')->insert([
            [
                'property_type_name' => 'Appartment',
                'property_type_slug' => 'appartment',
                'property_type_description' => '',
                'property_type_color_code' => '',
                'property_type_is_active' => '1',
                'order' => '1',

            ],
            [
                'property_type_name' => 'Office Space',
                'property_type_slug' => 'office-space',
                'property_type_description' => '',
                'property_type_color_code' => '',
                'property_type_is_active' => '1',
                'order' => '1',

            ],

            [
                'property_type_name' => 'Open Space',
                'property_type_slug' => 'open-space',
                'property_type_description' => '',
                'property_type_color_code' => '',
                'property_type_is_active' => '1',
                'order' => '1',

            ],
            [
                'property_type_name' => 'Shop',
                'property_type_slug' => 'shop',
                'property_type_description' => '',
                'property_type_color_code' => '',
                'property_type_is_active' => '1',
                'order' => '1',

            ],

            [
                'property_type_name' => 'Warehouse',
                'property_type_slug' => 'warehouse',
                'property_type_description' => '',
                'property_type_color_code' => '',
                'property_type_is_active' => '1',
                'order' => '1',

            ],





        ]);
    }
}
