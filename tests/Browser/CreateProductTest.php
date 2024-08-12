<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Faker\Factory as Faker;


class CreateProductTest extends DuskTestCase
{

    /**
     * Test To Submit a new Product
     *
     * @return void
     */
    public function testCreateProduct()
    {

        $user = \App\Models\User::factory()->create();

        $this->browse(function (Browser $browser) use ($user) {

            $faker = Faker::create();
            $browser->loginAs($user)
                ->visit('/dashboard/create')
                ->assertSee('New Product')
                ->type('@title', $faker->name)
                ->select('@category', $faker->numberBetween($min = 1, $max = 4))
                ->type('@email', $faker->email())
                ->type('@telephone', $faker->phoneNumber())
                ->script([
                    "document.querySelector('#date_online').value = '17-11-2022'",
                    "document.querySelector('#date_offline').value = '31-12-2023'",
                ]);
            $browser->type('@price', $faker->numberBetween($min = 500, $max = 8000))
                ->type('@description', $faker->paragraph($nb = 10))
                ->attach('image', base_path('public/images/car.jpg'))
                ->click('@submitForm');
            $browser
                ->waitForText('Product Created Successfully !')
                ->assertSee('Product Created Successfully !')
                ->logout();
        });
    }
}
