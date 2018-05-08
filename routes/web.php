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
Route::get('/todays-deals', ['as' => 'todays.deals', 'uses' => 'LunchController@todaysdeals']);
Route::get('/all-deals', ['as' => 'all.deals', 'uses' => 'LunchController@alldeals']);
// Route::get('/restaurant/{id}', ['as' => 'lunch.show', 'uses' => 'LunchController@show']);

Route::get('/dashboard/restaurant/{restaurant_id}/lunch', ['as' => 'lunch.create', 'uses' => 'LunchController@create']);
Route::post('/dashboard/restaurant/{restaurant_id}/lunch', ['as' => 'lunch.store', 'uses' => 'LunchController@store']);
Route::get('/dashboard/restaurant/{restaurant_id}/lunch/{id}/edit', ['as' => 'lunch.edit', 'uses' => 'LunchController@edit']);
Route::put('/dashboard/restaurant/{restaurant_id}/lunch/{id}', ['as' => 'lunch.update', 'uses' => 'LunchController@update']);
Route::delete('/dashboard/restaurant/{restaurant_id}/lunch/{id}', ['as' => 'lunch.destroy', 'uses' => 'LunchController@destroy']);

// Restaurants
Route::get('/all_restaurants', ['as' => 'restaurant.index', 'uses' => 'RestaurantController@index']);
Route::get('/restaurant/{id}', ['as' => 'restaurant.show', 'uses' => 'RestaurantController@show']);
// Route::get('/restaurant', ['as' => 'restaurant.create', 'uses' => 'RestaurantController@create']);
// Route::post('/restaurant', ['as' => 'restaurant.store', 'uses' => 'RestaurantController@store']);
// Route::get('/restaurant/{id}/edit', ['as' => 'restaurant.edit', 'uses' => 'RestaurantController@edit']);
// Route::put('/restaurant/{id}', ['as' => 'restaurant.update', 'uses' => 'RestaurantController@update']);
// Route::delete('/restaurant/{id}', ['as' => 'restaurant.destroy', 'uses' => 'RestaurantController@destroy']);

// Contacts
Route::get('/dashboard/restaurant/{restaurant_id}/contact', ['as' => 'contact.create', 'uses' => 'ContactController@create']);
Route::post('/dashboard/restaurant/{restaurant_id}/contact', ['as' => 'contact.store', 'uses' => 'ContactController@store']);
Route::get('/dashboard/restaurant/{restaurant_id}/contact/{id}/edit', ['as' => 'contact.edit', 'uses' => 'ContactController@edit']);
Route::put('/dashboard/restaurant/{restaurant_id}/contact/{id}', ['as' => 'contact.update', 'uses' => 'ContactController@update']);
Route::delete('/dashboard/restaurant/{restaurant_id}/edit/contact/{id}', ['as' => 'contact.destroy', 'uses' => 'ContactController@destroy']);

// Fetch
Route::post('/restaurant/{restaurant_id}/lunch/fetch', ['as' => 'fetch.index', 'uses' => 'FetchController@index']);
Route::post('/restaurant/{restaurant_id}/lunch/xpath', ['as' => 'fetch.store', 'uses' => 'FetchController@store']);

// Check XPath
Route::post('/restaurant/{restaurant_id}/check-xpath', ['as' => 'xpath.index', 'uses' => 'XpathController@index']);
Route::post('/restaurant/{restaurant_id}/new-xpath-lunch', ['as' => 'xpath.lunch.store', 'uses' => 'XpathController@xpathstore']);
Route::post('/restaurant/{restaurant_id}/new-xpath-lunch/{id}', ['as' => 'xpath.lunch.update', 'uses' => 'XpathController@update']);

// Admin Dashboard
Route::get('/dashboard/all-restaurants', ['as' => 'dashboard.index', 'uses' => 'AdminController@index']);
Route::get('/dashboard/restaurant/create', ['as' => 'dashboard.create', 'uses' => 'AdminController@create']);
Route::post('/dashboard/restaurant', ['as' => 'dashboard.store', 'uses' => 'AdminController@store']);
Route::get('/dashboard/restaurant/{id}/edit', ['as' => 'dashboard.edit', 'uses' => 'AdminController@edit']);
Route::put('/dashboard/restaurant/{id}', ['as' => 'dashboard.update', 'uses' => 'AdminController@update']);
Route::delete('/dashboard/restaurant/{id}', ['as' => 'dashboard.destroy', 'uses' => 'AdminController@destroy']);

// Admin Settings
Route::get('/dashboard/settings', ['as' => 'settings.edit', 'uses' => 'SettingsController@edit']);
Route::put('/dashboard/settings/update', ['as' => 'settings.update', 'uses' => 'SettingsController@update']);
