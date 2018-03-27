<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;
use App\Customer;

class AddCustomerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Helper function. Get the valid parameters to create a Customer.
     *
     * TODO: Add 'cnp' as well
     *
     * @return Array
     */
    public function validParams()
    {
        return [
            'name' => 'James Franco'
        ];
    }

    /** @test */
    public function a_customer_can_not_be_added_without_authentication()
    {
        $response = $this->postJson(route('customer.create'), $this->validParams());

        $response->assertStatus(401);
    }

    /** @test */
    public function a_customer_can_be_added_in_an_authenticated_session()
    {
        Passport::actingAs(factory(User::class)->create());

        $response = $this->postJson(route('customer.create'), $this->validParams());

        $response->assertStatus(200);
        $this->assertCount(1, Customer::where('name', 'James Franco')->get());
    }

    /** @test */
    public function creating_a_customer_returns_correct_json()
    {
        Passport::actingAs(factory(User::class)->create());

        $response = $this->postJson(route('customer.create'), $this->validParams());

        $response->assertJson(['customerId' => Customer::all()->first()->id]);
    }

    /** @test */
    public function name_must_be_present()
    {
        Passport::actingAs(factory(User::class)->create());

        $response = $this->postJson(route('customer.create'), ['notname' => 'Not A Name']);

        $response->assertStatus(422);
    }

    /** @test */
    public function name_must_be_a_string()
    {
        Passport::actingAs(factory(User::class)->create());

        $response = $this->postJson(route('customer.create'), ['name' => 1234]);

        $response->assertStatus(422);
    }
}
