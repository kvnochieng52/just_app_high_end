<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubRegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sub_regions')->insert([
            [
                'town_id' => '1',
                'sub_region_name' => 'Mombasa sub region 1',
                'is_active' => '1',
            ],
            [
                'town_id' => '1',
                'sub_region_name' => 'Mombasa sub region 2',
                'is_active' => '1',
            ],

            [
                'town_id' => '2',
                'sub_region_name' => 'Kwale sub region 1',
                'is_active' => '1',
            ],
            [
                'town_id' => '2',
                'sub_region_name' => 'Kwale sub region 2',
                'is_active' => '1',
            ],

            [
                'town_id' => '4',
                'sub_region_name' => 'Buru Buru',
                'is_active' => '1',
            ],
            [
                'town_id' => '4',
                'sub_region_name' => 'Kasarani',
                'is_active' => '1',
            ],

            [
                'town_id' => '4',
                'sub_region_name' => 'Utawala',
                'is_active' => '1',
            ],

        ]);
    }
}
