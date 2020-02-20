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
        //Input data here?
        dump($this->getUpdate()->message);

        $this->replyWithMessage(['text' => json_encode($this->getUpdate()->message)]);

        // This will send a message using `sendMessage` method behind the scenes to
        // the user/chat id who triggered this command.
        // `replyWith<Message|Photo|Audio|Video|Voice|Document|Sticker|Location|ChatAction>()` all the available methods are dynamically
        // handled when you replace `send<Method>` with `replyWith` and use the same parameters - except chat_id does NOT need to be included in the array.
        $this->replyWithMessage(['text' => $this->getUpdate()->message->from->username]);
    }
}
