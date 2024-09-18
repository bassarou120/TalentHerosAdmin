<?php

use App\Http\Controllers\CampagneController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/campagnes',[  CampagneController::class,'campagnes_all'])->name('campagnes_all');
Route::get('/campagnes/encours',[  CampagneController::class,'campagnes_encours'])->name('campagnes_encours');


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
