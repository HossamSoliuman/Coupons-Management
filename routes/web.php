<?php

use App\Http\Controllers\CodeController;
use App\Http\Controllers\ExtractionController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\GetCodeOffer;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LocalizationController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Finder\Iterator\FilecontentFilterIterator;
use App\Http\Controllers\ExportController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes([
    'register' => false
]);

Route::middleware(['auth', 'admin'])->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/index', [IndexController::class, 'offersUsage'])->name('admin.index');

    Route::get('index-data', [IndexController::class, 'index']);
    Route::get('code/{code}/offers', [CodeController::class, 'offersUsage'])->name("codes.offers.usage");
    Route::resource('shops', ShopController::class);
    Route::resource('codes', CodeController::class);
    Route::resource('offers', OfferController::class);
    Route::resource('users', UserController::class);
    Route::get('/lang', [LocalizationController::class, 'setLocale'])->name('setLocale');

    Route::get('/{code}/export/pdf', [ExportController::class, 'exportPdf'])->name('export.pdf');
    Route::get('/{code}/export/excel', [ExportController::class, 'exportExcel'])->name('export.excel');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');

    Route::get('/offer', function () {
        return view('get_code_offer');
    })->name('code.get_offer');
    Route::get('api/offer', GetCodeOffer::class);
});

Route::get('/add-user', function () {
    User::create([
        'name' => 'admin',
        'email' => 'admin@gmail.com',
        'password' => Hash::make('password'),
        'role' => 'admin',
    ]);
});
