<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Contact extends Mailable
{
    use Queueable, SerializesModels;

    public $remitente_data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($remitente_data)
    {
        $this->remitente_data = $remitente_data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('contact@bachecubano.com')
            ->subject('Nuevo contacto vía Bachecubano')
            ->view('emails.contact');
    }
}
