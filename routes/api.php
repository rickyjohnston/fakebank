<?php

Route::middleware('auth:api')->post('/customer/create', 'CustomerController@store')->name('customer.create');

Route::middleware('auth:api')->get('/transaction/{customer}/{transaction}', 'TransactionController@show')->name('transaction.show');
Route::middleware('auth:api')->delete('/transaction/{transaction}', 'TransactionController@destroy')->name('transaction.destroy');
