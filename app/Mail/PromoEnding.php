<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PromoEnding extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $ad_title;
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
    public function __construct($name, $ad_title)
    {
        $this->name = $name;
        $this->ad_title = $ad_title;

        $this->title = 'Hola ' . $this->name . ' 😉👍🏼';
        $this->email_header = 'Tienes un anuncio próximo a vencer su promoción';
        $this->email_title = 'Tu anuncio ' . $this->ad_title . ' va a vencer';
        $this->email_subtitle = "Promociónalo de nuevo y lo verá toda 🇨🇺";
        $this->body_text_title = "Promociona de nuevo tu anuncio " . $this->ad_title;
        $this->body_text_content = "Con las mejores tarifas de Cuba, puede volver a promocionar tu anuncio en Bachecubano, no pierdas tiempo.<br><a href='https://www.bachecubano.com/home'>Accceder a tu panel de usuario</a>";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('contact@bachecubano.com')
            ->subject('Tu promoción en Bachecubano vence pronto (Quedan 3 días)')
            ->view('emails.endingpromo');
    }
}
