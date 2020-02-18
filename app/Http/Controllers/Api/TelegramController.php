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
     * Already configured
     * https://core.telegram.org/bots/inline
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
     * Get Telegram updates via getUpdate method
     * Migrar luego este endpoint a webhook ok?
     * Obtained: https://core.telegram.org/bots/api#update
     */
    public function getupdates()
    {
        $updates = Telegram::getUpdates();

        /**
         * update_id
         * message
         * edited_message
         * channel_post
         * edited_channel_post
         * inline_query
         * chosen_inline_result
         * callback_query
         * shipping_query
         * pre_checkout_query
         * poll
         * poll_answer
         */

        if (count($updates) > 0) {
            foreach ($updates as $update) {
                dump($update);
                dump($update['update_id']);
                dump($update['message']);
                dump($update['message']['message_id']);
                dump($update['message']['from']);
                dump($update['message']['from']['id']);
                dump($update['message']['from']['first_name']);
                dump($update['message']['from']['username']);
                dump($update['message']['chat']['id']);
                dump($update['message']['chat']['type']);               //private, group, supergroup, channel
                dump($update['message']['date']);
                dump($update['message']['text']);
            }
        }

        return (json_encode($updates));
    }

    /**
     * When the bot is ready, just set Webhook
     */
    public function webhook()
    {
        var_dump(file_get_contents('php://input'));
    }

    /**
     * Enviar mensaje de vuelta a sender
     */
    public function sendmessage($recipient = '', $text = '')
    {
        $rsp = Telegram::sendMessage([
            'chat_id' => '572772742',
            'text' => 'Hello world!'
        ]);

        dd($rsp);
    }
}
