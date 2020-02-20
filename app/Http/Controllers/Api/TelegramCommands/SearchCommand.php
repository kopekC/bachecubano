<?php

namespace App\Http\Controllers\Api\TelegramCommands;

use App\Http\Controllers\AdController;
use Illuminate\Http\Request;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class SearchCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = 'buscar';

    /**
     * @var array Command Aliases
     */
    protected $aliases = ['search'];

    /**
     * @var string Command Description
     */
    protected $description = 'Buscar anuncios en Bachecubano desde Telegram';

    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        //Pretty Reply
        $this->replyWithMessage(['text' => "getMessage()" . json_encode($this->getUpdate()->getMessage()->getText())]);
        exit;

        if (!isset($this->getUpdate()->message->text)) {
            //Verify for search term
            $this->replyWithMessage(['text' => "Debes escribir lo que deseas buscar, ej: /buscar xiaomi"]);
        } else {
            //Explode incoming text
            $incoming_text = explode(" ", $this->getUpdate()->message->text);
            unset($incoming_text[0]);
            $params = implode(" ", $incoming_text);

            //Instantiate Request object
            $request = new Request();
            $request->merge(['s' => urlencode($params)]);

            //Get Ads from static method getAds
            $ads = AdController::getAds($request, null, 5, null, true);

            //Pretty Reply
            $this->replyWithMessage(['text' => json_encode($ads)]);

            //Pretty Reply
            $this->replyWithMessage(['text' => $params]);
        }
    }
}
