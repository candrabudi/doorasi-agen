<?php

use App\Http\Controllers\Accordiancontroller;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\MarketPlaceController;
use App\Http\Controllers\ShipmentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'pageLogin'])->name('login');
Route::post('/login/process', [AuthController::class, 'login'])->name('login.process');


Route::get('/accordian', [Accordiancontroller::class, 'showDistributors']);
Route::get('/search-regions', [Accordiancontroller::class, 'searchRegions']);
Route::get('/get-distributors', [Accordiancontroller::class, 'getDistributorsByRegion']);
Route::get('/list-of-area', [AreaController::class, 'listOfArea']);


Route::get('/', function () {
    return view('welcome');
});

Route::get('/insert-province', [AreaController::class, 'insertProvince']);
Route::get('/insert-regency', [AreaController::class, 'insertRegency']);
Route::get('/insert-district', [AreaController::class, 'insertDistrict']);
Route::get('/insert-village', [AreaController::class, 'insertVillage']);

Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users/store', [UserController::class, 'store'])->name('users.store');
Route::get('/users/{a}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::put('/users/{a}/update', [UserController::class, 'update'])->name('users.update');
Route::delete('/users/{a}/destroy', [UserController::class, 'destroy'])->name('users.destroy');
Route::patch('/users/{id}/status', [UserController::class, 'updateStatus'])->name('users.updateStatus');


Route::get('/distributors', [DistributorController::class, 'index'])->name('distributors.index');
Route::get('/distributors/create', [DistributorController::class, 'create'])->name('distributors.create');
Route::post('/distributors/store', [DistributorController::class, 'store'])->name('distributors.store');
Route::get('/distributors/{a}/edit', [DistributorController::class, 'edit'])->name('distributors.edit');
Route::put('/distributors/{a}/update', [DistributorController::class, 'update'])->name('distributors.update');
Route::delete('/distributors/{a}/destroy', [DistributorController::class, 'destroy'])->name('distributors.destroy');
Route::patch('/distributors/{id}/status', [DistributorController::class, 'updateStatus'])->name('distributors.updateStatus');


Route::get('/shipments', [ShipmentController::class, 'index'])->name('shipments.index');
Route::post('/shipments/store', [ShipmentController::class, 'store'])->name('shipments.store');
Route::get('/shipments/{id}/edit', [ShipmentController::class, 'edit'])->name('shipments.edit');
Route::post('/shipments/{id}/update', [ShipmentController::class, 'update'])->name('shipments.update');
Route::delete('/shipments/{id}/delete', [ShipmentController::class, 'destroy'])->name('shipments.destroy');

Route::get('/marketplaces', [MarketPlaceController::class, 'index'])->name('marketplaces.index');
Route::get('/marketplaces/create', [MarketPlaceController::class, 'create'])->name('marketplaces.create');
Route::post('/marketplaces/store', [MarketPlaceController::class, 'store'])->name('marketplaces.store');
Route::get('/marketplaces/edit/{id}', [MarketPlaceController::class, 'edit'])->name('marketplaces.edit');
Route::put('/marketplaces/update/{id}', [MarketPlaceController::class, 'update'])->name('marketplaces.update');
Route::delete('/marketplaces/destroy/{id}', [MarketPlaceController::class, 'destroy'])->name('marketplaces.destroy');