<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PaymentConfirmationCanceled extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'payment_confirmation:cancel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Payment Confirmation Canceled';

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
                        ->where( function($q){
                            $q->where("transactions.status_payment", '=', "empty")
                            ->orWhere("transactions.status_payment", '=', "pending");
                        })
                        ->where("transactions.payment_method", '=', "rekber")
                        ->whereDate("bookings.start_rent", '<', date('Y-m-d'))
                        ->update(['transactions.status' => 'canceled']);
    }
}
