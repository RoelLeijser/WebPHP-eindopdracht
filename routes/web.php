<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

require __DIR__ . '/auth.php';

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    //Route::resource('review', ReviewController::class, ['except' => ['index', 'show', 'create',]]);
    Route::get('review/{review}/edit', [ReviewController::class, 'edit'])->name('review.edit');
    Route::put('review/{review}/update', [ReviewController::class, 'update'])->name('review.update');
    Route::delete('review/{review}/delete', [ReviewController::class, 'destroy'])->name('review.destroy');
    Route::post('review/{user}/user', [ReviewController::class, 'storeForUser'])->name('review.store.user');
    Route::post('review/{advertisement}/advertisement', [ReviewController::class, 'storeForAdvertisements'])->name('review.store.advertisement');
});

Route::group(['middleware' => ['auth', 'role:zakelijke adverteerder']], function () {
    Route::resource('company', CompanyController::class, ['except' => ['index']]);
});

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::resource('account', AccountController::class, ['except' => ['create', 'store']]);
    Route::delete('company/{company}/delete', [CompanyController::class, 'destroy'])->name('company.destroy');
    Route::get('contract/{account}', [ContractController::class, 'export'])->name('contract.export');
    Route::put('contract/{account}', [ContractController::class, 'verify'])->name('contract.verify');
});

Route::group(['middleware' => ['auth', 'role:zakelijke adverteerder', 'can:contract accepted']], function () {
    Route::get('company/{company}/edit', [CompanyController::class, 'edit'])->name('company.edit');
    Route::put('company/{company}', [CompanyController::class, 'update'])->name('company.update');
    Route::get('company/{company}/layout', [CompanyController::class, 'editPageLayout'])->name('company.edit.layout');
    Route::put('company/{company}/layout', [CompanyController::class, 'updatePageLayout'])->name('company.update.layout');
    Route::post('company/{company}/createApiKey', [CompanyController::class, 'createApiToken'])->name('company.createApiKey');
    Route::delete('company/{company}/deleteApiKey', [CompanyController::class, 'deleteApiToken'])->name('company.deleteApiKey');
});


//Language settings
Route::get('set-locale/{locale}', function ($locale) {

    session()->put('locale', $locale);
    app()->setlocale($locale);

    return redirect()->back();
})->name('locale.setting');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('advertisements', AdvertisementController::class)
        ->except(['index', 'show'])
        ->middleware([
            'can:create advertisements',
            'can:edit advertisements',
            'can:delete advertisements',
            'can:favorite advertisements',
            'can:bid advertisements'
        ]);
    Route::post('packages/storecsv', [AdvertisementController::class, 'storeCSV'])->name('advertisements.storecsv');
    Route::get('packages/createcsv', [AdvertisementController::class, 'createCSV'])->name('advertisements.createcsv');
    Route::post('advertisements/{advertisement}/bid', [AdvertisementController::class, 'bid'])->name('advertisements.bid');
    Route::post('advertisements/{advertisement}/favorite', [AdvertisementController::class, 'favorite'])->name('advertisements.favorite');
});

Route::get('advertisements/{user}/user', [AdvertisementController::class, 'advertisementsByUser'])->name('advertisements.user');
Route::get('advertisements', [AdvertisementController::class, 'index'])->name('advertisements.index');
Route::get('advertisements/{advertisement}', [AdvertisementController::class, 'show'])->name('advertisements.show');

Route::get('/favorites', [AccountController::class, 'favorites'])->name('account.favorites');

Route::get('/{slug}', [CompanyController::class, "showLandingPage"])->name('landingpage');
