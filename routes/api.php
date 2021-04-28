<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TransactionsController;

 
Route::group([ 
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) { 
    Route::post('signup', [AuthController::class,'signup']);
    Route::post('signup/resend-link', [AuthController::class,'resendLink']);
    Route::post('signin', [AuthController::class,'signin']);
    Route::post('signout', [AuthController::class,'signout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me']); 
    Route::post('verify',[AuthController::class,'verify']); 
    Route::post('password/email',[AuthController::class,'resetVerify']); 
    Route::post('password/reset',[AuthController::class,'passwordReset']); 
});  
Route::put('account/update/{accounts}',[AccountController::class,'update']);  
Route::group([ 
    'middleware' => 'api',
    'prefix' => 'transaction' 
], function ($router) { 
    Route::post('create', [TransactionsController::class,'create']); 
    Route::delete('destroy/{transactions}', [TransactionsController::class,'destroy']);
    Route::delete('destroy-all', [TransactionsController::class,'destroyAll']);
    Route::get('get/{transactions}', [TransactionsController::class,'get']);  
    Route::get('get-all', [TransactionsController::class,'getAll']);
}); 
Route::resource('news', [NewsController::class]);
