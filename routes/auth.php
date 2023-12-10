<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\RoleController;

Route::fallback(function ()
{
});

// Route::middleware('guest')->group(function () {


Route::get('login', [AuthenticatedSessionController::class, 'create'])
            ->name('login');

Route::get('/', [AuthenticatedSessionController::class, 'create']);

Route::post('login', [AuthenticatedSessionController::class, 'store']);


// });

// Route::middleware(['auth','verified'])->group(function () {
Route::group(['middleware'=>['auth','verified']],function(){ 

    Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::group(['middleware'=>'permission:admin-dashboard'],function(){
        Route::group(['middleware'=>'permission:users-list'],function(){

        Route::get('/dashboard',[RegisteredUserController::class,'dashboard'])->name('dashboard');
      
        Route::get('/user-profile',[RegisteredUserController::class,'user_profile'])->name('user_profile');
        });
        //all users

        Route::group(['middleware'=>'permission:users-create'],function(){
            //create new account
            Route::post('register', [RegisteredUserController::class, 'store'])->name('register.create');
            
            Route::get('register', [RegisteredUserController::class, 'index'])->name('register');
        });
        Route::group(['middleware'=>'permission:users-edit'],function(){
            //edit
            Route::get('register/edit', [RegisteredUserController::class, 'edit'])->name('register.edit');
           //update
            Route::post('register/update', [RegisteredUserController::class, 'update'])->name('register.update');  
        });
        Route::get('register/delete', [RegisteredUserController::class, 'trash'])->name('register.trash')->middleware('permission:users-delete');

        //activity
        Route::get('all_activities',[ActivityController::class,'all_activities'])->name('activity.all');

        Route::group(['middleware'=>'permission:product-list'],function(){
            //products
            Route::get('index',[ProductController::class,'index'])->name('products.all');
            
            Route::get('all_products',[ProductController::class,'all_products'])->name('get.products');

            Route::get('items',[ProductController::class,'items'])->name('specific.item');

            //get products
            Route::get('get_products',[ItemController::class,'get_products'])->name('all.products');
            //get brands
            Route::get('get_brands',[ItemController::class,'get_brands'])->name('get.brands');

            Route::get('get_item',[ItemController::class,'get_item'])->name('get.item');
        });
        Route::group(['middleware'=>'permission:product-create'],function(){
            //items
            Route::get('add_items',[ItemController::class,'index'])->name('add.items');
            //add item
            Route::post('add_items',[ItemController::class,'create_item'])->name('create.items');

        });

        Route::get('delete_item',[ItemController::class,'delete_item'])->name('delete.item')->middleware('middleware','product-delete');

        Route::group(['middleware'=>'permission:product-edit'],function(){
            Route::get('edit_item/{id}',[ItemController::class,'edit_item'])->name('edit.item');
            Route::post('update_item',[ItemController::class,'update_item'])->name('update.item');
        });

        //Roles
        Route::get('roles',[RoleController::class,'roles'])->name('roles');
        Route::post('add-role',[RoleController::class,'add_role'])->name('add_role');






    // Route::get('verify-email', EmailVerificationPromptController::class)
    //             ->name('verification.notice');

    // Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
    //             ->middleware(['signed', 'throttle:6,1'])
    //             ->name('verification.verify');

    // Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    //             ->middleware('throttle:6,1')
    //             ->name('verification.send');

    // Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
    //             ->name('password.confirm');

    // Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    // Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    
    // Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
    //             ->name('password.request');

    // Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
    //             ->name('password.email');

    // Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
    //             ->name('password.reset');

    // Route::post('reset-password', [NewPasswordController::class, 'store'])
    //             ->name('password.store');
    });
});
