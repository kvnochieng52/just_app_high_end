<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertyConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('property_conditions')->insert([
            [
                'condition_name' => 'Fairly Used',
                'is_active' => '1',
                'order' => '1',

            ],
            [
                'condition_name' => 'Newly Built',
                'is_active' => '1',
                'order' => '1',

            ],

            [
                'condition_name' => 'Old',
                'is_active' => '1',
                'order' => '1',

            ],
        ]);
    }
}
