<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:api')->post('/customer/create', 'CustomerController@store')->name('customer.create');

Route::middleware('auth:api')->group(function () {
    Route::middleware(['transform', 'stripempty'])->get('/transaction', 'TransactionController@index')->name('transaction.index');
    Route::get('/transaction/{customer}/{transaction}', 'TransactionController@show')->name('transaction.show');
    Route::post('/transaction', 'TransactionController@store')->name('transaction.store');
    Route::match(['put', 'patch'], '/transaction/{transaction}', 'TransactionController@update')->name('transaction.update');
    Route::delete('/transaction/{transaction}', 'TransactionController@destroy')->name('transaction.destroy');

    Route::post('/customers', 'CustomerController@index')->name('customer.index');
});
