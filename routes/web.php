<?php

Route::get('/', 'HomeController@index');

Auth::routes();

Route::group(['middleware' => 'auth'], function() {
	Route::get('/home', 'HomeController@add_trip')->name('home');
	Route::post('trips', 'TripsController@add_trip')->name('add_trip');
	Route::post('price/get', 'TripsController@get_price')->name('get_price');
	Route::post('promo/get', 'TripsController@promo')->name('promo');
});