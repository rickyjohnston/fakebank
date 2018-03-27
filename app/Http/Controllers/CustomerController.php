<?php

namespace App\Http\Controllers;

use App\User;
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

        $user = User::create([
            'name' => $request->name
        ]);

        return ['customerId' => $user->id];
    }
}
