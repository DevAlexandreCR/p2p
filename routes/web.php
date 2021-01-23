<?php

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
Route::get('/{product:slug}', [App\Http\Controllers\HomeController::class, 'show'])->name('home.product');

Route::middleware('auth')->prefix('dashboard')->group(function () {
    Route::get('/', [App\Http\Controllers\DashboardController::class, 'main'])->name('dashboard');
    Route::resource('roles', RoleController::class)->except(['edit', 'create', 'show']);
    Route::resource('users', UserController::class)->except('edit');
    Route::resource('products', ProductController::class)->except('edit');
    Route::put('users/{user}/update_permissions', [PermissionController::class, 'update'])
        ->name('permissions.update');
});
