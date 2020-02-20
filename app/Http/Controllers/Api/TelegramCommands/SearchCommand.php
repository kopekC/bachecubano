<?php

namespace App\Http\Controllers\Api\TelegramCommands;

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
        $incoming_text = explode(" ", $this->getUpdate()->message->text);
        unset($incoming_text[0]);
        $params = implode(" ", $incoming_text);

        $this->replyWithMessage(['text' => $params]);
    }
}
