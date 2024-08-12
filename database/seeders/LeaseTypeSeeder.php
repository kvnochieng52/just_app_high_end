<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LeaseTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('lease_types')->insert([
            [
                'lease_type_name' => 'Rent',
                'is_active' => '1',
                'order' => '1',

            ],
            [
                'lease_type_name' => 'Sale',
                'is_active' => '1',
                'order' => '1',

            ],

        ]);
    }
}
