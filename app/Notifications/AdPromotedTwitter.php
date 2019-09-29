<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use NotificationChannels\Twitter\TwitterChannel;
use NotificationChannels\Twitter\TwitterStatusUpdate;

class AdPromotedTwitter extends Notification
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
        return [TwitterChannel::class];
    }

    /**
     * Send this to Twitter Notifications
     */
    public function toTwitter($ad)
    {
        //return new TwitterStatusUpdate('Laravel notifications are awesome!');
        return (new TwitterStatusUpdate(text_clean(Str::limit($ad->description->title, 60)) . "\n\n #Bachecubano #Cuba \n\n" . ad_url($ad)))->withImage(ad_image_url($ad, 'original'));
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
