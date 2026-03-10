<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Services\TelegramBotService;

class PetStatsNotification extends Notification
{
    use Queueable;

    protected string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return [\App\Notifications\Channels\TelegramChannel::class];
    }

    public function toTelegram($notifiable)
    {
        $service = app(TelegramBotService::class);

        $service->sendMessage(
            config('telegram.chat_id'),
            $this->message
        );
    }
}