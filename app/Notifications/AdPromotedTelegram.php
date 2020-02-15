<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

use Illuminate\Support\Str;

class AdPromotedTelegram extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [TelegramChannel::class];
    }

    /**
     * Send this to Telegram Channel
     * <b>bold</b>, <strong>bold</strong>
     * <i>italic</i>, <em>italic</em>
     * <a href="http://www.example.com/">inline URL</a>
     * <a href="tg://user?id=123456789">inline mention of a user</a>
     * <code>inline fixed-width code</code>
     * <pre>pre-formatted fixed-width code block</pre>
     *
     * Add some analitycs to this
     */
    public function toTelegram($ad)
    {

        $telegram_notif = TelegramMessage::create();
        $telegram_notif->to('@elBacheChannel');                                                                                                             //Also the group??
        $telegram_notif->content(Str::limit($ad->description->title, 60) . "\n\n" . Str::limit($ad->description->description, 160));                        //Telegram Notification Text
        $telegram_notif->button('Ver Anuncio', ad_url($ad));                                                                                                //Inline Button
        $telegram_notif->options(['photo' => ad_first_physical_image($ad, 'original'), 'caption' => $ad->description->title, 'parse_mode' => 'HTML']);                 //Photo url or physical??

        return $telegram_notif;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
