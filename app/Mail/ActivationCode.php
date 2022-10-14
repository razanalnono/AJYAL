<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ActivationCode extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($password)
    {
        //
        $this->password=$password;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
return $this->markdown('emails.activate')->with(['password'=>$this->password]);
    }
}