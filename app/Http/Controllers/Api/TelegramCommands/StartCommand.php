<?php

namespace App\Http\Controllers\Api\TelegramCommands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class StartCommand extends Command
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
        // This will send a message using `sendMessage` method behind the scenes to
        // the user/chat id who triggered this command.
        // `replyWith<Message|Photo|Audio|Video|Voice|Document|Sticker|Location|ChatAction>()` all the available methods are dynamically
        // handled when you replace `send<Method>` with `replyWith` and use the same parameters - except chat_id does NOT need to be included in the array.
        $this->replyWithMessage(['text' => "Que tal " . $this->telegram->getUpdate() . ".\n\nPublicar anuncios es GRATIS, solo tienes que acceder aqui:\n\nhttps://www.bachecubano.com/add"]);

        // This will update the chat status to typing...
        $this->replyWithChatAction(['action' => Actions::TYPING]);

        // Trigger another command dynamically from within this command
        // When you want to chain multiple commands within one or process the request further.
        // The method supports second parameter arguments which you can optionally pass, By default
        // it'll pass the same arguments that are received for this command originally.
        //$this->triggerCommand('subscribe');
    }
}
