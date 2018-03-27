<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Store a Customer resource in the database.
     *
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        $customer = Customer::create([
            'name' => $request->name
        ]);

        return ['customerId' => $customer->id];
    }
}
