<?php

namespace Tests\Unit;

use App\Console\Commands\SumTransactions;
use App\DailyTransactionTotal;
use App\Transaction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class SumTransactionsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function when_no_date_is_input_it_uses_current_date()
    {
        $mockCommand = \Mockery::mock('\App\Console\Commands\SumTransactions[totalForDate]', [new \Illuminate\Filesystem\Filesystem()]);
        $mockCommand->shouldReceive('totalForDate')->once()->with(Carbon::now()->toDateString());

        $this->app['Illuminate\Contracts\Console\Kernel']->registerCommand($mockCommand);
        
        $this->artisan('transaction:sum');
    }

    /** @test */
    public function it_stores_the_total_in_the_database()
    {
        factory(Transaction::class, 9)->create(['date' => Carbon::now(), 'amount' => 2700]);
        factory(Transaction::class)->create(['date' => Carbon::now(), 'amount' => 2575]);

        $total = Transaction::get()->pluck('amount')->sum();

        $this->assertEmpty(DailyTransactionTotal::get());

        $this->artisan('transaction:sum');

        $this->assertSame($total, DailyTransactionTotal::first()->amount);
    }

    /** @test */
    public function it_can_run_on_days_without_transactions()
    {
        $this->assertEmpty(DailyTransactionTotal::get());

        $this->artisan('transaction:sum');

        $this->assertEquals(0, DailyTransactionTotal::first()->amount);
    }
}
