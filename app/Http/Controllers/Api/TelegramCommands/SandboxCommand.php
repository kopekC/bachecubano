<?php

namespace App\Http\Controllers\Api\TelegramCommands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class SandboxCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = 'sandbox';

    /**
     * @var array Command Aliases
     */
    protected $aliases = ['testing'];

    /**
     * @var string Command Description
     */
    protected $description = 'Comando para pruebas de desarrollo, se recomienda no tocarlo';

    /**
     * {@inheritdoc}
     */
    public function handle()
    {
        // This will send a message using `sendMessage` method behind the scenes to
        // the user/chat id who triggered this command.
        // `replyWith<Message|Photo|Audio|Video|Voice|Document|Sticker|Location|ChatAction>()` all the available methods are dynamically
        // handled when you replace `send<Method>` with `replyWith` and use the same parameters - except chat_id does NOT need to be included in the array.
        $this->replyWithMessage(['text' => $this->getUpdate()->message->from->username]);
    }
}
