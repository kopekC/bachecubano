<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PopularAd extends Mailable
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
    public function __construct($ad, $amount)
    {
        $this->receiver = $ad->owner;
        $this->amount = $amount;

        $this->title = 'Te acabas de ganar ' . $this->amount . 'cuc en Bachecubano.com';
        $this->email_header = "Se ha recargado su cuenta correctamente";
        $this->email_title = 'Tienes anuncios populares, por eso te premiamos con ' . $this->amount . 'cuc en Bachecubano.com';
        $this->email_subtitle = "Ya posees saldo para realizar promociones y enviar SMS a 🇨🇺";
        $this->body_text_title = "Se ha recargado su cuenta";
        $this->body_text_content = "Tienes anuncios populares, por eso te premiamos con " . $amount . "cuc en tu cuenta de Bachecubano.<br>Mira tu anuncio y compártelo en tus redes sociales!<br><br><a href='" . ad_url($ad) . "'>" . ad_url($ad) . "</a><br><br>Ya puedes empezar a promocionar anuncios.";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('contact@bachecubano.com')
            ->cc('ecruz@bachecubano.com')
            ->subject('Te han transferido ' . $this->amount . ' en Bachecubano.com')
            ->view('emails.transfer');
    }
}
