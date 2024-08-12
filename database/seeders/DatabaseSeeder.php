<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call(RolesTableSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(LeaseTypeSeeder::class);
        $this->call(PropertyConditionSeeder::class);
        $this->call(PropertyFeatureGroupSeeder::class);
        $this->call(PropertyFeatureSeeder::class);
        $this->call(PropertyFurnishSeeder::class);
        $this->call(PropertyTypeSeeder::class);
        $this->call(SubRegionSeeder::class);
        $this->call(TownSeeder::class);
    }
}
