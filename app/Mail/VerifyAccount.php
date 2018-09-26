<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class VerifyAccount extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
   public  $confirmation_code;
   public  $confirmation_status;

     public function __construct($confirmation_code,$confirmation_status)
    {
        //
        $this->confirmation_code = $confirmation_code;
        $this->confirmation_status = $confirmation_status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.mailables.verify')
            ->from(config('app.adminEmail'),config('app.adminEmailName'))
             ->subject('Verify your email address');
    }
}
