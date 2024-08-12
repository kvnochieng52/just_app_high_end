<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'category_name' => 'Furniture',
                'category_slug' => 'furniture',
                'order' => '1',
                'order' => '1',
                'visible' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'category_name' => 'Electronics',
                'category_slug' => 'electronics',
                'order' => '2',
                'visible' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'category_name' => 'Cars',
                'category_slug' => 'cars',
                'order' => '3',
                'visible' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'category_name' => 'Property',
                'category_slug' => 'property',
                'order' => '4',
                'visible' => '1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
    }
}
