<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\TopUpController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\TransferController;
use App\Http\Controllers\TransactionsController;


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/signup', [AuthController::class,'signup']);
    Route::post('/signup/resend-link', [AuthController::class,'resendLink']);
    Route::post('/signin', [AuthController::class,'signin']);
    Route::post('/signout', [AuthController::class,'signout']);
    Route::post('/refresh', [AuthController::class,'refresh']);
    Route::get('/me', [AuthController::class,'me']);
    Route::get('/verified/{email}/{vCode}',[AuthController::class,'verified']);
    Route::post('/password/email',[AuthController::class,'reset_verify']);
    Route::post('/password/reset',[AuthController::class,'passwordReset']);
});

Route::put('update-account/{id}',[AccountController::class,'update']);
Route::get('/get-wallet/{id}', [AccountController::class,'getUser']);
Route::get('/get/{transactions}', [TransactionsController::class,'get']);
Route::post('/top-up', [TopUpController::class,'store']);
Route::post('/transfer', [TransferController::class,'store']);
Route::post('/verifypin', [TransferController::class,'verifypin']);
Route::post('/report', [ReportsController::class,'store']);
Route::post('/contact-us', [ContactController::class,'store']);
Route::post('/email-update', [NewsController::class,'store']);
