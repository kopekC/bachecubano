<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Fetch\Server;

class ImapController extends Controller
{
    private $driver;
    private $imap_cnx;

    public function __construct()
    {
        $imap_server = config('imap.imap_server');
        $imap_port = config('imap.imap_port');
        $imap_user = config('imap.imap_user');
        $imap_password = config('imap.imap_password');

        $this->driver = new Server($imap_server, $imap_port);

        dump($this->driver);

        $this->driver->setAuthentication($imap_user, $imap_password);

        dump($this->driver);
    }

    public function imap_check()
    {
        /** @var Message[] $message */
        $messages = $this->driver->getMessages(10);
        dump($messages);
    }
}
