<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pet;
use App\Notifications\PetStatsNotification;
use Illuminate\Support\Facades\Notification;

class SendPetsStats extends Command
{
    protected $signature = 'pets:stats';

    protected $description = 'Send pets stats to Telegram';

    public function handle()
    {
        $pets = Pet::all();

        if ($pets->isEmpty()) {
            $message = "Питомцев пока нет.";
        } else {
            $message = "📊 Статистика питомцев\n\n";

            foreach ($pets as $pet) {
                $message .=
                    "🐾 {$pet->name}\n".
                    "❤️ Health: {$pet->health}\n".
                    "🍗 Hunger: {$pet->hunger}\n".
                    "⚡ Energy: {$pet->energy}\n".
                    "😊 Happiness: {$pet->happiness}\n".
                    "🧼 Cleanliness: {$pet->cleanliness}\n".
                    "🎂 Age: {$pet->age}\n\n";
            }
        }

        Notification::route('telegram', config('telegram.chat_id'))
            ->notify(new PetStatsNotification($message));

        $this->info('Статистика отправлена в Telegram');
    }
}