<?php 

namespace App\Helpers;

use Illuminate\Support\Facades\Mail;
use App\Models\MailQueue;

class MailFailure
{
	/**
     * Sending message.
     *
     * @param  string  $to
     * @param  string  $name
     * @param  string  $subject
     * @param  mail   $body
     */
	public static function mail_failure($to, $name, $subject, $body)
    {
        $mail 				= new MailQueue();
        $mail->from 		= env('MAIL_FROM_ADDRESS');
        $mail->from_name 	= env('MAIL_FROM_NAME');
        $mail->to 			= $to;
        $mail->to_name 		= $name;
        $mail->subject 		= $subject;
        $mail->body 		= $body;
        $mail->save();
    }
}