<?php

use App\Http\Controllers\V1\CentralAccountController;
use App\Http\Controllers\V1\CentralAuthController;
use App\Http\Controllers\V1\CentralListingController;
use App\Http\Controllers\V1\CentralMenuController;
use App\Http\Controllers\V1\CentralPasswordActionsController;
use App\Http\Controllers\V1\CentralProcessController;
use App\Http\Controllers\V1\CentralProfileController;
use App\Http\Controllers\V1\CentralSanctumTokenController;
use App\Http\Controllers\V1\CentralTaskController;
use App\Http\Controllers\V1\CentralTemplateController;
use App\Http\Controllers\V1\CentralTenantController;
use App\Http\Controllers\V1\CentralUserController;
use App\Http\Controllers\V1\CentralPageController;
use App\Http\Controllers\Api\SpacecraftController;

use Illuminate\Support\Facades\Route;

Route::post("login", [CentralAuthController::class, "signIn"]);
Route::post('account/password/forgot', CentralPasswordActionsController::class . '@changePassword');

Route::middleware("auth:sanctum")->group(function () {
    Route::post('account/password/update', CentralPasswordActionsController::class . '@updatePassword');
    Route::get('account/menus', [CentralAccountController::class, 'menus']);

    Route::post("logout", [CentralAuthController::class, "signOut"]);

    Route::apiResource('tenants', CentralTenantController::class);
    Route::apiResource('users', CentralUserController::class);

    Route::apiResource('pages', CentralPageController::class);
    Route::get('pages/{page}/config', [CentralPageController::class, 'config']);

    Route::apiResource('listings', CentralListingController::class);
    Route::apiResource('templates', CentralTemplateController::class);
    Route::apiResource("tenants", CentralTenantController::class);
    Route::apiResource('tokens', CentralSanctumTokenController::class);
    Route::apiResource('processes', CentralProcessController::class);
    Route::apiResource('profiles', CentralProfileController::class);
    Route::apiResource('menus', CentralMenuController::class);

    Route::apiResource('processes.tasks', CentralTaskController::class);
    Route::get('processes/{process}/tasks/{task}/details', [CentralTaskController::class, 'details'])
        ->name('processes.tasks.details');
    Route::post('processes/{process}/tasks/{task}/validate', [CentralTaskController::class, 'validateTask'])
        ->name('processes.tasks.validate');
    Route::get('processes/{process}/tasks/{task}/download', [CentralTaskController::class, 'download'])
        ->name('processes.tasks.download');


        Route::get('filter/spacecrafts/{name?}/{class?}/{status?}', [SpacecraftController::class, 'index'])->name('api.spacecrafts.filter');
        Route::get('spacecrafts',  [SpacecraftController::class, 'index'])->name('api.spacecrafts');
        Route::get('spacecrafts/{spacecraft}', [SpacecraftController::class,'show'])->name('api.spacecrafts.show');
        
      //  Route::middleware("auth:sanctum")->group(function () {
            Route::post('spacecrafts', [SpacecraftController::class, 'store'])->name('api.spacecrafts.store');
            Route::put('spacecrafts/{spacecraft}', [SpacecraftController::class, 'update'])->name('api.spacecrafts.update');
            Route::delete('spacecrafts/{id}', [SpacecraftController::class, 'destroy'])->name('api.spacecrafts.destroy');
       // });

});
