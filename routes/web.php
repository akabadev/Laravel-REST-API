<?php

use App\Http\Controllers\SpacecraftController;
use App\Http\Controllers\V1\CentralAuthController;
use App\Http\Controllers\Web\CentralWikiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['web', 'auth'])->group(function () {
    Route::get('/login', [CentralAuthController::class, 'index'])
        ->name('web-sign-in-form');

    Route::post('login', [CentralAuthController::class, 'signIn'])
        ->name('web-sign-in')
        ->middleware('guest')
        ->withoutMiddleware('auth');

    Route::any('logout', [CentralAuthController::class, 'signOut'])
        ->name('web-sign-out');

    Route::get('wiki/{slug?}', CentralWikiController::class)
        ->name("wiki")->withoutMiddleware(['auth']);
        
        Route::get('/home',[App\Http\Controllers\SpacecraftController::class, 'index'])->name('home');
        Route::get('spacecraft/create', [SpacecraftController::class, 'create'])->name('spacecrafts.create');
        Route::post('spacecraft/store', [SpacecraftController::class, 'store'])->name('spacecrafts.store');
        Route::get('spacecraft/{spacecraft}', [SpacecraftController::class, 'show'])->name('spacecrafts.show');
        Route::post('spacecraft/delete/{id}}', [SpacecraftController::class, 'destroy'])->name('spacecrafts.destroy');
        Route::get('spacecraft/edit/{spacecraft}', [App\Http\Controllers\SpacecraftController::class, 'edit'])->name('spacecrafts.edit');    
        Route::post('spacecraft/update/{spacecraft}', [App\Http\Controllers\SpacecraftController::class, 'update'])->name('spacecrafts.update');
        
});

//Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
