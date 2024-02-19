<?php

use App\Http\Controllers\MoviesController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\UserDashboard\HomeController;
use App\Http\Controllers\CartController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/




Route::middleware('auth','permission:user-dashboard')->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/home',[HomeController::class,'home'])->name('home');
    Route::get('/add-to-cart',[CartController::class,'add_cart'])->name('add-to-cart');
    Route::get('/user-cart',[CartController::class,'user_cart'])->name('user_cart');
    Route::get('/remove-item',[CartController::class,'remove_item'])->name('remove_item');
    Route::get('/delete-item/{item}',[CartController::class,'delete_cart'])->name('delete_cart');
});

require __DIR__.'/auth.php';
