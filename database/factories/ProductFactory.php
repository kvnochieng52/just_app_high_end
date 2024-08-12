<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $start_date = Carbon::now();
        return [

            'title' => $this->faker->name,
            'slug' => $this->faker->unique()->slug,
            'description' => $this->faker->paragraph($nb = 10),
            'date_online' => $start_date,
            'date_offline' => $start_date->addMonths($this->faker->numberBetween($min = 2, $max = 10)),
            'price' => $this->faker->numberBetween($min = 500, $max = 8000),
            'currency' => env('CURRENCY'),
            'mobile' => $this->faker->phoneNumber(),
            'email' => $this->faker->email(),
            'category_id' => $this->faker->numberBetween($min = 1, $max = 4),
            'image' => 'car.jpg',
            'created_by' => 1,
            'updated_by' => 1,
        ];
    }
}
