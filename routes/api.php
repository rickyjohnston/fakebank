<?php

Route::middleware('auth:api')->post('/customer/create', 'CustomerController@store')->name('customer.create');

Route::middleware('auth:api')->group(function () {
    Route::get('/transaction/{customer}/{transaction}', 'TransactionController@show')->name('transaction.show');
    Route::post('/transaction', 'TransactionController@store')->name('transaction.store');
    Route::delete('/transaction/{transaction}', 'TransactionController@destroy')->name('transaction.destroy');
});
