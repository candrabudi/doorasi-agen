<?php

use App\Http\Controllers\Accordiancontroller;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CalculateShippingCostController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\MarketPlaceController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\ShippingCostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CorsMiddleware;

Route::get('/login', [AuthController::class, 'pageLogin'])->name('login');
Route::post('/login/process', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::prefix('cek-ongkir')->name('calculate_shipping_cost.')->group(function () {
    Route::get('/', [ShippingCostController::class, 'index'])->name('index');
    Route::get('/process', [ShippingCostController::class, 'calculateShippingCost'])->name('calculateShippingCost');
});

Route::get('/list-of-area', [AreaController::class, 'listOfArea']);


Route::middleware([CorsMiddleware::class])->group(function () {
    Route::get('/accordian', [AccordianController::class, 'showDistributors']);
    Route::get('/get-province-distributors', [AccordianController::class, 'getProvincesWithDistributors']);
    Route::get('/get-regency-distributors', [AccordianController::class, 'getRegenciesByProvinceWithDistributors']);
    Route::get('/show-distributors', [AccordianController::class, 'listDistributors']);
    Route::get('/show-regions/distributor', [AccordianController::class, 'searchRegions']);
    Route::get('/search-distributors', [AccordianController::class, 'listDistributorsByRegionAndProvince']);
    Route::get('/get-distributors', [AccordianController::class, 'listDistributorsByRegencyId']);
});

Route::get('/test', function () {
    return view('test');
});

Route::middleware(['auth'])->group(function () {

    Route::get('/', function () {
        return view('welcome');
    });
    
    Route::prefix('insert')->group(function () {
        Route::get('/province', [AreaController::class, 'insertProvince']);
        Route::get('/regency', [AreaController::class, 'insertRegency']);
        Route::get('/district', [AreaController::class, 'insertDistrict']);
        Route::get('/village', [AreaController::class, 'insertVillage']);
    });

    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/{a}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{a}/update', [UserController::class, 'update'])->name('update');
        Route::delete('/{a}/destroy', [UserController::class, 'destroy'])->name('destroy');
        Route::patch('/{id}/status', [UserController::class, 'updateStatus'])->name('updateStatus');
    });

    Route::prefix('distributors')->name('distributors.')->group(function () {
        Route::get('/', [DistributorController::class, 'index'])->name('index');
        Route::get('/data', [DistributorController::class, 'data'])->name('data');
        Route::get('/create', [DistributorController::class, 'create'])->name('create');
        Route::post('/store', [DistributorController::class, 'store'])->name('store');
        Route::get('/{a}/edit', [DistributorController::class, 'edit'])->name('edit');
        Route::put('/{a}/update', [DistributorController::class, 'update'])->name('update');
        Route::delete('/{a}/destroy', [DistributorController::class, 'destroy'])->name('destroy');
        Route::patch('/{id}/status', [DistributorController::class, 'updateStatus'])->name('updateStatus');
    });

    Route::prefix('shipments')->name('shipments.')->group(function () {
        Route::get('/', [ShipmentController::class, 'index'])->name('index');
        Route::post('/store', [ShipmentController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [ShipmentController::class, 'edit'])->name('edit');
        Route::post('/{id}/update', [ShipmentController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [ShipmentController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('marketplaces')->name('marketplaces.')->group(function () {
        Route::get('/', [MarketPlaceController::class, 'index'])->name('index');
        Route::get('/create', [MarketPlaceController::class, 'create'])->name('create');
        Route::post('/store', [MarketPlaceController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [MarketPlaceController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [MarketPlaceController::class, 'update'])->name('update');
        Route::delete('/destroy/{id}', [MarketPlaceController::class, 'destroy'])->name('destroy');
    });
   
   
    Route::prefix('calculate-shipping-cost')->name('calculate_shipping_cost.')->group(function () {
        Route::get('/', [CalculateShippingCostController::class, 'index'])->name('index');
        Route::get('/calculate', [CalculateShippingCostController::class, 'calculateShippingCost'])->name('calculateShippingCost');
        Route::get('/provinces', [CalculateShippingCostController::class, 'getProvinces'])->name('getProvinces');
        Route::get('/regencies', [CalculateShippingCostController::class, 'getRegencies'])->name('getRegencies');
        Route::get('/districts', [CalculateShippingCostController::class, 'getDistricts'])->name('getDistricts');
        Route::get('/distributors/nearby', [CalculateShippingCostController::class, 'getNearbyDistributors'])->name('getNearby');
    });
    

});