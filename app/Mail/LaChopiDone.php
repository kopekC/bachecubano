<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class LaChopiDone extends Mailable
{
    use Queueable, SerializesModels;

    public $generation_logs;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($generation_logs)
    {
        $this->generation_logs = $generation_logs;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.lachopi');
    }
}
