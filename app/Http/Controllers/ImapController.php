<?php

error_reporting(-1);
ini_set('display_errors', 1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use greeny\MailLibrary\Drivers\ImapDriver;

class ImapController extends Controller
{
    private $imap_cnx;

    public function __construct()
    {
        $imap_server = config('imap.imap_server');
        $imap_port = config('imap.imap_port');
        $imap_user = config('imap.imap_user');
        $imap_password = config('imap.imap_password');
        
        $this->imap_cnx = new ImapDriver('john', 'doe', 'mail.example.com', 993, TRUE); // John Doe wants secured connection
    }

    public function imap_check()
    {
    }
}
