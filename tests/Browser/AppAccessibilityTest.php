<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class AppAccessibilityTest extends DuskTestCase
{
    /**
     *A test to check if the app is accessible and not breaking
     *
     * @return void
     */
    public function testAppAccessibility()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->pause(2000)
                ->screenshot('home-page')
                ->assertSee('Shopper');
        });
    }
}
