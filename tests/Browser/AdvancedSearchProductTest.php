<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AdvancedSearchProductTest extends DuskTestCase
{
    /**
     * Test on the advanced Search on the category Listings
     *
     * @return void
     */
    public function testSearch()
    {
        $this->browse(function (Browser $browser) {

            $product = \App\Models\Product::factory()->create();

            $browser->visit('/category/furniture')
                ->assertSee('ADVANCED SEARCH')
                ->select('@category', $product->category_id)
                ->type('@keywords', $product->title)
                ->type('@price_from', $product->price)
                ->type('@price_to', 8000)
                ->click('@submitSearch');
            $browser
                ->waitForText('Search Results')
                ->assertSee('1 Records found');
        });
    }
}
