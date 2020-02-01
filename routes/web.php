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

Route::group(['prefix' => 'cms','middleware' => ['auth']], function () {
    Route::resource('regras','Cms\RoleController');
    Route::resource('users','Cms\UserController');
    Route::resource('produtos', 'Cms\ProductsController');
    Route::resource('categorias', 'Cms\CategoriesController');

    // Route::get('dashboard', [
    //       'as'   => 'expert.dashboard',
    //       'uses' => 'DashboardController@index'
    // ]);
});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Route::group([], function() {
    
//     // Route::resource('produtos', 'ProductsController');
// });

