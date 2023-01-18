<?php

use App\Http\Controllers\V0\AbsenceController;
use App\Http\Controllers\V0\AddressController;
use App\Http\Controllers\V0\AOrderController;
use App\Http\Controllers\V0\AuthenticationController;
use App\Http\Controllers\V0\BeneficiaryController;
use App\Http\Controllers\V0\ClassController;
use App\Http\Controllers\V0\CompoundOrderController;
use App\Http\Controllers\V0\DocsUpController;
use App\Http\Controllers\V0\HAbsenceController;
use App\Http\Controllers\V0\HAccountController;
use App\Http\Controllers\V0\HCardOrderController;
use App\Http\Controllers\V0\HOrderController;
use App\Http\Controllers\V0\ImportController;
use App\Http\Controllers\V0\MessageController;
use App\Http\Controllers\V0\OrderController;
use App\Http\Controllers\V0\PAbsenceController;
use App\Http\Controllers\V0\PageController;
use App\Http\Controllers\V0\PaymentController;
use App\Http\Controllers\V0\PeriodController;
use App\Http\Controllers\V0\PgOrderController;
use App\Http\Controllers\V0\PrevAbsenceController;
use App\Http\Controllers\V0\ProfessionController;
use App\Http\Controllers\V0\ProfileController;
use App\Http\Controllers\V0\ProfilePageController;
use App\Http\Controllers\V0\RoleController;
use App\Http\Controllers\V0\ROrderController;
use App\Http\Controllers\V0\ServiceController;
use App\Http\Controllers\V0\StockController;
use App\Http\Controllers\V0\StockDetailController;
use App\Http\Controllers\V0\SuppOrderController;
use App\Http\Controllers\V0\TypeAbsenceController;
use App\Http\Controllers\V0\TypeController;
use App\Http\Controllers\V0\UserController;
use App\Http\Controllers\V0\ValidationController;
use App\Http\Controllers\V0\VnsController;
use App\Http\Controllers\V0\VnsProfileController;
use App\Http\Controllers\V0\VOrderController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => '{extranet}', 'middleware' => 'bearer-token-required'], function () {

    // Authentication
    Route::group(['prefix' => 'auth'], function () {
        Route::any('logout', AuthenticationController::class . '@logout')->name('auth.logout');
        Route::post('login', AuthenticationController::class . '@login')->name('auth.login')->withoutMiddleware('bearer-token-required');
        Route::get('verify', AuthenticationController::class . '@verifyKey')->name('auth.verify');
        Route::get('profile', AuthenticationController::class . '@profile')->name('auth.profile');
        Route::get('messages', AuthenticationController::class . '@messages')->name('auth.messages');
        Route::get('menu', AuthenticationController::class . '@menu')->name('auth.menu');
        Route::get('token/session', AuthenticationController::class . '@sessionToken')->name('auth.session-token');
        Route::get('token/public', AuthenticationController::class . '@publicToken')->name('auth.public-token');
    });

    // Beneficiaries
    Route::apiResource('beneficiaries', BeneficiaryController::class)->whereNumber('beneficiary');
    Route::post('beneficiaries/export/{type?}', BeneficiaryController::class . '@export')->name('beneficiaries.export');
    Route::post('beneficiaries/import', BeneficiaryController::class . '@import')->name('beneficiaries.import');
    Route::get('beneficiaries/import/format', BeneficiaryController::class . '@importsFormat')->name('beneficiaries.import.format');
    Route::post('beneficiaries/transfer', BeneficiaryController::class . '@transfer')->name('beneficiaries.transfer');
    Route::post('beneficiaries/activate', BeneficiaryController::class . '@activateAll')->name('beneficiaries.activate-all');
    Route::post('beneficiaries/fetch', BeneficiaryController::class . '@getBeneficiaries')->name('beneficiaries.fetch');

    // Services
    Route::apiResource('services', ServiceController::class)->whereNumber('service');
    Route::post('services/export/{type?}', ServiceController::class . '@export')->name('services.export');
    Route::post('services/import', ServiceController::class . '@import')->name('services.import');
    Route::post('services/import/rsi', ServiceController::class . '@importRsi')->name('services.import.rsi');
    Route::get('services/import/format', ServiceController::class . '@importsFormat')->name('services.import.format');
    Route::get('services/std', ServiceController::class . '@getServices')->name('services.index.std');

    // Stocks
    Route::apiResource('stocks', StockController::class)->whereNumber('stock');
    Route::post('stocks/export/{type?}', StockController::class . '@export')->name('stocks.export');
    Route::post('stocks/import', StockController::class . '@import')->name('stocks.import');

    // Stock Details
    Route::apiResource('stocks-details', StockDetailController::class)->whereNumber('stocks_detail');
    Route::post('stocks-details/export/{type?}', StockDetailController::class . '@export')->name('stocks-details.export');
    Route::post('stocks-details/import', StockDetailController::class . '@import')->name('stocks-details.import');

    // Users
    Route::apiResource('users', UserController::class)->whereNumber('user');
    Route::post('users/export/{type?}', UserController::class . '@export')->name('users.export');
    Route::post('users/import', UserController::class . '@import')->name('users.import');
    Route::get('users/import/format', UserController::class . '@importsFormat')->name('users.import.format');
    Route::post('users/new-password', UserController::class . '@newPassword')->name('users.new-password');
    Route::post('users/change-password', UserController::class . '@changePassword')->name('users.change-password');
    Route::get('users/submit-file', UserController::class . '@submitFile')->name('users.submit-file');
    Route::get('users/notify', UserController::class . '@notifyEmail')->name('users.notify');
    Route::get('users/current', UserController::class . '@current')->name('users.current');

    // Users Roles
    Route::apiResource('roles', RoleController::class)->whereNumber('role');
    Route::post('roles/export/{type?}', RoleController::class . '@export')->name('roles.export');

    // Vns
    Route::apiResource('vns', VnsController::class)->whereNumber('vn');
    Route::post('vns/export/{type?}', VnsController::class . '@export')->name('vns.export');

    // Vns Profiles
    Route::apiResource('vns-profiles', VnsProfileController::class)->except('show')->whereNumber('vns_profile');
    Route::post('vns-profiles/export/{type?}', VnsProfileController::class . '@export')->name('vns-profiles.export');

    // Orders
    Route::apiResource('orders', OrderController::class)->whereNumber('order');
    Route::post('orders/export/{type?}', OrderController::class . '@export')->name('orders.export');
    Route::post('orders/state', OrderController::class . '@orderState')->name('orders.state');
    Route::post('orders/last', OrderController::class . '@lastOrderNumber')->name('orders.state');
    Route::post('orders/info', OrderController::class . '@ordersInfo')->name('orders.info');
    Route::post('orders/validate', OrderController::class . '@validateOrder')->name('orders.validate');
    Route::post('orders/validate/all', OrderController::class . '@validateAllOrders')->name('orders.validate-all');
    Route::get('orders/clean', OrderController::class . '@clean')->name('orders.clean');
    Route::post('orders/apply', OrderController::class . '@clean')->name('orders.apply');
    Route::post('orders/recap', OrderController::class . '@recap')->name('orders.recap');

    // Menus
    // Route::apiResource('menu', MenuC::class)->only('index');

    // Messages
    Route::apiResource('messages', MessageController::class)->only('index');

    // Compound Orders
    Route::apiResource('compound-orders', CompoundOrderController::class)->whereNumber('compound_order');
    Route::post('compound-orders/export/{type?}', CompoundOrderController::class . '@export')->name('compound-orders.export');
    Route::get('compound-orders/import/format', CompoundOrderController::class . '@importsFormat')->name('compound-orders.import.format');
    Route::post('compound-orders/state', CompoundOrderController::class . '@orderState')->name('compound-orders.state');
    Route::post('compound-orders/validate', CompoundOrderController::class . '@validateOrder')->name('compound-orders.validate');
    Route::post('compound-orders/validate/all', CompoundOrderController::class . '@validateAllOrders')->name('compound-orders.validate-all');
    Route::post('compound-orders/new', CompoundOrderController::class . '@newOrder')->name('compound-orders.new');
    Route::post('compound-orders/rename', CompoundOrderController::class . '@renameOrder')->name('compound-orders.rename');
    Route::post('compound-orders/clean', CompoundOrderController::class . '@clean')->name('compound-orders.clean');

    // Supp Orders
    Route::apiResource('supp-orders', SuppOrderController::class)->whereNumber('supp_order');
    Route::get('supp-orders/import/format', SuppOrderController::class . '@importsFormat')->name('supp-orders.import.format');
    Route::post('supp-orders/export/{type?}', SuppOrderController::class . '@export')->name('supp-orders.export');
    Route::get('supp-orders/state', SuppOrderController::class . '@orderState')->name('supp-orders.state');
    Route::post('supp-orders/validate', SuppOrderController::class . '@validateOrder')->name('supp-orders.validate');
    Route::post('supp-orders/validate/all', SuppOrderController::class . '@validateAllOrders')->name('supp-orders.validate-all');
    Route::post('supp-orders/clean', SuppOrderController::class . '@clean')->name('supp-orders.clean');
    Route::post('supp-orders/new', SuppOrderController::class . '@newOrder')->name('supp-orders.new');
    Route::post('supp-orders/rename', SuppOrderController::class . '@renameOrder')->name('supp-orders.rename');
    Route::get('supp-orders/recap', SuppOrderController::class . '@recap')->name('supp-orders.recap');

    // H Orders
    Route::apiResource('h-orders', HOrderController::class)->whereNumber('h_order');
    Route::post('h-orders/export/{type?}', HOrderController::class . '@export')->name('h-orders.export');
    Route::post('h-orders/fetch', HOrderController::class . '@getOrders')->name('h-orders.fetch');

    // A Orders
    Route::apiResource('a-orders', AOrderController::class)->whereNumber('a_order');
    Route::post('a-orders/invalidate', AOrderController::class . '@invalidate')->name('a-orders.invalidate');
    Route::post('a-orders/force', AOrderController::class . '@force')->name('a-orders.force');
    Route::post('a-orders/resend', AOrderController::class . '@resendOrder')->name('a-orders.resend');

    // H cards orders
    Route::apiResource('h-card-orders', HCardOrderController::class)->whereNumber('h_card_order');
    Route::post('h-card-orders/export/{type?}', HCardOrderController::class . '@export')->name('h-card-orders.export');

    // R Orders
    Route::apiResource('r-orders', ROrderController::class)->whereNumber('r_order');
    Route::post('r-orders/export/{type?}', ROrderController::class . '@export')->name('r-orders.export');
    Route::get('r-orders/file', ROrderController::class . '@getFile')->name('r-orders.file');
    Route::get('r-orders/sepa/file', ROrderController::class . '@sepaFile')->name('r-orders.sepa-file');
    Route::get('r-orders/sepa/data', ROrderController::class . '@sepaData')->name('r-orders.sepa-data');
    Route::get('r-orders/reports', ROrderController::class . '@reports')->name('r-orders.reports');
    Route::post('r-orders/resend', ROrderController::class . '@resend')->name('r-orders.resend');
    Route::post('r-orders/rename', ROrderController::class . '@rename')->name('r-orders.rename');

    // Pg Orders
    Route::apiResource('pg-orders', PgOrderController::class)->whereNumber('pg_order');
    Route::post('pg-orders/export/{type?}', PgOrderController::class . '@export')->name('pg-orders.export');
    Route::get('pg-orders/file', PgOrderController::class . '@getFile')->name('pg-orders.file');
    Route::get('pg-orders/sepa/file', PgOrderController::class . '@sepaFile')->name('pg-orders.sepa-file');
    Route::get('pg-orders/sepa/data', PgOrderController::class . '@sepaData')->name('pg-orders.sepa-data');
    Route::get('pg-orders/reports', PgOrderController::class . '@reports')->name('pg-orders.reports');
    Route::post('pg-orders/resend', PgOrderController::class . '@resend')->name('pg-orders.resend');

    // V Orders
    Route::apiResource('v-orders', VOrderController::class)->whereNumber('v_order');
    Route::post('v-orders/export/{type?}', VOrderController::class . '@export')->name('v-orders.export');

    // Validations
    Route::apiResource('validations', ValidationController::class)->whereNumber('validation');
    Route::post('validations/export/{type?}', ValidationController::class . '@export')->name('validations.export');
    Route::get('validations/file', ValidationController::class . '@getFile')->name('validations.file');

    // VNS
    Route::apiResource('vns', VnsController::class)->whereNumber('vn');
    Route::post('vns/export/{type?}', VnsController::class . '@export')->name('vns.export');

    // Professions
    Route::apiResource('professions', ProfessionController::class)->whereNumber('profession');
    Route::post('professions/export/{type?}', ProfessionController::class . '@export')->name('professions.export');

    // Classes
    Route::apiResource('classes', ClassController::class)->whereNumber('class');
    Route::post('classes/export/{type?}', ClassController::class . '@export')->name('classes.export');

    // Periods
    Route::apiResource('periods', PeriodController::class)->whereNumber('period');
    Route::post('periods/export/{type?}', PeriodController::class . '@export')->name('periods.export');

    // Absences
    Route::apiResource('absences', AbsenceController::class)->whereNumber('absence');
    Route::post('absences/export/{type?}', AbsenceController::class . '@export')->name('absences.export');

    // H Absences
    Route::apiResource('h-absences', HAbsenceController::class)->whereNumber('h_absence');
    Route::post('h-absences/export/{type?}', HAbsenceController::class . '@export')->name('h-absences.export');

    // H Accounts
    Route::apiResource('h-accounts', HAccountController::class)->whereNumber('h_account');
    Route::post('h-accounts/export/{type?}', HAccountController::class . '@export')->name('h-accounts.export');

    // Prev Absences
    Route::apiResource('prev-absences', PrevAbsenceController::class)->whereNumber('prev_absence');
    Route::post('prev-absences/export/{type?}', PrevAbsenceController::class . '@export')->name('prev-absences.export');
    Route::post('prev-absences/import', PrevAbsenceController::class . '@import')->name('prev-absences.import');
    Route::get('prev-absences/import/format', PrevAbsenceController::class . '@importsFormat')->name('prev-absences.import.format');

    // Types
    Route::apiResource('types', TypeController::class)->whereNumber('type');
    Route::post('types/export/{type?}', TypeController::class . '@export')->name('types.export');

    // P Absences
    Route::apiResource('p-absences', PAbsenceController::class)->whereNumber('p_absence');
    Route::post('p-absences/export/{type?}', PAbsenceController::class . '@export')->name('p-absences.export');

    // Type Absences
    Route::apiResource('type-absences', TypeAbsenceController::class)->whereNumber('type_absence');
    Route::post('type-absences/export/{type?}', TypeAbsenceController::class . '@export')->name('type-absences.export');

    // Messages
    Route::apiResource('messages', MessageController::class)->whereNumber('message');
    Route::post('messages/export/{type?}', MessageController::class . '@export')->name('messages.export');
    Route::get('messages/mine', MessageController::class . '@mine')->name('messages.mine');

    // Payments
    Route::apiResource('payments', PaymentController::class)->whereNumber('payment');
    Route::post('payments/export/{type?}', PaymentController::class . '@export')->name('payments.export');
    Route::post('payments/import', PaymentController::class . '@import')->name('payments.import');
    Route::get('payments/import/format', PaymentController::class . '@importsFormat')->name('payments.import-format');

    // Addresses
    Route::apiResource('addresses', AddressController::class)->whereNumber('address');

    // Doc Up
    Route::get('doc-up', DocsUpController::class)->name('doc-up.index');

    // Imports
    Route::apiResource('imports', ImportController::class)->only('index');
    Route::post('imports/export/{type?}', ImportController::class . '@export')->name('imports.export');
    Route::get('imports/import/format', ImportController::class . '@importsFormat')->name('imports.import-format');

    // Profiles
    Route::apiResource('profiles', ProfileController::class)->whereNumber('profile');
    Route::post('profiles/export/{type?}', ProfileController::class . '@export')->name('profiles.export');

    // Page
    Route::apiResource('pages', PageController::class)->whereNumber('page');
    Route::post('pages/export/{type?}', PageController::class . '@export')->name('pages.export');
    Route::post('pages/duplicate', PageController::class . '@duplicate')->name('pages.duplicate');

    // Profiles Pages
    Route::apiResource('profiles-pages', ProfilePageController::class)->whereNumber('profiles-page');
    Route::post('profiles-pages/export/{type?}', ProfilePageController::class . '@export')->name('profiles-pages.export');
});
