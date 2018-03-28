<?php

namespace Tests\Feature;

use App\Transaction;
use App\User;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateTransactionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_update_a_transaction()
    {
        $transaction = factory(Transaction::class)->create();
        Passport::actingAs(factory(User::class)->create());
        $this->assertNotEquals(95.00, $transaction->amount);

        $this->patchJson(route('transaction.update', $transaction), [
            'amount' => 9500
        ]);

        $this->assertEquals(95.00, $transaction->fresh()->amount);
    }

    /** @test */
    public function an_unauthenticated_user_can_not_update_a_transaction()
    {
        $transaction = factory(Transaction::class)->create();

        $response = $this->patchJson(route('transaction.update', $transaction), [
            'amount' => 9500
        ]);

        $response->assertStatus(401);
        $this->assertNotEquals(95.00, $transaction->fresh()->amount);
    }

    /** @test */
    public function correct_json_is_returned()
    {
        $transaction = factory(Transaction::class)->create();
        Passport::actingAs(factory(User::class)->create());
        $this->assertNotEquals(95.00, $transaction->amount);

        $response = $this->patchJson(route('transaction.update', $transaction), [
            'amount' => 9500
        ]);

        $response->assertJson([
            'transactionId' => $transaction->id,
            'customerId'    => $transaction->customer_id,
            'amount'        => 95.00,
            'date'          => $transaction->date->toDateString(),
        ]);
    }

    /** @test */
    public function amount_must_be_an_integer()
    {
        $transaction = factory(Transaction::class)->create();
        Passport::actingAs(factory(User::class)->create());

        $response = $this->patchJson(route('transaction.update', $transaction), [
            'amount' => 'cat'
        ]);

        $response->assertStatus(422);
        $this->assertEquals($transaction->amount, Transaction::first()->amount);
    }
}
