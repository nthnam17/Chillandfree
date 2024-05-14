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

    // settings
    Route::group(['prefix' => 'settings'], function () {
        Route::get('/menu', [App\Http\Controllers\Admin\MenusController::class, 'index']);
        Route::get('/profile', [App\Http\Controllers\Admin\UsersController::class, 'getProfile']);
    });

    // system roles
    Route::group(['prefix' => 'system/roles'], function () {
        Route::get('list', [App\Http\Controllers\Admin\RolesController::class, 'getList']);
        Route::get('get', [App\Http\Controllers\Admin\RolesController::class, 'getOne']);
        Route::post('add', [App\Http\Controllers\Admin\RolesController::class, 'insertOne']);
        Route::post('edit', [App\Http\Controllers\Admin\RolesController::class, 'updateRole']);
        Route::post('delete', [App\Http\Controllers\Admin\RolesController::class, 'delRole']);
    });

    // system Permissions
    Route::group(['prefix' => 'system/permission'], function () {
        Route::get('list', [App\Http\Controllers\Admin\PermissionController::class, 'getList']);
        Route::get('get', [App\Http\Controllers\Admin\PermissionController::class, 'getOne']);
        Route::get('parentPer', [App\Http\Controllers\Admin\PermissionController::class, 'parentPer']);
        Route::post('add', [App\Http\Controllers\Admin\PermissionController::class, 'addPermission']);
        Route::post('edit', [App\Http\Controllers\Admin\PermissionController::class, 'editOne']);
        Route::post('delete', [App\Http\Controllers\Admin\PermissionController::class, 'delPermission']);
    });

    // system Users
    Route::group(['prefix' => 'system/users'], function () {
        Route::get('list', [App\Http\Controllers\Admin\UsersController::class, 'getList']);
        Route::get('get', [App\Http\Controllers\Admin\UsersController::class, 'getOne']);
        Route::post('add', [App\Http\Controllers\Admin\UsersController::class, 'addUser']);
        Route::post('edit', [App\Http\Controllers\Admin\UsersController::class, 'updateUser']);
        Route::post('delete', [App\Http\Controllers\Admin\UsersController::class, 'delUser']);
        Route::post('reset', [App\Http\Controllers\Admin\UsersController::class, 'delresetPasswordUser']);
    });
});

Route::get('/', function () { 
    return view('welcome');
});
