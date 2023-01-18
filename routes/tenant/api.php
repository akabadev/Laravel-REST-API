<?php

use App\Http\Controllers\V1\Tenant\AccountController;
use App\Http\Controllers\V1\Tenant\AddressController;
use App\Http\Controllers\V1\Tenant\ArchiveController;
use App\Http\Controllers\V1\Tenant\AssetsController;
use App\Http\Controllers\V1\Tenant\AuthController;
use App\Http\Controllers\V1\Tenant\BeneficiaryController;
use App\Http\Controllers\V1\Tenant\CalendarController;
use App\Http\Controllers\V1\Tenant\CustomerController;
use App\Http\Controllers\V1\Tenant\FormatController;
use App\Http\Controllers\V1\Tenant\ListingController;
use App\Http\Controllers\V1\Tenant\MenuController;
use App\Http\Controllers\V1\Tenant\OrderController;
use App\Http\Controllers\V1\Tenant\OrderDetailController;
use App\Http\Controllers\V1\Tenant\PageController;
use App\Http\Controllers\V1\Tenant\PasswordActionsController;
use App\Http\Controllers\V1\Tenant\PeriodController;
use App\Http\Controllers\V1\Tenant\ProcessController;
use App\Http\Controllers\V1\Tenant\ProductController;
use App\Http\Controllers\V1\Tenant\ProfileController;
use App\Http\Controllers\V1\Tenant\SanctumTokenController;
use App\Http\Controllers\V1\Tenant\ServiceController;
use App\Http\Controllers\V1\Tenant\SettingController;
use App\Http\Controllers\V1\Tenant\TaskController;
use App\Http\Controllers\V1\Tenant\TemplateController;
use App\Http\Controllers\V1\Tenant\UserController;
use App\Http\Controllers\V1\Tenant\Views\BeneficiaryViewController;
use App\Http\Controllers\V1\Tenant\Views\CustomerViewController;
use App\Http\Controllers\V1\Tenant\Views\OrderViewController;
use App\Http\Controllers\V1\Tenant\Views\PageViewController;
use App\Http\Controllers\V1\Tenant\Views\ServiceViewController;
use App\Http\Controllers\V1\Tenant\Views\UserViewController;
use Illuminate\Support\Facades\Route;

Route::post("login", AuthController::class . "@login")->name("tenant.login");
Route::post("account/password/forgot", PasswordActionsController::class . '@changePassword');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('settings', SettingController::class);

    Route::any('logout', AuthController::class . '@logout')->name('tenant.logout');
    Route::post('account/password/update', PasswordActionsController::class . '@updatePassword');
    Route::get('account/menus', [AccountController::class, 'menus']);

    Route::apiResource('users', UserController::class);
    Route::apiResource('addresses', AddressController::class);
    Route::apiResource('beneficiaries', BeneficiaryController::class);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('customers', CustomerController::class);
    Route::apiResource('services', ServiceController::class);
    Route::apiResource('listings', ListingController::class);
    Route::apiResource('profiles', ProfileController::class);
    Route::apiResource('formats', FormatController::class);
    Route::apiResource('templates', TemplateController::class);
    Route::apiResource('calendars', CalendarController::class);
    Route::apiResource('calendars.periods', PeriodController::class);
    Route::apiResource('archives', ArchiveController::class)->only(["index", "store"]);
    Route::apiResource('menus', MenuController::class);

    Route::apiResource('orders', OrderController::class);
    Route::post('orders/{order}/validate', [OrderController::class, 'validateOrder']);

    Route::apiResource('orders.details', OrderDetailController::class);
    Route::apiResource('tokens', SanctumTokenController::class);
    Route::apiResource('processes', ProcessController::class);
    Route::apiResource('processes.tasks', TaskController::class);

    Route::get('processes/{process}/tasks/{task}/details', [TaskController::class, 'details'])->name('processes.tasks.details');
    Route::post('processes/{process}/tasks/{task}/validate', [TaskController::class, 'validateTask'])->name('processes.tasks.validate');
    Route::get('processes/{process}/tasks/{task}/download', [TaskController::class, 'download'])->name('processes.tasks.download');

    Route::apiResource('pages', PageController::class);
    Route::get('pages/{page}/config', [PageController::class, 'config']);

    Route::group(['prefix' => 'views'], function () {
        Route::apiResource('beneficiaries', BeneficiaryViewController::class);
        Route::post('/beneficiaries/export/{type}', [BeneficiaryViewController::class, 'export'])->name('beneficiaries.export');
        Route::post('/beneficiaries/import', [BeneficiaryViewController::class, 'import'])->name('beneficiaries.import');

        Route::apiResource('services', ServiceViewController::class);
        Route::post('/services/export/{type}', [ServiceViewController::class, 'export'])->name('services.export');
        Route::post('/services/import', [ServiceViewController::class, 'import'])->name('services.import');

        Route::apiResource('customers', CustomerViewController::class);
        Route::post('/customers/export/{type}', [CustomerViewController::class, 'export'])->name('customers.export');
        Route::post('/customers/import', [CustomerViewController::class, 'import'])->name('customers.import');

        Route::apiResource('orders', OrderViewController::class);
        Route::post('orders/import', [OrderViewController::class, 'import'])->name('orders.import');
        Route::post('orders/export/{type}', [OrderViewController::class, 'export'])->name('orders.export');
        Route::post('orders/{order}/validate', [OrderViewController::class, 'validateOrder'])->name('orders.validate');
        Route::get('/orders/{order}/summary', [OrderViewController::class, 'summary'])->name('orders.summary');
        Route::prefix('orders/{order}/details')->group(function () {
            Route::get('/', [OrderViewController::class, 'details'])->name("orders.details.index");
            Route::post('/', [OrderViewController::class, 'storeDetail'])->name("orders.details.store");
            Route::match(['PUT', 'PATCH'], '{detail}', [OrderViewController::class, 'updateDetail'])->name("orders.details.update");
            Route::delete('{detail}', [OrderViewController::class, 'destroyDetail'])->name("orders.details.delete");
        });

        Route::apiResource('users', UserViewController::class);
        Route::post('/users/export/{type}', [UserViewController::class, 'export'])->name('users.export');
        Route::post('/users/import', [UserViewController::class, 'import'])->name('users.import');

        Route::apiResource('pages', PageViewController::class);
    });
});

Route::get('assets/{type}/{file}', AssetsController::class)->where('file', '.*');
