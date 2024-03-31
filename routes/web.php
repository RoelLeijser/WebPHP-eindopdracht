<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\AdvertisementController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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
    Route::resource('advertisements', AdvertisementController::class)->except(['index', 'show']);
    Route::post('advertisements/{advertisement}/bid', [AdvertisementController::class, 'bid'])->name('advertisements.bid');
    Route::post('advertisements/{advertisement}/favorite', [AdvertisementController::class, 'favorite'])->name('advertisements.favorite');
});

Route::get('advertisements', [AdvertisementController::class, 'index'])->name('advertisements.index');
Route::get('advertisements/{advertisement}', [AdvertisementController::class, 'show'])->name('advertisements.show');

Route::get('/favorites', [AccountController::class, 'favorites'])->name('account.favorites');

Route::get('/{slug}', [CompanyController::class, "showLandingPage"])->name('landingpage');
