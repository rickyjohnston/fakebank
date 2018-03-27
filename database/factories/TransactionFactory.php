<?php

use Faker\Generator as Faker;
use Illuminate\Support\Carbon;
use App\Customer;

$factory->define(App\Transaction::class, function (Faker $faker) {
    return [
        'amount'      => 2700,
        'customer_id' => function () {
            return factory(Customer::class)->create()->id;
        },
        'date'   => Carbon::now()
    ];
});
