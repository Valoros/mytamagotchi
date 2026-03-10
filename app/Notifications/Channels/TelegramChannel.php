<?php

namespace App\Notifications\Channels;

class TelegramChannel
{
    public function send($notifiable, $notification)
    {
        if (! method_exists($notification, 'toTelegram')) {
            return;
        }

        $notification->toTelegram($notifiable);
    }
}