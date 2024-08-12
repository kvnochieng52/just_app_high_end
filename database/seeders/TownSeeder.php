<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TownSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('towns')->insert([
            [
                'town_name' => 'Mombasa',
                'is_active' => '1',
            ],

            [
                'town_name' => 'Kwale',
                'is_active' => '1',
            ],

            [
                'town_name' => 'Kisumu',
                'is_active' => '1',
            ],

            [
                'town_name' => 'Nairobi',
                'is_active' => '1',
            ],

        ]);
    }
}
