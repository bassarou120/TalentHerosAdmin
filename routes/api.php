<?php

use App\Http\Controllers\Auth\CustomerAuthController;
use App\Http\Controllers\CampagneController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::get('/campagnes',[  CampagneController::class,'campagnes_all'])->name('campagnes_all');
Route::get('/campagnes/encours',[  CampagneController::class,'campagnes_encours'])->name('campagnes_encours');
Route::get('/campagne/{id}', [CampagneController::class, 'getCampagneById']);
Route::get('/pays', [ CustomerAuthController::class, 'getPays']);


//registration and login
Route::group(['prefix' => 'auth' ], function () {
    Route::post('register', [CustomerAuthController::class,'register']);
    Route::post('login',  [CustomerAuthController::class,'login']);

});

//Route::post('register', [CustomerAuthController::class,'register']);
//Route::post('login',  [CustomerAuthController::class,'login']);

//Route::get('/utilisateur/info', [ UserController::class,'info']);


//Route::middleware('auth:api')->group( function () {
//    Route::get('/utilisateur/info', [ UserController::class,'info']);
//});
//
Route::group(['prefix' => 'utilisateur' ], function () {

    Route::get('info', [ UserController::class,'info'])->middleware('auth:sanctum');
//    Route::post('update-profile', 'CustomerController@update_profile');
//    Route::get('notifications', 'NotificationController@get_notifications');

});

Route::post('/participer', [CampagneController::class, 'participer'])->middleware('auth:sanctum');
Route::get('/mes_participation', [CampagneController::class, 'mes_participation'])->middleware('auth:sanctum');;


Route::post('/messages/send', [MessageController::class,'sendMessage'])->name('messages.send');

// Page pour voir les messages reçus
Route::get('/messages/getMessages/{receiverId}', [MessageController::class,'getMessages'])->middleware('auth:sanctum')->name('messages.inbox');


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
