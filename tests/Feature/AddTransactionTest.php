<?php

namespace Tests\Feature;

use App\User;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Customer;
use App\Transaction;
use Illuminate\Support\Carbon;

class AddTransactionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_authenticated_user_can_add_a_transaction()
    {
        $customer = factory(Customer::class)->create();
        Passport::actingAs(factory(User::class)->create());
        $this->assertCount(0, Transaction::get());

        $response = $this->postJson(route('transaction.store'), [
            'customerId' => $customer->id,
            'amount'     => 5000
        ]);

        $response->assertStatus(201);
        $this->assertCount(1, Transaction::get());
    }

    /** @test */
    public function an_unauthenticated_user_can_not_add_a_transaction()
    {
        $customer = factory(Customer::class)->create();
        $this->assertCount(0, Transaction::get());

        $response = $this->postJson(route('transaction.store'), [
            'customerId' => $customer->id,
            'amount'     => 5000
        ]);

        $response->assertStatus(401);
        $this->assertCount(0, Transaction::get());
    }

    /** @test */
    public function the_newly_created_resource_is_returned_on_success()
    {
        $customer = factory(Customer::class)->create();
        Passport::actingAs(factory(User::class)->create());

        $response = $this->postJson(route('transaction.store'), [
            'customerId' => $customer->id,
            'amount'     => 5000
        ]);

        $response->assertJson([
            'customerId' => $customer->id,
            'amount'     => 50.00,
            'date'       => Carbon::now()->toDateString(),
        ]);
    }

    /** @test */
    public function customer_id_must_be_an_existing_customer()
    {
        Passport::actingAs(factory(User::class)->create());

        $response = $this->postJson(route('transaction.store'), [
            'customerId' => 2,
            'amount'     => 5000
        ]);

        $response->assertStatus(400);
    }

    /** @test */
    public function customer_id_must_be_a_number()
    {
        Passport::actingAs(factory(User::class)->create());

        $response = $this->postJson(route('transaction.store'), [
            'customerId' => 'blue',
            'amount'     => 5000
        ]);

        $response->assertStatus(422);
    }

    /** @test */
    public function amount_must_be_a_number()
    {
        $customer = factory(Customer::class)->create();
        Passport::actingAs(factory(User::class)->create());

        $response = $this->postJson(route('transaction.store'), [
            'customerId' => $customer->id,
            'amount'     => 'blue'
        ]);

        $response->assertStatus(422);
    }
}
