<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
    }

    public function imap_check()
    {
    }
}
