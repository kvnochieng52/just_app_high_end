<?php

namespace Tests\Browser;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class HomeSearchProductTest extends DuskTestCase
{


    /**
     * A test to see if the search form on the homepage works !
     *
     * @return void
     */
    public function testSearch()
    {
        $this->browse(function (Browser $browser) {

            $product = \App\Models\Product::factory()->create();

            $browser->visit('/')
                ->assertSee('Shop with Ease!')
                ->select('@category', $product->category_id)
                ->type('@keywords', $product->title)
                ->click('@submitSearch');
            $browser
                ->waitForText('Search Results')
                ->assertSee('1 Records found');
        });
    }

    public function testSearchWithoutCategory()
    {
        $this->browse(function (Browser $browser) {

            $product = \App\Models\Product::factory()->create();

            $browser->visit('/')
                ->assertSee('Shop with Ease!')
                ->type('@keywords', $product->title)
                ->click('@submitSearch');
            $browser
                ->waitForText('The category field is required.')
                ->assertSee('The category field is required.');
        });
    }
}
