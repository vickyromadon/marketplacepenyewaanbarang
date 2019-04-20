<?php

namespace App\Console\Commands;

use App\Models\Booking;
use Illuminate\Console\Command;

class BookingCanceled extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'booking:cancel';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Booking Canceled';

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
        $booking = Booking::where("status", '=', "pending")
                    ->whereDate("start_rent", '<', date('Y-m-d'))
                    ->get();

        foreach ($booking as $item) {
            $item->status = 'canceled';
            $item->save();
        }
    }
}
