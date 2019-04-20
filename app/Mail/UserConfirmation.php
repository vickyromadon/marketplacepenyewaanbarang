<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ( $this->user->privilege == 0 )
            $link = url('/mail_confirmation/' . encrypt($this->user->email . ";" . time()));
        else
            $link = url('owner/mail_confirmation/' . encrypt($this->user->email . ";" . time()));
        
        return $this->to($this->user->email, $this->user->name)
            ->subject("Email Confirmation")
            ->view('emails.email_confirmation')
            ->with([
                'name' => $this->user->name,
                'link' => $link,
            ]);
    }
}
