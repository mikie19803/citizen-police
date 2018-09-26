<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendCollaborationInvitation extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $toName;
    public $inviteFrom;

    public function __construct($toName,$inviteFrom)
    {
        //
        $this->toName = $toName;
        $this->inviteFrom = $inviteFrom;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.mailables.invitation')
            ->from(config('app.adminEmail'),config('app.adminEmailName'))
            ->subject('Invitation to Collaborate on Case');
    }
}

