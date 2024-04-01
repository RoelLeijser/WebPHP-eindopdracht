<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\Advertisement;
use App\Models\User;

class AdvertisementsTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');
    }

    public function test_filter_advertisements_title(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('403');
                
        });
    }

    public function test_filter_advertisements_type(): void
    {

    }

    public function test_filter_advertisements_delivery(): void
    {

    }

    public function test_filter_advertisements_price(): void
    {

    }

    public function test_sort_advertisements_price(): void
    {

    }

    public function test_index_advertisements(): void
    {

    }

    public function test_show_advertisements(): void
    {

    }

    public function test_create_advertisement_fails_image(): void
    {

    }

    public function test_create_advertisement_fails_required(): void
    {

    }

    public function test_create_advertisement_succeeds(): void
    {

    }

    public function test_create_advertisement_delete(): void
    {

    }

    public function test_create_advertisement_update_fails(): void
    {

    }

    public function test_create_advertisement_update_succeeds(): void
    {

    }

    public function test_create_advertisement_no_favorites(): void
    {

    }

    public function test_create_advertisement_favorites(): void
    {

    }

    public function test_create_advertisement_bid(): void
    {

    }
}
