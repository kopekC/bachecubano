<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Ad;
use Illuminate\Support\Str;

class AdPublished extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Public data available to the email view
     */
    public $ad;
    public $user_data;
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
    public function __construct(Ad $ad, $user_data)
    {
        $this->ad = $ad;
        $this->user_data = $user_data;
        $this->title = "Anuncio publicado en Bachecubano";
        $this->email_header = "Se ha publicado su anuncio correctamente";
        $this->email_title = "Se ha publicado su anuncio 👍";
        $this->email_subtitle = "Ahora serás mucho más popular y visible en internet y en 🇨🇺";
        $this->body_text_title = $ad->description->title;
        $this->body_text_content = text_clean(Str::limit($ad->description->description, 160));
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("Se ha publicado su anuncio en Bachecubano")
            ->view('emails.published')
            ->text('emails.published_plain');
    }
}
