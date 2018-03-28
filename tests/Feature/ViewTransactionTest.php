<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Transaction;
use Laravel\Passport\Passport;
use App\User;
use App\Customer;
use Illuminate\Support\Carbon;

class ViewTransactionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_users_can_get_a_paginated_list_of_transactions()
    {
        factory(Transaction::class, 10)->create();
        Passport::actingAs(factory(User::class)->create());

        $response = $this->getJson(route('transaction.index'));

        $response->assertStatus(200);
        $this->assertCount(5, json_decode($response->getContent())->data);
    }

    /** @test */
    public function unauthenticated_users_can_not_get_any_transactions()
    {
        factory(Transaction::class, 2)->create();

        $response = $this->getJson(route('transaction.index'));

        $response->assertStatus(401);
    }

    /** @test */
    public function transactions_can_be_filtered_by_customer_id()
    {
        $customerA = factory(Customer::class)->create();
        $customerB = factory(Customer::class)->create();

        factory(Transaction::class)->create(['customer_id' => $customerA]);
        factory(Transaction::class, 6)->create(['customer_id' => $customerB]);
        factory(Transaction::class, 2)->create(['customer_id' => $customerA]);

        Passport::actingAs(factory(User::class)->create());
        $response = $this->getJson(route('transaction.index', ['customerId' => $customerA->id]));

        $response->assertStatus(200);
        $this->assertCount(3, json_decode($response->getContent())->data);
    }

    /** @test */
    public function transactions_can_be_filtered_by_amount()
    {
        factory(Transaction::class)->create(['amount' => 4500]);
        factory(Transaction::class, 6)->create(['amount' => 6000]);
        factory(Transaction::class, 2)->create(['amount' => 4500]);

        Passport::actingAs(factory(User::class)->create());
        $response = $this->getJson(route('transaction.index', ['amount' => 4500]));

        $response->assertStatus(200);
        $this->assertCount(3, json_decode($response->getContent())->data);
    }

    /** @test */
    public function transactions_can_be_filtered_by_date()
    {
        factory(Transaction::class)->create(['date' => Carbon::now()->toDateString()]);
        factory(Transaction::class, 6)->create(['date' => Carbon::now()->subMonth()->toDateString()]);
        factory(Transaction::class, 2)->create(['date' => Carbon::now()->toDateString()]);

        Passport::actingAs(factory(User::class)->create());
        $response = $this->getJson(route('transaction.index', ['date' => Carbon::now()->toDateString()]));

        $response->assertStatus(200);
        $this->assertCount(3, json_decode($response->getContent())->data);
    }
}
