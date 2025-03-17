<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware([AdminMiddleware::class])->group(function () {
// categories routes
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
Route::post('/categories/store', [CategoryController::class, 'store'])->name('categories.store');
Route::get('/categories/edit/{id}', [CategoryController::class, 'edit'])->name('categories.edit');
Route::delete('/categories/destroy/{id}', [CategoryController::class, 'destroy'])->name('categories.destroy');
Route::post('/categories/update/{id}', [CategoryController::class, 'update'])->name('categories.update');


// products routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
Route::get('/products/edit/{id}', [ProductController::class, 'edit'])->name('products.edit');
Route::delete('/products/destroy/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
Route::post('/products/update/{id}', [ProductController::class, 'update'])->name('products.update');
Route::get('/products/filter', [ProductController::class, 'getFilteredProducts'])->name('products.filter');


Route::get('/sales-report', [OrderController::class, 'index'])->name('orders.index');
Route::get('/get-sales-data', [OrderController::class, 'getSalesData']);

Route::get('/dashboard', [DashBoardController::class, 'index'])->name('dashboard.index');

});



require __DIR__.'/auth.php';
