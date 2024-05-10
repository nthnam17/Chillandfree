<?php

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
// <====== Login ======>
Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'getLogin'])->name('login');
Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'postLogin']);
Route::get('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
// End Login


Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index']);
    });


    // system
    Route::group(['prefix' => 'system'], function () {
        // roles
        Route::group(['prefix' => 'role'], function () {
            Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index']);
        });
    });
});

Route::get('/', function () {
    return view('welcome');
});
