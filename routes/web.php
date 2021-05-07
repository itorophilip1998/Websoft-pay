<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;  
use App\Http\Controllers\SocialiteController;


Route::get('/{p1}/{p2}', function ($p1,$p2) {
    // return view('welcome');
    // $wallet=User::where('id',1)->with('accounts')->first(); 
    // $correct_pin=Hash::check($data, $wallet->accounts->transaction_pin);
    $p=Hash::make($p1);   
   dump($p,$p1,$p2);
    $c=Hash::check($p1,$p2);   
   dump($c);
});

//google Auth routes
Route::get('/google', [SocialiteController::class,'getGoogleData']); 
Route::get('/callback', [SocialiteController::class,'handleProviderCallback']); 
