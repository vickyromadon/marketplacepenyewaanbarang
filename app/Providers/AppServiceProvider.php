<?php

namespace App\Providers;

use App\Models\Booking;
use App\Models\Delivery;
use App\Models\Refund;
use App\Models\Reversion;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        view()->composer('*', function($view) {
            if( Auth::user() != null){
                $view->with([
                        'bookingOwner'              => DB::table('bookings')
                                                        ->join('products', 'bookings.product_id', 'products.id')
                                                        ->where('bookings.status', 'pending')
                                                        ->where('products.user_id', Auth::user()->id)
                                                        ->get(),

                        'transactionRekberOwner'    => DB::table('transactions')
                                                        ->join('bookings', 'transactions.booking_id', 'bookings.id')
                                                        ->join('products', 'bookings.product_id', 'products.id')
                                                        ->where('transactions.status', 'pending')
                                                        ->where('transactions.payment_method', 'rekber')
                                                        ->where('products.user_id', Auth::user()->id)
                                                        ->get(),

                        'transactionCodOwner'    => DB::table('transactions')
                                                        ->join('bookings', 'transactions.booking_id', 'bookings.id')
                                                        ->join('products', 'bookings.product_id', 'products.id')
                                                        ->where('transactions.status', 'pending')
                                                        ->where('transactions.payment_method', 'cod')
                                                        ->where('products.user_id', Auth::user()->id)
                                                        ->get(),

                        'transactionPaymentAdmin'   => Transaction::where('status_payment', 'pending')
                                                        ->where('payment_method', 'rekber')
                                                        ->get(),


                        'deliveryOwner'             => DB::table('deliveries')
                                                        ->join('transactions', 'deliveries.transaction_id', 'transactions.id')
                                                        ->join('bookings', 'transactions.booking_id', 'bookings.id')
                                                        ->join('products', 'bookings.product_id', 'products.id')
                                                        ->where('deliveries.status', 'pending')
                                                        ->where('products.user_id', Auth::user()->id)
                                                        ->get(),

                        'reversionOwner'            => DB::table('reversions')
                                                        ->join('deliveries', 'reversions.delivery_id', 'deliveries.id')
                                                        ->join('transactions', 'deliveries.transaction_id', 'transactions.id')
                                                        ->join('bookings', 'transactions.booking_id', 'bookings.id')
                                                        ->join('products', 'bookings.product_id', 'products.id')
                                                        ->where('reversions.status', 'delivered')
                                                        ->where('products.user_id', Auth::user()->id)
                                                        ->get(),

                        'refundOwner'               => DB::table('refunds')
                                                        ->join('transactions', 'refunds.transaction_id', 'transactions.id')
                                                        ->join('bookings', 'transactions.booking_id', 'bookings.id')
                                                        ->join('products', 'bookings.product_id', 'products.id')
                                                        ->where('refunds.status', 'pending')
                                                        ->where('products.user_id', Auth::user()->id)
                                                        ->get(),

                        'refundAdmin'               => Refund::where('status', 'verified')
                                                        ->get(),

                ]);
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
