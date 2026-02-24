<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pet extends Model
{

    use HasFactory;

    protected $fillable = [
        'age',
        'name',
        'health',
        'energy',
        'cleanliness',
        'happiness',
        'hunger',
        'is_alive',
        'last_tick_at',
        'type',
    ];

    protected $casts = [
        'is_alive' => 'boolean',
        'last_tick_at' => 'datetime',
        'health' => 'integer',
        'energy' => 'integer',
        'cleanliness' => 'integer',
        'happiness' => 'integer',
        'hunger' => 'integer',
        'age' => 'integer',
    ];

    public function clampState(): void 
    {
        $this->health = max(0, min(100, $this->health));
        $this->energy = max(0, min(100, $this->energy));
        $this->cleanliness = max(0, min(100, $this->cleanliness));
        $this->happiness = max(0, min(100, $this->happiness));
        $this->hunger = max(0, min(100, $this->hunger));
    }

    public function tick(int $minutes = 1): void
    {   
        if (! $this->is_alive) {
            return;
        }
    
        $minutes = min($minutes, 60);
    
        // Питомец голодает
        $this->hunger -= 2 * $minutes;
    
        // Усталость
        $this->energy -= 1 * $minutes;
    
        // Старение: каждый 10 минут = 1 день
        $daysToAdd = intdiv($minutes, 10);
        if ($daysToAdd > 0) {
            $this->age += $daysToAdd;
        }
    
        // Если возраст больше 5 дней, здоровье постепенно теряется
        if ($this->age > 5) {
            $this->health -= 1 * $minutes;
        }

        // Если голод = 0 → начинает терять здоровье
        if ($this->hunger <= 0) {
            $this->health -= 3 * $minutes;
        }

        // Если энергии мало → тоже теряет здоровье
        if ($this->energy <= 0) {
            $this->health -= 2 * $minutes;
        }

        // Если здоровье упало до 0 → смерть
        if ($this->health <= 0) {
            $this->health = 0;
            $this->is_alive = false;
        }

        if ($this->happiness <= 10) {
            $this->health -= 2 * $minutes;
        }


        //НИЖМЕ НЕ ЛЕЗТЬ ТАМ СОХРАНАЯЛКА 

        $this->clampState();
        $this->checkState();

        $this->last_tick_at = now();

        $this->save();
    }
    
    public function applyTimeDecay(): void
    {
        if (! $this->last_tick_at) {
            $this->last_tick_at = now();
            $this->save();
            return;
        }
    
        $minutes = $this->last_tick_at->diffInMinutes(now());
    
        if ($minutes > 0) {
            $this->tick($minutes);
        }
    }

    public function feed(): void
    {
        if (! $this->is_alive) return;

        $this->hunger += 20;
        $this->happiness += 5;
        $this->cleanliness -= 10;
        $this->energy -= 10;

        $this->clampState();
        $this->checkState();
        $this->save();
        $this->randomEvent('feed');
    }

    public function sleep(): void
    {
        if (! $this->is_alive) return;

        $this->energy += 30;
        $this->health += 5;
        $this->cleanliness -= 15;

        $this->clampState();
        $this->checkState();
        $this->save();
        $this->randomEvent('sleep');
    }

    public function play(): void
    {
        if (! $this->is_alive) return;

        $this->happiness += 20;
        $this->energy -= 20;
        $this->hunger -= 15;
        $this->cleanliness -= 10;
        $this->health -= 5;

        $this->clampState();
        $this->checkState();
        $this->save();
        $this->randomEvent('play');
    }

    public function wash(): void
    {
        if (! $this->is_alive) return;

        $this->cleanliness += 30;
        $this->energy -= 15;
        $this->happiness += 5;
        $this->hunger -= 10;

        $this->clampState();
        $this->checkState();
        $this->save();
        $this->randomEvent('wash');
    }

    public function checkState(): void
    {
        if ($this->health <= 0) {
            $this->health = 0;
            $this->is_alive = false;
        }
    }

    public function reset(): void
    {
        $this->age = 0;
        $this->health = 100;
        $this->energy = 100;
        $this->cleanliness = 100;
        $this->happiness = 100;
        $this->hunger = 100;
        $this->is_alive = true;
        $this->last_tick_at = now();

        $this->save();
    }

    public function randomEvent(string $action): void
    {
        // Генерируем случайное число 1-100
        $chance = rand(1, 100);
    
        // Пример событий при разных действиях
        if ($action === 'feed' && $chance <= 20) {
            $this->cleanliness -= 10; // испачкалась
            $this->happiness -= 5;
            $this->last_event = "🤦‍♂️ Ваш питомец перевернул миску и испачкался!";
        } elseif ($action === 'play' && $chance <= 20) {
            $this->health -= 5; // слегка поранился
            $this->last_event = "😢 Ваш питомец ударился во время игры!";
        } elseif ($action === 'wash' && $chance <= 20) {
            $this->happiness -= 10;
            $this->health -= 5;
            $this->last_event = "😿 Ваш питомец поскользнулся и упал!";
        } elseif ($action === 'sleep' && $chance <= 20) {
            $this->energy += 5;
            $this->happiness += 10;
            $this->last_event = "😇 Питомцу приснился хороший сон!";
        } else {
            $this->last_event = null; // ничего не произошло
        }
    
        $this->clampState();
        $this->save();
    }
}
