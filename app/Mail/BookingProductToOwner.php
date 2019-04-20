<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BookingProductToOwner extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Booking $booking)
    {
        $this->booking = $booking;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $owner          = $this->booking->product->user;
        $member         = $this->booking->user;
        $booking_code   = $this->booking->code;
        $product        = $this->booking->product;

        return $this->to($owner->email, $owner->name)
            ->subject("RentOnCome Booking Code #$booking_code")
            ->view('emails.booking_product_to_owner')
            ->with([
                'member'    => $member,
                'owner'     => $owner,
                'booking'   => $this->booking,
                'product'   => $product
            ]);
    }
}   
