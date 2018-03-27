<?php

Route::middleware('auth:api')
    ->post('/customer/create', 'CustomerController@store')
    ->name('customer.create');
