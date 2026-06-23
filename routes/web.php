<?php

use App\Http\Controllers\AccessControlController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Settings\LocaleController;
use App\Http\Controllers\Settings\ThemeConfigurationController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'index'])->name('login');
    Route::post('login', [LoginController::class, 'store'])->name('login.attempt');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [HomeController::class, 'index'])
        ->middleware('can:dashboard')
        ->name('dashboard');

    Route::prefix('settings')->name('settings.')->group(function () {
        Route::prefix('theme')->name('theme.')->group(function () {
            Route::get('/', [ThemeConfigurationController::class, 'index'])
                ->middleware('can:settings.theme.index')
                ->name('index');
            Route::post('/', [ThemeConfigurationController::class, 'update'])
                ->middleware('can:settings.theme.update')
                ->name('update');
        });
        Route::post('locale', [LocaleController::class, 'update'])->name('locale.update');
    });

    Route::resource('users', UserController::class);

    Route::prefix('users')->name('users.')->group(function() {
        Route::get('/{user}/profile', [UserController::class, 'profile'])->name('profile');
        Route::post('/{user}/profile', [UserController::class, 'updateProfile'])->name('profile.update');
    });

    Route::get('/roles', [AccessControlController::class, 'index'])
        ->middleware('can:access-control.index')
        ->name('access-control.index');
    Route::post('/roles/store', [AccessControlController::class, 'storeRole'])
        ->middleware('can:access-control.roles.store')
        ->name('access-control.roles.store');
    Route::post('/roles/{role}/sync', [AccessControlController::class, 'syncRolePermissions'])
        ->middleware('can:access-control.roles.sync')
        ->name('access-control.roles.sync');
    Route::post('/users/{user}/sync', [AccessControlController::class, 'syncUserAccess'])
        ->middleware('can:access-control.users.sync')
        ->name('access-control.users.sync');

    Route::post('logout', [LoginController::class, 'destroy'])->name('logout');
});

Route::fallback(function (Request $request) {
    return inertia('Errors/NotFound')->toResponse($request)->setStatusCode(404);
});
