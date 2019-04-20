<?php

namespace App\Mail;

use App\Models\Delivery;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeliveryProduct extends Mailable
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
        $member         = $this->delivery->transaction->booking->user;
        $booking        = $this->delivery->transaction->booking;
        $product        = $this->delivery->transaction->booking->product;

        return $this->to($member->email, $member->name)
            ->subject("Delivery Product")
            ->view('emails.delivery_product')
            ->with([
                'member'     => $member,
                'delivery'   => $this->delivery,
                'product'   => $product,
                'booking'   => $booking,
            ]);
    }
}
