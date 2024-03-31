<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class ReviewTest extends DuskTestCase
{
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->artisan('migrate:fresh');
        $this->artisan('db:seed');
    }


    public function test_show_reviews_advertisements(): void
    {

    }

    public function test_show_user_advertisements(): void
    {

    }

    public function test_create_review_fails(): void 
    {

    }

    public function test_create_review_succeeds(): void 
    {

    }

    public function test_destroy_review(): void 
    {

    }

    public function test_update_review_fails(): void 
    {

    }

    
    public function test_update_review_succeeds(): void 
    {

    }



    /**
     * A Dusk test example.
     */
    public function testExample(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                    ->assertSee('Laravel');
        });
    }
}
