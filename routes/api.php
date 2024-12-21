<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\Admin\AuthController as Admin;
use App\Http\Controllers\IndexController;

Route::post('/register-admin', [Admin::class,'register']);

//public
Route::post('/login', [AuthController::class,'login']);
Route::post('/register', [AuthController::class,'register']);
Route::post('/verify-phone', [AuthController::class,'verifyPhone']);
Route::post('/forgot-password', [AuthController::class,'forgotPassword']);
Route::post('/reset-password', [AuthController::class,'resetPassword']);
//protected 
Route::group(['middleware'=>['auth:sanctum']], function(){
    Route::post('/logout', [AuthController::class,'logout']);
    Route::get('/in', [IndexController::class, 'indexall'])->name('index.all');
});




