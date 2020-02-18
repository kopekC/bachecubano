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
        //$botId = $response->getId();
        //$firstName = $response->getFirstName();
        //$username = $response->getUsername();
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
                dump(isset($update['message']['from']['username']) ? $update['message']['from']['username'] : "");
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
        $update = json_decode(file_get_contents('php://input'));

        /*
        var_dump($update);
        var_dump($update['update_id']);
        var_dump($update['message']);
        var_dump($update['message']['message_id']);
        var_dump($update['message']['from']);
        var_dump($update['message']['from']['id']);
        var_dump($update['message']['from']['first_name']);
        var_dump($update['message']['from']['username']);
        var_dump($update['message']['chat']['id']);
        var_dump($update['message']['chat']['type']);               //private, group, supergroup, channel
        var_dump($update['message']['date']);
        var_dump($update['message']['text']);
        */

        var_dump($update);
        var_dump($update->message->text);

        $method = explode(" ", $update->message->text)[0];

        switch ($method) {
            case "info":
                return $this->info($update->message->from);
                break;
            default:
                return "None command";
        }
    }

    /**
     * Enviar mensaje de vuelta a sender
     */
    public function sendmessage($recipient = '', $text = '')
    {
        //Send Message to the recipient
        $rsp = Telegram::sendMessage([
            'chat_id' => $recipient->id,           //572772742 myself
            'text' => $text
        ]);
    }

    /**
     * Send INFO about the bot
     * Some list of commands 
     */
    private function info($from)
    {
        $text = "Hola " . $from->first_name . "! 👋\n\nInfo del Bot y listado de comandos:";
        $this->sendmessage($from, $text);
    }
}
