<?php

namespace Tests\Feature;

use App\Customer;
use App\Transaction;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class RetrieveTransactionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_retrieve_a_transaction_with_valid_parameters()
    {
        $customer = factory(Customer::class)->create();
        $transaction = factory(Transaction::class)->create([
            'customer_id' => $customer->id,
            'amount'      => 2700
        ]);
        Passport::actingAs(factory(User::class)->create());

        $response = $this->getJson(route('transaction.show', [
            'customer'    => $customer,
            'transaction' => $transaction
        ]));

        $response->assertStatus(200);
        $response->assertJson([
            'transactionId' => $transaction->id,
            'amount'        => 27.00,
            'date'          => $transaction->date->toDateString(),
        ]);
    }

    /** @test */
    public function an_unauthenticated_user_can_not_retrive_a_transaction_with_valid_parameters()
    {
        $customer = factory(Customer::class)->create();
        $transaction = factory(Transaction::class)->create(['customer_id' => $customer->id]);

        $response = $this->getJson(route('transaction.show', [
            'customer'    => $customer,
            'transaction' => $transaction
        ]));

        $response->assertStatus(401);
    }

    /** @test */
    public function a_404_is_thrown_if_customer_and_transaction_do_not_match()
    {
        $customerA = factory(Customer::class)->create();
        $customerB = factory(Customer::class)->create();
        $transaction = factory(Transaction::class)->create(['customer_id' => $customerA->id]);
        Passport::actingAs(factory(User::class)->create());

        $response = $this->getJson(route('transaction.show', [
            'customer'    => $customerB,
            'transaction' => $transaction,
        ]));

        $response->assertStatus(404);
    }
}
