<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Ad;

class AdPublished extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Public data available to the email view
     */
    public $ad;
    public $user_data;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Ad $ad, $user_data)
    {
        $this->ad = $ad;
        $this->user_data = $user_data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.published')
            ->text('emails.published_plain');
    }
}
