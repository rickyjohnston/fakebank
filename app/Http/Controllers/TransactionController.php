<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Transaction;
use App\Http\Resources\TransactionResource;

class TransactionController extends Controller
{
    /**
     * Display the specified Transaction.
     *
     * @param  \App\Customer     $customer
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer, Transaction $transaction)
    {
        abort_if($transaction->customer->id != $customer->id, 404);

        return new TransactionResource(Transaction::find(1));
    }

    /**
     * Remove the specified Transaction from storage.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        if ($transaction->delete()) {
            return 'success';
        }

        return 'fail';
    }
}
