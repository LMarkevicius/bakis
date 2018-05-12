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

// Lunches
Route::get('/', ['as' => 'index', 'uses' => 'LunchController@index']);
Route::get('/šios-dienos-patiekalai', ['as' => 'todays.deals', 'uses' => 'LunchController@todaysdeals']);
Route::get('/visi-patiekalai', ['as' => 'all.deals', 'uses' => 'LunchController@alldeals']);
// Route::get('/restaurant/{id}', ['as' => 'lunch.show', 'uses' => 'LunchController@show']);

Route::get('/apžvalga/restoranas/{restaurant_id}/patiekalas', ['as' => 'lunch.create', 'uses' => 'LunchController@create']);
Route::post('/apžvalga/restoranas/{restaurant_id}/patiekalas', ['as' => 'lunch.store', 'uses' => 'LunchController@store']);
Route::get('/apžvalga/restoranas/{restaurant_id}/patiekalas/{id}/redaguoti', ['as' => 'lunch.edit', 'uses' => 'LunchController@edit']);
Route::put('/apžvalga/restoranas/{restaurant_id}/patiekalas/{id}', ['as' => 'lunch.update', 'uses' => 'LunchController@update']);
Route::delete('/apžvalga/restoranas/{restaurant_id}/patiekalas/{id}', ['as' => 'lunch.destroy', 'uses' => 'LunchController@destroy']);

// Restaurants
Route::get('/visi-restoranai', ['as' => 'restaurant.index', 'uses' => 'RestaurantController@index']);
Route::get('/restoranas/{id}', ['as' => 'restaurant.show', 'uses' => 'RestaurantController@show']);
// Route::get('/restaurant', ['as' => 'restaurant.create', 'uses' => 'RestaurantController@create']);
// Route::post('/restaurant', ['as' => 'restaurant.store', 'uses' => 'RestaurantController@store']);
// Route::get('/restaurant/{id}/edit', ['as' => 'restaurant.edit', 'uses' => 'RestaurantController@edit']);
// Route::put('/restaurant/{id}', ['as' => 'restaurant.update', 'uses' => 'RestaurantController@update']);
// Route::delete('/restaurant/{id}', ['as' => 'restaurant.destroy', 'uses' => 'RestaurantController@destroy']);

// Contacts
Route::get('/apžvalga/restoranas/{restaurant_id}/kontaktai', ['as' => 'contact.create', 'uses' => 'ContactController@create']);
Route::post('/apžvalga/restoranas/{restaurant_id}/kontaktai', ['as' => 'contact.store', 'uses' => 'ContactController@store']);
Route::get('/apžvalga/restoranas/{restaurant_id}/kontaktai/{id}/redaguoti', ['as' => 'contact.edit', 'uses' => 'ContactController@edit']);
Route::put('/apžvalga/restoranas/{restaurant_id}/kontaktai/{id}', ['as' => 'contact.update', 'uses' => 'ContactController@update']);
Route::delete('/apžvalga/restoranas/{restaurant_id}/redaguoti/kontaktai/{id}', ['as' => 'contact.destroy', 'uses' => 'ContactController@destroy']);

// Fetch
Route::post('/restoranas/{restaurant_id}/patiekalas/ištraukti', ['as' => 'fetch.index', 'uses' => 'FetchController@index']);
Route::post('/restoranas/{restaurant_id}/patiekalas/xpath', ['as' => 'fetch.store', 'uses' => 'FetchController@store']);

// Check XPath
Route::post('/restoranas/{restaurant_id}/patikrinti-xpath', ['as' => 'xpath.index', 'uses' => 'XpathController@index']);
Route::post('/restoranas/{restaurant_id}/naujas-xpath-patiekalas', ['as' => 'xpath.lunch.store', 'uses' => 'XpathController@xpathstore']);
Route::post('/restoranas/{restaurant_id}/naujas-xpath-patiekalas/{id}', ['as' => 'xpath.lunch.update', 'uses' => 'XpathController@update']);

// Admin Dashboard
Route::get('/apžvalga/visi-restoranai', ['as' => 'dashboard.index', 'uses' => 'AdminController@index']);
Route::get('/apžvalga/restoranas/sukurti', ['as' => 'dashboard.create', 'uses' => 'AdminController@create']);
Route::post('/apžvalga/restoranas', ['as' => 'dashboard.store', 'uses' => 'AdminController@store']);
Route::get('/apžvalga/restoranas/{id}/redaguoti', ['as' => 'dashboard.edit', 'uses' => 'AdminController@edit']);
Route::put('/apžvalga/restoranas/{id}', ['as' => 'dashboard.update', 'uses' => 'AdminController@update']);
Route::delete('/apžvalga/restoranas/{id}', ['as' => 'dashboard.destroy', 'uses' => 'AdminController@destroy']);
Route::get('/apžvalga/atsisiųsti-log-failą', ['as' => 'dashboard.download', 'uses' => 'AdminController@download']);

// Admin Settings
Route::get('/apžvalga/nustatymai', ['as' => 'settings.edit', 'uses' => 'SettingsController@edit']);
Route::put('/apžvalga/nustatymai/atnaujinti', ['as' => 'settings.update', 'uses' => 'SettingsController@update']);
