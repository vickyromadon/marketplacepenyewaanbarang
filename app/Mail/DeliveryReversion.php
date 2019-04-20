<?php

namespace App\Mail;

use App\Models\Reversion;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DeliveryReversion extends Mailable
{
    use Queueable, SerializesModels;

    public $reversion;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Reversion $reversion)
    {
        $this->reversion = $reversion;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $booking        = $this->reversion->delivery->transaction->booking;
        $product        = $this->reversion->delivery->transaction->booking->product;
        $owner          = $this->reversion->delivery->transaction->booking->product->user;
        $member         = $this->reversion->delivery->transaction->booking->user;

        return $this->to($owner->email, $owner->name)
            ->subject("Delivery Reversion Product")
            ->view('emails.delivery_reversion')
            ->with([
                'owner'    => $owner,
                'reversion' => $this->reversion,
                'product'   => $product,
                'booking'   => $booking,
            ]);
    }
}
