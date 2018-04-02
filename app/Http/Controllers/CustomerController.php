<?php

namespace App\Http\Controllers;

use App\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Return a listing of Customers.
     */
    public function index()
    {
        return Customer::get(['id'])->pluck('id');
    }

    /**
     * Store a Customer in the database.
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
