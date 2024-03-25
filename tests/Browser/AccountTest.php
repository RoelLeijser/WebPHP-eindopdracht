<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class AccountTest extends DuskTestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');
    }

    public function test_view_accounts(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $user->assignRole('admin');

            $browser->loginAs($user)->visit('/account')
                ->assertPathIs('/account')
                ->assertSee('ACTIONS')
                ->assertSee('NAME')
                ->assertSee('Accounts');
        });
    }

    public function test_search_zero_results(): void
    {

        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $user->assignRole('admin');

            $browser->loginAs($user)->visit('/account')
                ->assertPathIs('/account')
                ->type('@search_field', 'fhvffefhfvfdjvfvfvfvfvfvf')
                ->press('@search')
                ->assertSee('No accounts where found');
        });
    }

    public function test_search_results(): void
    {

        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $user->assignRole('admin');

            $browser->loginAs($user)->visit('/account')
                ->assertPathIs('/account')
                ->type('@search_field', 'example.org')
                ->press('@search')
                ->assertDontSee('example.net');
        });
    }

    public function test_role_filter_results(): void
    {

        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $user->assignRole('admin');

            $browser->loginAs($user)->visit('/account')
                ->assertPathIs('/account')
                ->select('@select', 'admin')
                ->assertSee('Admin');
        });
    }

    public function test_delete_accounts(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $user->assignRole('admin');

            $browser->loginAs($user)->visit('/account')
                ->assertPathIs('/account')
                ->press('@delete')
                ->assertSee('9 results');
        });
    }

    public function test_edit_accounts_show_view(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $user->assignRole('admin');

            $browser->loginAs($user)->visit('/account/1/edit')
                ->assertPathIs('/account/1/edit')
                ->assertSee('Edit account');
        });
    }

    public function test_edit_accounts_update_account(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(2);
            $user->assignRole('admin');

            $account = User::find(1);
            $account->assignRole('particuliere adverteerder');

            $browser->loginAs($user)->visit('/account/1/edit')
                ->assertPathIs('/account/1/edit')
                ->select('@select', 'admin')
                ->press('@update')
                ->assertSee('Accounts')
                ->assertPathIs('/account');
        });
    }
}
