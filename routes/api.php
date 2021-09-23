<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\Demands\DemandController;
use App\Http\Controllers\User\Address\AddressController;
use App\Http\Controllers\User\ContactInformationController;
use App\Http\Controllers\User\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('login', [AuthController::class, 'login'])->name('login');
});

Route::middleware(['auth:api'])->group(function () {
    Route::group(['prefix' => 'administrators', 'as' => 'administrators.', 'middleware' => ['admin']], function () {
        Route::group(['prefix' => 'roles', 'as' => 'roles.'], function () {
            Route::get('/', [RoleController::class, 'index'])->name('index');
            Route::post('/', [RoleController::class, 'store'])->name('store');
            Route::put('/{id}', [RoleController::class, 'update'])->name('update');
            Route::delete('/{id}', [RoleController::class, 'delete'])->name('delete');
        });
    });

    Route::middleware(['user'])->group(function () {
        Route::group(['prefix' => 'users', 'as' => 'users.'], function () {
            Route::post('assign-roles/{id}', ['middleware' => 'admin', UserController::class, 'assignRole'])->name('assign_roles');
            Route::group(['prefix' => 'addresses', 'as' => 'addresses.'], function () {
                Route::get('/', [AddressController::class, 'index'])->name('index');
                Route::post('/', [AddressController::class, 'store'])->name('store');
                Route::put('/{id}', [AddressController::class, 'update'])->name('update');
                Route::delete('/{id}', [AddressController::class, 'delete'])->name('delete');
            });
            Route::group(['prefix' => 'contact-information', 'as' => 'contact-information.'], function () {
                Route::get('/', [ContactInformationController::class, 'index'])->name('index');
                Route::put('/{id}', [ContactInformationController::class, 'update'])->name('update');
            });
        });

        Route::group(['prefix' => 'demands', 'as' => 'demands.'], function () {
            Route::get('/', [DemandController::class, 'index'])->name('index');
            Route::post('/', [DemandController::class, 'store'])->name('store');
            Route::put('/{id}', [DemandController::class, 'update'])->name('update');
            Route::patch('/{id}', [DemandController::class, 'changeStatus'])->name('change_status');
            Route::delete('/{id}', [DemandController::class, 'delete'])->name('delete');
        });
    });
});
