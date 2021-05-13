<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;  
use App\Http\Controllers\SocialiteController;


Route::get('/', function ($p) {
    return view('welcome'); 
//     $c=Hash::check($p,'$2y$10$JWEQxtQ8GfehrK9u7FqleuXOpZ6m6uCwr302gmYcr62Wb7XZ1c7ba');   
//    dump($p,$c); 
});

//google Auth routes
Route::get('/google', [SocialiteController::class,'getGoogleData']); 
Route::get('/callback', [SocialiteController::class,'handleProviderCallback']); 
