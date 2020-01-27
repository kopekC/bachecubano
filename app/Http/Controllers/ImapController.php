<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use greeny\MailLibrary\Drivers\ImapDriver;
use greeny\MailLibrary\Connection;

error_reporting(-1);
ini_set('display_errors', 1);

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

        $this->driver = new ImapDriver($imap_user, $imap_password, $imap_server, $imap_port, FALSE);
        $this->imap_cnx = new Connection($this->driver);
    }



    public function imap_check()
    {
        dd($this->imap_cnx);
    }
}
