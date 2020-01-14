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

Route::get('/', function () {
    return view('home');
});

// Route::get('/categorias/{e?}', 'CategoriesController@index')->name('categories');
// Route::get('/produtos', 'ProductsController@index')->name('products');

// Route::get('/oi/{nome?}', function($nome = ''){
//     return "oi {$nome}";
// });

Route::resource('categorias', 'CategoriesController');
Route::resource('produtos', 'ProductsController');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles','RoleController');
    Route::resource('users','UserController');
    // Route::resource('produtos', 'ProductsController');
});