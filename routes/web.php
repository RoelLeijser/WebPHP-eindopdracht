<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\AccountController;
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
require __DIR__.'/auth.php';

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::group(['middleware' => ['auth', 'role:zakelijke adverteerder']], function() {
    Route::resource('company', CompanyController::class, ['except' => ['index']]);
});

Route::group(['middleware' => ['auth', 'role:admin']], function() {
    Route::resource('account', AccountController::class, ['except' => ['create', 'store']]);
    Route::delete('company/{company}/delete', [CompanyController::class, 'destroy'])->name('company.destroy');
});

Route::group(['middleware' => ['auth', 'can:contract accepted']], function() {
    Route::get('company/{company}/edit', [CompanyController::class, 'edit'])->name('company.edit');
    Route::put('company/{company}', [CompanyController::class, 'update'])->name('company.update');
    Route::get('company/{company}/layout', [CompanyController::class, 'editPageLayout'])->name('company.edit.layout');
    Route::put('company/{company}/layout', [CompanyController::class, 'updatePageLayout'])->name('company.update.layout');
});


Route::get('/{slug}', [CompanyController::class, "showLandingPage"])->name('landingpage');


//Language settings
Route::get('set-locale/{locale}', function ($locale) {

    session()->put('locale', $locale);
    app()->setlocale($locale);

    return redirect()->back();
})->name('locale.setting');
