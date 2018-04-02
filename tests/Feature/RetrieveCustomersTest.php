<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use App\User;
use App\Customer;

class RetrieveCustomersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function all_customer_ids_can_be_retrieved()
    {
        $this->withoutExceptionHandling();
        factory(Customer::class, 10)->create();
        
        Passport::actingAs(factory(User::class)->create());
        $response = $this->post(route('customer.index'));

        $response->assertStatus(200);
        $this->assertCount(10, json_decode($response->getContent()));
    }
}
