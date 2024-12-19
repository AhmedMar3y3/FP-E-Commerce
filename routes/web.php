<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;

//////////////////////////////////Admin Routes//////////////////////////////////

//public routes
Route::get('/', [AuthController::class, 'loadLoginPage'])->name('loginPage');
Route::post('/login-admin', [AuthController::class, 'loginUser'])->name('loginUser');

//protected routes
Route::middleware(['auth.admin'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout'); 
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('admin.dashboard');

    // Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('/create-category', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/store-category', [CategoryController::class, 'store'])->name('categories.store');
    Route::delete('/delete-category/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
});