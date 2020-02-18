<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Telegram\Bot\Laravel\Facades\Telegram;
use Telegram\Bot\Api;

class TelegramController extends Controller
{
    public function __construct()
    {
    }

    /**
     * My Bot info
     */
    public function getme()
    {
        $telegram = new Api(config('telegram.bots.mybot.token'));

        $response = $telegram->getMe();

        $botId = $response->getId();
        $firstName = $response->getFirstName();
        $username = $response->getUsername();

        dd($response);
    }

    /**
     * Get Telegram updates
     */
    public function getupdates()
    {
        $updates = Telegram::getUpdates();
        return (json_encode($updates));
    }

    public function sendmessage()
    {
        Telegram::sendMessage([
            'chat_id' => 'RECIPIENT_CHAT_ID',
            'text' => 'Hello world!'
        ]);
        return;
    }
}
