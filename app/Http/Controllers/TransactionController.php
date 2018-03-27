<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Transaction;
use Illuminate\Http\Request;
use App\Http\Resources\TransactionResource;

class TransactionController extends Controller
{
    /**
     * Display the specified Transaction.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer, Transaction $transaction)
    {
        abort_if($transaction->customer->id != $customer->id, 404);

        return new TransactionResource(Transaction::find(1));
    }
}
