<?php

namespace App\Mail;

use App\Models\Delivery;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ArriveProduct extends Mailable
{
    use Queueable, SerializesModels;

    public $delivery;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Delivery $delivery)
    {
        $this->delivery = $delivery;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $booking        = $this->delivery->transaction->booking;
        $product        = $this->delivery->transaction->booking->product;
        $owner          = $this->delivery->transaction->booking->product->user;

        return $this->to($owner->email, $owner->name)
            ->subject("Delivery Product")
            ->view('emails.arrive_product')
            ->with([
                'owner'     => $owner,
                'delivery'   => $this->delivery,
                'product'   => $product,
                'booking'   => $booking,
            ]);
    }
}
