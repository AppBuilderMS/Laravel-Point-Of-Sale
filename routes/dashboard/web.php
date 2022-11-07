<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function(){

    Route::prefix('dashboard')->name('dashboard.')->middleware(['auth'])->group(function (){

        Route::get('/', [\App\Http\Controllers\Dashboard\WelcomeController::class,'index'])->name('welcome');

        //Users routes
        Route::resource('users', \App\Http\Controllers\Dashboard\UsersController::class)->except('show');

        //Category routes
        Route::resource('categories', \App\Http\Controllers\Dashboard\CategoryController::class)->except('show');

        //Product routes
        Route::resource('products', \App\Http\Controllers\Dashboard\ProductController::class)->except('show');

        //Client routes
        Route::resource('clients', \App\Http\Controllers\Dashboard\ClientController::class)->except('show');
        Route::resource('clients.orders', \App\Http\Controllers\Dashboard\Client\OrderController::class)->except('show');

        //Orders routes
        Route::resource('orders', \App\Http\Controllers\Dashboard\OrderController::class)->except('show');
        Route::get('orders/{order}/products', [\App\Http\Controllers\Dashboard\OrderController::class, 'products'])->name('orders.products');

    });//end of dashboard routes

});
