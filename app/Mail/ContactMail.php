<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($fields, $type)
    {
        $this->fields = $fields;
        $this->type = $type;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->from('mailer@connexus-live.co.uk')
            ->subject('Portal Lines Claim - '. $this->type)
            ->view('emails.ContactMail')
            ->with([
                'fields' => $this->fields,
                'type' => $this->type
            ]);
    }
}
