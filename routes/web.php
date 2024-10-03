<?php


use App\Http\Controllers\CampagneController;
use App\Models\Campagne;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


// Authentication Routes (including verification)
Auth::routes(['verify' => true]);



//Route::post('register', [CustomerAuthController::class,'register']);
//Route::post('login',  [CustomerAuthController::class,'login']);
Route::get('/campagnes/encours',[  CampagneController::class,'campagnes_encours'])->name('campagnes_encours');

Route::get('/', function () {
//     $campagne= Campagne::find(20);
////    $campagne->increment('nbr_participant');
//
//    $campagne->nbr_participant  = $campagne->nbr_participant+ 1;
//    $campagne->save();



    return redirect('/admin');
//    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
