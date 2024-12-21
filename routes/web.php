<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;

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
    
    // Sub-Categories
    Route::post('/subcategories', [SubCategoryController::class, 'store'])->name('subs.store');
    Route::delete('/delete-subcategory/{subcategory}', [SubCategoryController::class, 'destroy'])->name('subs.destroy');
    
    // Products
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/create-product', [ProductController::class, 'create'])->name('products.create');
    Route::post('/store-product', [ProductController::class, 'store'])->name('products.store');
    Route::get('/edit-product/{productId}', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/update-product/{productId}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/delete-product/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    
    // Orders
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/accept-order/{id}', [OrderController::class, 'acceptOrder'])->name('orders.accept');
    Route::get('/reject-order/{id}', [OrderController::class, 'rejectOrder'])->name('orders.reject');
    Route::get('/delivery-order/{id}', [OrderController::class, 'deliveryOrder'])->name('orders.delivery');    
    
    
    

});