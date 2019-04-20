<?php

namespace App\Mail;

use App\Models\Booking;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BookingProductApprove extends Mailable
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
        $member         = $this->booking->user;
        $booking_code   = $this->booking->code;
        $product        = $this->booking->product;

        return $this->to($member->email, $member->name)
            ->subject("Approve Booking Code #$booking_code")
            ->view('emails.booking_product_approve')
            ->with([
                'member'    => $member,
                'booking'   => $this->booking,
                'product'   => $product
            ]);
    }
}
