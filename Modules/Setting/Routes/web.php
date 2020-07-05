<?php

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

use Illuminate\Support\Facades\Route;

Route::middleware('auth')
     ->prefix('cms/setting')
     ->group(function() {
        Route::get('/', 'SettingController@index');
        Route::resource('regras', 'RolesController');
        Route::resource('menus', 'MenuController');
        Route::resource('permissions', 'PermissionController');
        Route::resource('acls', 'AclController');
        Route::resource('roles', 'RoleController');
    });
