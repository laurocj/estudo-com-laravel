<?php

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

Route::middleware('auth')
    ->prefix('cms')
    ->group(function () {
        Route::get('/', 'Cms\DashboardController@index');
        Route::resource('usuarios', 'Cms\UserController');
        Route::resource('produtos', 'Cms\ProductsController');
        Route::resource('categorias', 'Cms\CategoriesController');
    });

Auth::routes();

// Route::get('/', 'HomeController@index')->name('home');

// Route::get('/{any}', function() {
//     return view('spa');
// })->where('any', '.*');
