<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TransferReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $receiver;
    public $amount;
    public $title;
    public $email_header;
    public $email_title;
    public $email_subtitle;
    public $body_text_title;
    public $body_text_content;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($receiver, $amount)
    {
        $this->receiver = $receiver;
        $this->amount = $amount;

        $this->title = 'Te han transferido ' . $this->amount . ' en Bachecubano.com';
        $this->email_header = "Se ha recargado su cuenta correctamente";
        $this->email_title = 'Te han transferido ' . $this->amount . ' en Bachecubano.com';
        $this->email_subtitle = "Ya posees saldo para realizar promociones y enviar SMS a 🇨🇺";
        $this->body_text_title = "Se ha recargado su cuenta";
        $this->body_text_content = "Te han transferido la cantidad de " . $amount . " a tu cuenta de Bachecubano. Ya puedes empezar a promocionar anuncios.";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('contact@bachecubano.com')
            ->subject('Te han transferido ' . $this->amount . ' en Bachecubano.com')
            ->view('emails.transfer');
    }
}
