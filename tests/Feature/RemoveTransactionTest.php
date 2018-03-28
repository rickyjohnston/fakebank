<?php

namespace Tests\Feature;

use App\Transaction;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use App\User;

class RemoveTransactionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_remove_a_transaction()
    {
        $this->withoutExceptionHandling();
        $transaction = factory(Transaction::class)->create();
        $this->assertCount(1, Transaction::get());

        Passport::actingAs(factory(User::class)->create());
        $response = $this->deleteJson(route('transaction.destroy', $transaction));

        $response->assertStatus(200);
        $this->assertCount(0, Transaction::get());
    }

    /** @test */
    public function an_unauthenticated_user_cannot_remove_a_transaction()
    {
        $transaction = factory(Transaction::class)->create();
        $this->assertCount(1, Transaction::get());

        $response = $this->deleteJson(route('transaction.destroy', $transaction));

        $response->assertStatus(401);
        $this->assertCount(1, Transaction::get());
    }

    /** @test */
    public function deleting_a_transaction_returns_success()
    {
        $this->withoutExceptionHandling();
        $transaction = factory(Transaction::class)->create();

        Passport::actingAs(factory(User::class)->create());
        $response = $this->deleteJson(route('transaction.destroy', $transaction));

        $this->assertSame('success', $response->getContent());
    }
}
