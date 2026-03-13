<?php

namespace App\Listeners;

use App\Events\PetCreateRequested;
use App\Models\Pet;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreatePetListener implements ShouldQueue
{
    public function handle(PetCreateRequested $event): void
    {
        Pet::create([
            'name' => $event->data['name'],
            'type' => $event->data['type'],
            'health' => 100,
            'energy' => 100,
            'hunger' => 100,
            'cleanliness' => 100,
            'happiness' => 100,
            'age' => 0,
            'is_alive' => true,
        ]);
    }
}