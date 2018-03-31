<?php

namespace App\Console\Commands;

use App\DailyTransactionTotal;
use App\Transaction;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class SumTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transaction:sum {date?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Store the total of the previous day's transactions";

    /**
     * The date to total the sum of transactions for.
     *
     * @var \Illuminate\Support\Carbon
     */
    protected $date;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $date = $this->argument('date') ?? Carbon::now()->toDateString();

        $total = $this->totalForDate($date);

        DailyTransactionTotal::create([
            'amount' => ($total * 100)
        ]);
    }

    /**
     * Return the total amount for the specified date.
     *
     * @param  String   $date
     * @return Number
     */
    public function totalForDate($date)
    {
        $transactions = Transaction::where('date', $date)->get();

        return $transactions->pluck('amount')->sum();
    }
}
