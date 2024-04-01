<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;

class AdvertisementsTest extends DuskTestCase
{
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

            $browser->loginAs($user)->visit('/advertisements')
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

            $browser->loginAs($user)->visit('/advertisements')
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

            $browser->loginAs($user)->visit('/advertisements')
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
}
