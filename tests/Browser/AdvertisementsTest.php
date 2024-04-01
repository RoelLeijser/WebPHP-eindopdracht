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

    /**
     * @group advertisements
     */
    public function test_upload_csv_file(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $user->assignRole('admin');

            $filePath = __DIR__ . '/../test_files/csv/advertisements_working.csv';

            $browser->loginAs($user)->visit('/')
                ->press('@dropdown_button')
                ->assertSee('Import CSV')
                ->press('@import_csv_file')
                ->attach('file', $filePath)
                ->press('@upload');
        });

        $this->assertDatabaseHas('advertisements', [
            'title' => 'Lederen jas maat 52 XL',
            'description' => 'lichte lederen jas. ECHT LEER!. Word niet meer gedragen.',
            'price' => '25',
            'image' => 'https://images.marktplaats.com/api/v1/listing-mp-p/images/20/2048ce5d-10d2-4226-967a-d5572538c98d?rule=ecg_mp_eps$_84',
            'type' => 'auction',
            'delivery' => 'pickup_shipping',
        ]);
    }

    /**
     * @group advertisements
     */
    public function test_upload_csv_file_with_empty_columns()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $user->assignRole('admin');

            $filePath = __DIR__ . '/../test_files/csv/advertisements_empty_columns.csv';

            $browser->loginAs($user)->visit('/')
                ->press('@dropdown_button')
                ->assertSee('Import CSV')
                ->press('@import_csv_file')
                ->attach('file', $filePath)
                ->press('@upload')
                ->assertSee('The CSV file doesn\'t have the correct amount of columns.');
        });

        $this->assertDatabaseMissing('advertisements', [
            'title' => 'Lederen jas maat 52 XL',
            'description' => 'lichte lederen jas. ECHT LEER!. Word niet meer gedragen.',
            'price' => '25',
            'image' => 'https://images.marktplaats.com/api/v1/listing-mp-p/images/20/2048ce5d-10d2-4226-967a-d5572538c98d?rule=ecg_mp_eps$_84',
            'type' => 'auction',
            'delivery' => 'pickup_shipping',
        ]);
    }


    /**
     * @group advertisements
     */
    public function test_upload_csv_file_with_invalid_columns()
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $user->assignRole('admin');

            $browser->loginAs($user)->visit('/')
                ->press('@dropdown_button')
                ->assertSee('Import CSV')
                ->press('@import_csv_file')
                ->attach('file', __DIR__ . '/../test_files/csv/advertisements_invalid_delivery.csv')
                ->press('@upload')
                ->assertSee('Delivery must be pickup, shipping or pickup_shipping.')

                ->attach('file', __DIR__ . '/../test_files/csv/advertisements_invalid_type.csv')
                ->press('@upload')
                ->assertSee('Type must be auction, sell or rental.');
        });

        $this->assertDatabaseMissing('advertisements', [
            'title' => 'Lederen jas maat 52 XL',
            'description' => 'lichte lederen jas. ECHT LEER!. Word niet meer gedragen.',
            'price' => '25',
            'image' => 'https://images.marktplaats.com/api/v1/listing-mp-p/images/20/2048ce5d-10d2-4226-967a-d5572538c98d?rule=ecg_mp_eps$_84',
            'type' => 'auction',
            'delivery' => 'pickup_shipping',
        ]);
    }

    /**
     * @group advertisements
     */
    public function test_filter_advertisements_title(): void
    {
        $this->browse(function (Browser $browser) {
            $advert = Advertisement::find(1);
            $advert->update(['title' => 'Lego Star Wars Death Star']);

            $browser->visit('/')
                ->type('@title', 'Lego Star Wars')
                ->press('@filter')
                ->assertSee('Lego Star Wars Death Star');
        });
    }

    /**
     * @group advertisements
     */
    public function test_filter_advertisements_type(): void
    {
        $this->browse(function (Browser $browser) {
            $advert = Advertisement::find(1);
            $advert->update(['title' => 'Lego Star Wars Death Star', 'type' => 'sell']);

            $browser->visit('/')
                ->select('@type', 'sell')
                ->press('@filter')
                ->assertSee('Lego Star Wars Death Star');
        });
    }

    /**
     * @group advertisements
     */
    public function test_filter_advertisements_delivery(): void
    {
        $this->browse(function (Browser $browser) {
            $advert = Advertisement::find(20);
            $advert->update(['title' => 'Lego Star Wars Death Star', 'delivery' => 'pickup']);

            $browser->visit('/')
                ->select('@delivery', 'pickup')
                ->press('@filter')
                ->assertSee('Lego Star Wars Death Star');
        });
    }

    /**
     * @group advertisements
     */
    public function test_filter_advertisements_price(): void
    {
        $this->browse(function (Browser $browser) {
            $advert = Advertisement::find(1);
            $advert->update(['title' => 'Lego Star Wars Death Star', 'price' => 475]);

            $browser->visit('/')
                ->type('@price_min', '0')
                ->type('@price_max', '300')
                ->press('@filter')
                ->assertDontSee('Lego Star Wars Death Star');
        });
    }

    /**
     * @group advertisements
     */
    public function test_sort_advertisements_price(): void
    {
        $this->browse(function (Browser $browser) {
            $advert = Advertisement::find(1);
            $advert->update(['title' => 'Lego Star Wars Death Star', 'price' => 475]);

            $browser->visit('/')
                ->select('@sort', 'price')
                ->assertDontSee('Lego Star Wars Death Star');
        });
    }

    /**
     * @group advertisements
     */
    public function test_index_advertisements(): void
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/')
                ->assertSee('Advertisements')
                ->assertSee('Title')
                ->assertSee('Sort');
        });
    }

    /**
     * @group advertisements
     */
    public function test_show_advertisements(): void
    {
        $this->browse(function (Browser $browser) {
            $advert = Advertisement::find(1);
            $advert->update(['title' => 'Lego Star Wars Death Star']);

            $browser->visit('advertisements/1')
                ->assertSee('Lego Star Wars Death Star');
        });
    }

    /**
     * @group advertisements
     */
    public function test_create_advertisement_fails_image(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $user->syncRoles('zakelijke adverteerder');

            $file = __DIR__ . '/../test_files/contract-2.pdf';

            $browser->loginAs($user)->visit('advertisements/create')
                ->type('@title', 'Houten kast')
                ->attach('@file', $file)
                ->type('@description', 'Mijn beschrijving')
                ->type('@price', 20)
                ->radio('@type', 'Sell')->click()
                ->select('@delivery', 'Shipping')
                ->press('@create')
                ->assertSee('The image must be an image.');
        });
    }

    /**
     * @group advertisements
     */
    public function test_create_advertisement_fails_required(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $user->syncRoles('zakelijke adverteerder');

            $file = __DIR__ . '/../test_files/test.jpg';

            $browser->loginAs($user)->visit('advertisements/create')
                ->type('@title', '')
                ->attach('@file', $file)
                ->type('@description', 'Mijn beschrijving')
                ->type('@price', 20)
                ->radio('@type', 'Sell')->click()
                ->select('@delivery', 'Shipping')
                ->press('@create')
                ->assertSee('The title field is required.');
        });
    }

    /**
     * @group advertisements
     */
    public function test_create_advertisement_fails_limit(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $user->syncRoles('zakelijke adverteerder');

            $advert1 = Advertisement::find(1);
            $advert1->update(['seller_id' => 1, 'type' => 'sell']);

            $advert2 = Advertisement::find(2);
            $advert2->update(['seller_id' => 1, 'type' => 'sell']);

            $advert3 = Advertisement::find(3);
            $advert3->update(['seller_id' => 1, 'type' => 'sell']);

            $advert4 = Advertisement::find(4);
            $advert4->update(['seller_id' => 1, 'type' => 'sell']);

            $file = __DIR__ . '/../test_files/test.jpg';

            $browser->loginAs($user)->visit('advertisements/create')
                ->type('@title', 'Houten Hut')
                ->attach('@file', $file)
                ->type('@description', 'Mijn beschrijving')
                ->type('@price', 20)
                ->radio('@type', 'Sell')->click()
                ->select('@delivery', 'Shipping')
                ->press('@create')
                ->assertDontSee('Houten Hut');
        });
    }

    /**
     * @group advertisements
     */
    public function test_create_advertisement_succeeds(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $user->syncRoles('zakelijke adverteerder');

            $file = __DIR__ . '/../test_files/test.jpg';

            $browser->loginAs($user)->visit('advertisements/create')
                ->type('@title', 'Houten kast')
                ->attach('@file', $file)
                ->type('@description', 'Mijn beschrijving')
                ->type('@price', 20)
                ->radio('@type', 'Sell')->click()
                ->select('@delivery', 'Shipping')
                ->press('@create')
                ->assertSee('Houten kast')
                ->assertPathIs('/');
        });
    }

    /**
     * @group advertisements
     */
    public function test_create_advertisement_delete(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $user->syncRoles('zakelijke adverteerder');

            $advert = Advertisement::find(1);
            $advert->update(['title' => 'Lego Star Wars Death Star', 'seller_id' => 1]);

            $browser->loginAs($user)->visit('advertisements/1')
                ->assertSee('Lego Star Wars Death Star')
                ->press('@delete')
                ->acceptDialog()
                ->assertPathIs('/')
                ->assertDontSee('Lego Star Wars Death Star');
        });
    }

    /**
     * @group advertisements
     */
    public function test_advertisement_update_fails(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $user->syncRoles('zakelijke adverteerder');

            $advert = Advertisement::find(1);
            $advert->update(['title' => 'Lego Star Wars Death Star', 'seller_id' => 1]);

            $browser->loginAs($user)->visit('advertisements/1/edit')
                ->type('@title', '')
                ->press('@update')
                ->assertPathIs('/advertisements/1/edit')
                ->assertSee('The title field is required.');
        });
    }

    /**
     * @group advertisements
     */
    public function test_advertisement_update_succeeds(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $user->syncRoles('zakelijke adverteerder');

            $advert = Advertisement::find(1);
            $advert->update(['title' => 'Lego Star Wars Death Star', 'seller_id' => 1]);

            $browser->loginAs($user)->visit('advertisements/1/edit')
                ->type('@title', 'Lego Star Wars Naboo Fighter')
                ->press('@update')
                ->assertPathIs('/')
                ->type('@title', 'Naboo')
                ->press('@filter')
                ->assertSee('Lego Star Wars Naboo Fighter');
        });
    }

    /**
     * @group advertisements
     */
    public function test_create_advertisement_no_favorites(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $user->syncRoles('zakelijke adverteerder');

            $browser->loginAs($user)->visit('favorites')
                ->assertSee('You don\'t have any favorite advertisements.');
        });
    }

    /**
     * @group advertisements
     */
    public function test_create_advertisement_favorites(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $user->syncRoles('zakelijke adverteerder');

            $advert = Advertisement::find(1);
            $advert->update(['title' => 'Lego Star Wars Death Star']);

            $browser->loginAs($user)
                ->visit('advertisements/1')
                ->press('@favorite')
                ->visit('favorites')
                ->assertSee('Lego Star Wars Death Star')
                ->assertPathIs('/favorites');
        });
    }

    /**
     * @group advertisements
     */
    public function test_create_advertisement_bid(): void
    {
        $this->browse(function (Browser $browser) {
            $user = User::find(1);
            $user->syncRoles('zakelijke adverteerder');

            $advert = Advertisement::where('type', 'auction')->first();
            $advert->update(['title' => 'Lego Star Wars Death Star', 'seller_id' => 2]);

            $browser->loginAs($user)->visit('advertisements/' . $advert->id)
                ->type('@amount', 500)
                ->press('@bid')
                ->assertSee('500')
                ->assertSee($user->name);
        });
    }
}
