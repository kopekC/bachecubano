<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

use Illuminate\Support\Str;

class AdPromoted extends Notification
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
     */
    public function toTelegram($ad)
    {
        $telegram_notif = TelegramMessage::create();
        $telegram_notif->to('@elBacheChannel');
        $telegram_notif->content(text_clean(Str::limit($ad->description->title, 60)));                  // Markdown supported.

        //Production or Testing URL
        if (config('app.env') == "production") {
            $telegram_notif->button('Ver Anuncio', ad_url($ad)); // Inline Button
        } else {
            $telegram_notif->button('Ver Anuncio', 'https://www.bachecubano.com'); // Inline Button, comprobar si se puede agregar mas de un boton
        }

        //Photo test option
        $telegram_notif->options(['photo' => ad_image_url($ad, 'original'), 'caption' => $ad->description->title]);

        return $telegram_notif;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
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
