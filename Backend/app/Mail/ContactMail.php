<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    use Queueable, SerializesModels;
    public $name;
    public $tomail;
    public $subject1;
    public $bodymessage;
    public $fromemail;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $subject, $message, $email)
    {
        $this->name = $name;

        $this->subject1 = $subject;
        $this->bodymessage = $message;
        $this->fromemail = $email;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->view('mail.contactmail')->subject($this->subject1)->from($this->fromemail);
    }
}
