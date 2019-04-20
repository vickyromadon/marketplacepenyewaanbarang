<?php

namespace App\Mail;

use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaymentConfirmationVerifyToOwner extends Mailable
{
    use Queueable, SerializesModels;

    public $transaction;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $owner      = $this->transaction->booking->product->user;
        $member     = $this->transaction->booking->user;
        
        return $this->to($owner->email, $owner->name)
            ->subject("Payment Confirmation Verify")
            ->view('emails.payment_confirmation_verify_to_owner')
            ->with([
                'owner'         => $owner,
                'transaction'   => $this->transaction,
                'member'        => $member,
            ]);
    }
}
