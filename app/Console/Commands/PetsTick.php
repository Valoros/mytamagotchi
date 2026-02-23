<?php

namespace App\Console\Commands;

use App\Models\Pet;
use Illuminate\Console\Command;

class PetsTick extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pets:tick';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Команда запущена');
    
        $pets = Pet::where('is_alive', true)->get();
    
        foreach ($pets as $pet) {
    
            $this->info("Питомец: {$pet->name}");
    
            if (! $pet->last_tick_at) {
                $this->info('Нет last_tick_at, устанавливаем текущее время');
                $pet->last_tick_at = now();
                $pet->save();
                continue;
            }
    
            $minutesPassed = (int) $pet->last_tick_at->diffInMinutes(now());
    
            $this->info("Прошло минут: {$minutesPassed}");
    
            if ($minutesPassed > 0) {
                $this->info('Вызываем tick()');
                $pet->tick($minutesPassed);
                $pet->save();
            } else {
                $this->info('Минут не прошло, ничего не делаем');
            }
        }
    
        $this->info('Готово');
    }
}
