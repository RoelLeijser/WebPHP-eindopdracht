<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Advertisement;
use App\Models\Review;

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
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $user->assignRole('zakelijke adverteerder');

            $advertisement = Advertisement::findOrFail(2);
            $advertisement->update(['type' => 'rental']);
            $advertisement->reviews()->attach(1);

            
            $browser->loginAs($user)->visit('/advertisements/2')
                ->assertPresent('@review');
        });
    }

    public function test_show__reviews_user_advertisements(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $user->assignRole('zakelijke adverteerder');

            $user = User::findOrFail(3);
            $user->reviews()->attach(2);
            
            $browser->loginAs($user)->visit('/advertisements/3/user')
                ->assertPresent('@review');
        });
    }

    public function test_create_review_fails(): void 
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $user->assignRole('zakelijke adverteerder');

            $advert = Advertisement::find(2);
            $advert->update(['type' => 'rental']);
            
            $browser->loginAs($user)->visit('/advertisements/2')
                ->assertPresent('@create_review')
                ->type('@text', '')
                ->press('@create')
                ->assertSee('The review field is required.');
        });
    }

    public function test_create_review_succeeds(): void 
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $user->assignRole('zakelijke adverteerder');

            $advert = Advertisement::find(2);
            $advert->update(['type' => 'rental']);
            
            $browser->loginAs($user)->visit('/advertisements/2')
                ->assertPresent('@create_review')
                ->type('@text', 'My review')
                ->press('@create')
                ->assertPresent('@review')
                ->assertSee('My review');
        });
    }

    public function test_destroy_review(): void 
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $user->assignRole('zakelijke adverteerder');

            $review = Review::create([
                'review' => "My review",
                'published_at' => now(),
                'user_id' => $user->id,
            ]);

            $advertisement = Advertisement::findOrFail(2);
            $advertisement->update(['type' => 'rental']);
            $advertisement->reviews()->attach($review->id);

            
            $browser->loginAs($user)->visit('/advertisements/2')
                ->assertSee('My review')
                ->press('@delete')
                ->assertDontSee('My review');
        });
    }

    public function test_update_review_fails_required(): void 
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $user->assignRole('zakelijke adverteerder');

            $review = Review::create([
                'review' => "My review",
                'published_at' => now(),
                'user_id' => $user->id,
            ]);

            $advertisement = Advertisement::findOrFail(2);
            $advertisement->update(['type' => 'rental']);
            $advertisement->reviews()->attach($review->id);

            
            $browser->loginAs($user)->visit('/advertisements/2')
                ->assertSee('My review')
                ->press('@update')
                ->assertPathIs('/review/'.$review->id.'/edit') 
                ->type('@text', '')
                ->press('@update')
                ->assertSee('The review field is required.');
        });
    }

    
    public function test_update_review_succeeds(): void 
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $user->assignRole('zakelijke adverteerder');

            $review = Review::create([
                'review' => "My review",
                'published_at' => now(),
                'user_id' => $user->id,
            ]);

            $advertisement = Advertisement::findOrFail(2);
            $advertisement->update(['type' => 'rental']);
            $advertisement->reviews()->attach($review->id);

            $browser->loginAs($user)->visit('/advertisements/2')
                ->assertSee('My review')
                ->press('@update')
                ->assertPathIs('/review/'.$review->id.'/edit') 
                ->type('@text', 'My new Review')
                ->press('@update')
                ->assertSee('My new Review');
        });
    }
}
