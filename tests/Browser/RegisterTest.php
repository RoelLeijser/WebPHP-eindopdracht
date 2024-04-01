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
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');
    }

    public function test_register_succeed(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('@name', 'John Doe')
                ->type('@email', 'test@mail.com')
                ->select('@role', 'basis gebruiker')
                ->type('@password', 'wachtwoord123')
                ->type('@password_confirmation', 'wachtwoord123')
                ->press('@create')
                ->assertPathIs('/');
        });
    }

    public function test_register_fails_on_password(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('@name', 'John Doe')
                ->type('@email', 'test@mail.com')
                ->select('@role', 'basis gebruiker')
                ->type('@password', 'wachtwoord456')
                ->type('@password_confirmation', 'wachtwoord123')
                ->press('@create')
                ->assertPathIs('/register')
                ->assertSee('The password confirmation does not match.');
        });
    }

    public function test_register_fails_on_role(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/register')
                ->type('@name', 'John Doe')
                ->type('@email', 'test@mail.com')
                ->select('@role', 'balbalas')
                ->type('@password', 'wachtwoord456')
                ->type('@password_confirmation', 'wachttwoord456')
                ->press('@create')
                ->assertPathIs('/register');
        });
    }


}
