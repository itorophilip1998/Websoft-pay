<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialiteController;
 

Route::get('/', function () {
    return view('welcome');
});

//google Auth routes
Route::get('/google', [SocialiteController::class,['redirectToProvider']]);
Route::get('/google/callback', [SocialiteController::class,['handleProviderCallback']]);
