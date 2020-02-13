<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class SmokeTests extends DuskTestCase
{
    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function testLoads()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee(env("APP_NAME"));
        });
    }

    public function testStatsLoads()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(route("home"))
                ->assertSee(env("APP_NAME"))
                ->assertSee("Average loot per tier")
                ->assertSee("Abyss activity");
        });
    }

    public function testMineLoads()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(route("home_mine"))
                ->assertSee(env("APP_NAME"))
                ->assertSee("Please log in to access this page");
        });
    }
    public function testMyRunsLoads()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit(route("runs_mine"))
                ->assertSee(env("APP_NAME"))
                ->assertSee("Please log in to list your runs ");
        });
    }
}
