<?php

namespace App\Mail;

use App\Models\Delivery;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ConfirmationDelivery extends Mailable
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
        $owner          = $this->delivery->transaction->booking->product->user;
        $booking        = $this->delivery->transaction->booking;
        $product        = $this->delivery->transaction->booking->product;

        return $this->to($owner->email, $owner->name)
            ->subject("Confirmation Delivery")
            ->view('emails.confirmation_delivery')
            ->with([
                'owner'     => $owner,
                'delivery'   => $this->delivery,
                'product'   => $product,
                'booking'   => $booking,
            ]);
    }
}
