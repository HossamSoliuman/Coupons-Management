<?php

use App\Http\Controllers\CodeController;
use App\Http\Controllers\ExtractionController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\GetCodeOffer;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExportController;
use App\Models\Code;

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
    Route::get('/index', [IndexController::class, 'index'])->name('admin.index');
    Route::get('index/chart-data', [IndexController::class, 'chartData']);
    Route::get('codes/{code}/offers', [CodeController::class, 'offersUsage'])->name("codes.offers.usage");
    Route::resource('shops', ShopController::class);
    Route::resource('codes', CodeController::class);
    Route::resource('offers', OfferController::class);
    Route::resource('users', UserController::class);
    Route::get('shops/{shop}codes/usage', [ShopController::class, 'codesUsages'])->name('shops.codes.usages');

    Route::get('shops/{shop}/offers', [ShopController::class, 'offers'])->name('shops.offers');
    //code shops
    Route::get('codes/{code}/shops', [CodeController::class, 'shops'])->name('codes.shops');
    Route::post('codes/{code}/shops', [CodeController::class, 'addShop'])->name('codes.shops.store');
    Route::delete('codes/{code}/shops', [CodeController::class, 'removeShop'])->name('codes.shops.destroy');
    Route::get('codes/{code}/unit-cost', [CodeController::class, 'unitCost']);

    //shop codes
    Route::get('shops/{shop}/codes', [ShopController::class, 'codes'])->name('shops.codes');
    Route::post('shops/codes', [ShopController::class, 'addCode'])->name('shops.codes.store');
    Route::delete('shops/{shop}/codes', [ShopController::class, 'removeCode'])->name('shops.codes.destroy');

    Route::get('code/{code}/export/pdf', [ExportController::class, 'exportPdf'])->name('export.pdf');
    Route::get('code/{code}/export/excel', [ExportController::class, 'exportExcel'])->name('export.excel');

    Route::get('shop/{shop}/export/pdf', [ExportController::class, 'exportPdfShop'])->name('shop.export.pdf');
    Route::get('shop/{shop}/export/excel', [ExportController::class, 'exportExcelShop'])->name('shop.export.excel');

    Route::get('lang/{locale}', function ($locale) {
        if (in_array($locale, ['en', 'ar'])) {
            session(['locale' => $locale]);
        }
        return redirect()->back();
    });
});


Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('/offer', function () {
        return view('get_code_offer');
    })->name('code.get_offer');
    Route::get('api/offer', GetCodeOffer::class)->name('code.offer.get');
});
