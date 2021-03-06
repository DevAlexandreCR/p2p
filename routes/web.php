<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/{product:slug}', [App\Http\Controllers\HomeController::class, 'show'])->name('home.show');

Route::middleware('auth')->prefix('dashboard')->group(function () {
    Route::get('/main', [App\Http\Controllers\DashboardController::class, 'main'])->name('dashboard');
    Route::resource('roles', RoleController::class)->except(['edit', 'create', 'show']);
    Route::resource('users', UserController::class)->except('edit');
    Route::resource('products', ProductController::class)->except('edit');
    Route::put('users/{user}/update_permissions', [PermissionController::class, 'update'])
        ->name('permissions.update');
});

Route::middleware('auth')->prefix('user')->group(function() {
    Route::get('/{user}/cart', [CartController::class, 'show'])->name('cart.show');
    Route::put('/{user}/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/{user}/cart/delete', [CartController::class, 'destroy'])->name('cart.delete');
    Route::post('/{user}/cart/store', [CartController::class, 'store'])->name('cart.store');

    Route::resource('users.orders', OrderController::class)
        ->except('edit', 'create', 'destroy');
    Route::post('/{user}/orders/{order}/retry', [OrderController::class, 'retry'])
        ->name('users.orders.retry');
    Route::post('/{user}/orders/{order}/reverse', [OrderController::class, 'reverse'])
        ->name('users.orders.reverse');
});
