<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PropertyFurnishSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('property_furnishes')->insert([
            [
                'furnish_name' => 'Unfurnished',
                'is_active' => '1',
                'order' => '1',

            ],
            [
                'condition_name' => 'Semi-Furnished',
                'is_active' => '1',
                'order' => '1',

            ],
            [
                'condition_name' => 'Furnished',
                'is_active' => '1',
                'order' => '1',

            ],

            [
                'condition_name' => 'Furnishing',
                'is_active' => '1',
                'order' => '1',

            ],
        ]);
    }
}
