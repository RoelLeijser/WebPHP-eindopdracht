<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class LocalizationTest extends DuskTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');
    }


    public function test_set_english_language(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);

            $browser->loginAs($user)->visit('/')
                ->click('@lang-gb')
                ->assertPathIs('/')
                ->assertSee('Advertisements');
        });
    }

    public function test_set_dutch_language(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);

            $browser->loginAs($user)->visit('/')
                ->click('@lang-nl')
                ->assertPathIs('/')
                ->assertSee('Advertenties');
        });
    }
}
