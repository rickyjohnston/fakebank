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

        return response()->json(new TransactionResource($transaction), 200);
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
