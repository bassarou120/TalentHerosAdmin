<?php

use App\Http\Controllers\CampagneController;
use Illuminate\Support\Facades\Route;



Route::get('/campagnes/encours',[  CampagneController::class,'campagnes_encours'])->name('campagnes_encours');

Route::get('/', function () {
    return view('welcome');
});
