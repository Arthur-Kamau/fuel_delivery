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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/create', 'HomeController@create')->name('create');
Route::post('/create', 'HomeController@createData')->name('create_data');


Route::get('/sort/type/{type}', 'HomeController@sortByType')->name('type_list');
Route::get('/sort/price', 'HomeController@sortByPrice')->name('price_list');
Route::get('/sort/location', 'HomeController@sortByLocation')->name('location_list');
