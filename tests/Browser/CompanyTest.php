<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Company;
use App\Models\User;
use App\Models\Layout;

class CompanyTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');
    }

    public function test_create_company(): void
    {

        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $user->assignRole('zakelijke adverteerder');
            $user->givePermissionTo(['contract accepted']);

            $browser->loginAs($user)->visit('/company/create')
                ->type('@name', 'Siren Music Shop')
                ->press('@create')
                ->assertSee('Introduction text');
                
        });

    }

    public function test_user_has_no_permission(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $user->assignRole('zakelijke adverteerder');

            $company = Company::find(1);
            $company->update(['user_id' => 1]);
            
            $browser->loginAs($user)->visit('/company/1')
                ->assertSee('Unfortunatly, you cannot update the settings for your own page, the contract is still pending');
                
        });
    }

    public function test_user_show_company_settings_forbidden_access(): void
    {

        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $user->syncRoles(['basis gebruiker']);

            $browser->loginAs($user)->visit('/company/1')
                ->assertSee('403');
                
        });
    }

    public function test_update_settings(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $user->assignRole('zakelijke adverteerder');
            $user->givePermissionTo(['contract accepted']);
    
            $company = Company::find(1);
            $company->update(['user_id' => 1]);

            $browser->loginAs($user)->visit('company/1/edit')
                ->type('@slug', 'siren-music-shop')
                ->type('@font', 'Arial')
                ->type('@introduction', 'My music shop will put sailors in a charm')
                ->type('@primary_color', '#a9c4dc')
                ->type('@secondary_color', '#d199c2')
                ->press('@update')
                ->assertSee('siren-music-shop')
                ->assertSee('My music shop will put sailors in a charm');
                
        });
    }

    public function test_update_settings_fails_on_slug(): void
    {      
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $user->assignRole('zakelijke adverteerder');
            $user->givePermissionTo(['contract accepted']);
    
            $company = Company::find(1);
            $company->update(['user_id' => 1]);

            $browser->loginAs($user)->visit('company/1/edit')
                ->type('@slug', 'sirew2ee3%%1n-music)-shop')
                ->type('@font', 'Arial')
                ->type('@introduction', 'My music shop will put sailors in a charm')
                ->type('@primary_color', '#a9c4dc')
                ->type('@secondary_color', '#d199c2')
                ->press('@update')
                ->assertSee('The slug format is invalid.')
                ->assertPathIs('/company/1/edit'); 
        });

    }

    public function test_update_page_layout(): void
    {      
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $user->assignRole('zakelijke adverteerder');
            $user->givePermissionTo(['contract accepted']);
    
            $company = Company::find(1);
            $company->update(['user_id' => 1]);

            $layout = Layout::find(1);
            $layout->update(['company_id' => 1, 'first_component' => 'introduction']);

            $browser->loginAs($user)->visit('/company/1/layout')
                ->select('@first', 'reviews')
                ->select('@second', 'introduction')
                ->select('@third', 'adverts')
                ->press('@update')
                ->assertSee('My Company Settings')
                ->assertPathIs('/company/1'); 
        });

        
    }

    public function test_update_page_layout_fails_same_values(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $user->assignRole('zakelijke adverteerder');
            $user->givePermissionTo(['contract accepted']);
    
            $company = Company::find(1);
            $company->update(['user_id' => 1]);

            $layout = Layout::find(1);
            $layout->update(['company_id' => 1, 'first_component' => 'introduction']);

            $browser->loginAs($user)->visit('/company/1/layout')
                ->select('@first', 'reviews')
                ->select('@second', 'introduction')
                ->select('@third', 'introduction')
                ->press('@update')
                ->assertSee('Edit page layout')
                ->assertSee('The component must be unique')
                ->assertPathIs('/company/1/layout'); 
        });
    }

    public function test_company_landing_page(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $user->assignRole('zakelijke adverteerder');
            $user->givePermissionTo(['contract accepted']);
    
            $company = Company::find(1);
            $company->update(['user_id' => 1, 'introduction_text' => 'This is my new text']);
    
            $layout = Layout::find(1);
            $layout->update(['company_id' => 1, 'first_component' => 'introduction']);

            $browser->loginAs($user)->visit('/'.$company->slug)
                ->assertSee($company->name)
                ->assertSee('This is my new text');
        });
    } 
}
