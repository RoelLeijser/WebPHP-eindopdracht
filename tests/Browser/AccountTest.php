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
                ->assertPathIs('/account');
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

    public function test_show_account(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $user->assignRole('admin');

            $browser->loginAs($user)->visit('/account')
                ->assertPathIs('/account')
                ->press('@name')
                ->assertSee('Account information');
        });
    }

    public function test_upload_contract_fails_required(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $user->assignRole('admin');

            $account = User::find(2);
            $account->syncRoles('zakelijke adverteerder');

            $browser->loginAs($user)->visit('/account/2/edit')
                ->assertPathIs('/account/2/edit')
                ->press('@upload')
                ->assertSee('The contract field is required.')
                ->assertPathIs('/account/2/edit');
        });
    }

    public function test_upload_contract_fails_mime(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $user->assignRole('admin');

            $account = User::find(2);
            $account->syncRoles('zakelijke adverteerder');

            $file = __DIR__ . '/../test_files/test.jpg';

            $browser->loginAs($user)->visit('/account/2/edit')
                ->assertPathIs('/account/2/edit')
                ->attach('contract', $file)
                ->press('@upload')
                ->assertSee('The contract must be a file of type: pdf.')
                ->assertPathIs('/account/2/edit');
        });
    }

    public function test_upload_contract_fails_not_modified(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $user->assignRole('admin');

            $account = User::find(2);
            $account->syncRoles('zakelijke adverteerder');

            $file = public_path('storage\contracts\contract-'.$account->id.'.pdf');

            $browser->loginAs($user)->visit('/account/2/edit')
                ->assertPathIs('/account/2/edit')
                ->press('@export')
                ->attach('contract', $file)
                ->press('@upload')
                ->assertSee('The contract is not modified the original contract is the same as the 1 in file system')
                ->assertPathIs('/account/2/edit');
        });
    }

    public function test_upload_contract_succeeds(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $user->assignRole('admin');

            $account = User::find(2);
            $account->syncRoles('zakelijke adverteerder');

            $file = __DIR__ . '/../test_files/contract-2.pdf';

            $browser->loginAs($user)->visit('/account/2/edit')
                ->assertPathIs('/account/2/edit')
                ->press('@export')
                ->attach('contract', $file)
                ->press('@upload')
                ->assertPathIs('/account');
        });
    }
}
