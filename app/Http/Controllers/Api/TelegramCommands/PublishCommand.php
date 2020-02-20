<?php

namespace App\Http\Controllers\Api\TelegramCommands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class PublishCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "publicar";

    /**
     * @var array Command Aliases
     */
    protected $aliases = ['publish'];

    /**
     * @var string Command Description
     */
    protected $description = "Publicar un anuncio gratis en Bachecubano.com";

    /**
     * @inheritdoc
     */
    public function handle(/*$arguments*/)
    {
        // This will update the chat status to typing...
        $this->replyWithChatAction(['action' => Actions::TYPING]);

        // This will send a message using `sendMessage` method behind the scenes to
        // the user/chat id who triggered this command.
        // `replyWith<Message|Photo|Audio|Video|Voice|Document|Sticker|Location|ChatAction>()` all the available methods are dynamically
        // handled when you replace `send<Method>` with `replyWith` and use the same parameters - except chat_id does NOT need to be included in the array.
        $this->replyWithMessage(['text' => "Que tal " . $this->getUpdate()->message->from->username . "!!.\n\nPublicar anuncios es GRATIS, solo tienes que acceder aqui:\n\nhttps://www.bachecubano.com/add"]);
    }
}
