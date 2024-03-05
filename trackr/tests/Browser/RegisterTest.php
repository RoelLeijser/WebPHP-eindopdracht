<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class RegisterTest extends DuskTestCase
{

    use DatabaseMigrations;

    public function setUp(): void
    {
        //parent::setUp();

        //$this->artisan('db:seed');
    }

    /**
     * A Dusk test example.
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Laracasts');
        });
    }

    public function test_register_succeed(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('@name', 'John Doe')
                ->type('@email', 'test@mail.com')
                ->type('@role', 'basis gebruiker')
                ->type('@password', 'wachtwoord123')
                ->type('@password_confirmation', 'wachtwoord123')
                ->press('@create')
                -assertPathIs('/dashboard');
        });
    }
}
