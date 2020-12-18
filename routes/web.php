<?php


Route::get('checkout', 'CheckoutController@index');
Route::get('response', 'ResponseController@index');
Route::get('/checkout/{type}', 'CheckoutController@type');



