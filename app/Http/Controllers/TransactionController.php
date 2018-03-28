<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Transaction;
use App\Http\Resources\TransactionResource;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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

        return new TransactionResource($transaction);
    }

    /**
     * Store a Translation in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'customerId' => 'required|integer',
            'amount'     => 'required|integer',
        ]);

        abort_if(!Customer::find($request->customerId), 400);

        $transaction = Transaction::create([
            'customer_id' => $request->customerId,
            'amount'      => $request->amount,
            'date'        => Carbon::now()->toDateString(),
        ]);

        return new TransactionResource($transaction);
    }

    /**
     * Update a Translation in the database.
     *
     * @param  \App\Transaction          $transaction
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        $amount = $request->validate([
            'amount' => 'required|integer'
        ]);

        $transaction->update($amount);

        return new TransactionResource($transaction);
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
