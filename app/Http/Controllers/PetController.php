<?php

namespace App\Http\Controllers;

use App\Models\Pet;

class PetController extends Controller
{
    public function show(Pet $pet)
    {
        $pet->applyTimeDecay();

        return view('pets.show', compact('pet'));
    }

    public function action(Pet $pet, string $action)
    {
        $allowed = ['feed', 'sleep', 'play', 'wash', 'reset'];
    
        if (! in_array($action, $allowed)) {
            abort(404);
        }
    
        $pet->$action();
    
        return back();
    }

    public function fastForward(Pet $pet)
    {
        $pet->tick(100); // пропускаем 10 дней
        
        return back()->with('message', 'Время промотано на 10 дней!');
    }   
}