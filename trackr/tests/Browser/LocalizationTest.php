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

            $browser->loginAs($user)->visit('/dashboard')
                ->click('@lang-gb')
                ->assertPathIs('/dashboard')
                ->assertSee('You\'re logged in!');
        });
    }

    public function test_set_dutch_language(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);

            $browser->loginAs($user)->visit('/dashboard')
                ->click('@lang-nl')
                ->assertPathIs('/dashboard')
                ->assertSee('Je bent ingelogd!');
        });
    }
}
