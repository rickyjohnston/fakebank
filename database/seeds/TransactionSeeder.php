<?php

use App\Customer;
use App\Transaction;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($x = 0; $x < 5; $x++) {
            $customer1 = factory(Customer::class)->create();
            $customer2 = factory(Customer::class)->create();

            factory(Transaction::class, 3)->create(['customer_id' => $customer1]);
            factory(Transaction::class, 2)->create(['customer_id' => $customer2]);
            factory(Transaction::class, 5)->create();
        }
    }
}
