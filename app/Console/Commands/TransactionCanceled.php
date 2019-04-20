<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TransactionCanceled extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transaction:cancel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Transaction Canceled';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $transaction = DB::table('transactions')
                        ->join('bookings', 'transactions.booking_id', 'bookings.id')
                        ->where('transactions.status', '=', 'pending')
                        ->whereDate("bookings.start_rent", '<', date('Y-m-d'))
                        ->update(['transactions.status' => 'canceled']);
    }
}
