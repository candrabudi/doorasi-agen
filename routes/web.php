<?php

use App\Http\Controllers\AreaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/list-of-area', [AreaController::class, 'listOfArea']);