<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pet;
use App\Mail\PetInfoMail;
use Illuminate\Support\Facades\Mail;

class PetController extends Controller
{
    public function show(Pet $pet)
    {
        $pet->applyTimeDecay();

        $pets = \App\Models\Pet::orderBy('created_at', 'desc')->get();

        return view('pets.show', compact('pet', 'pets'));
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

    public function sendInfo(Pet $pet)
    {
        Mail::to('vladislavorlov752@gmail.com')->send(new PetInfoMail($pet));
    
        return back()->with('success', 'Письмо отправлено!');
    }

    public function create()
    {
        return view('pets.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string',
        ]);
    
        $pet = Pet::create([
            'name' => $request->name,
            'type' => $request->type,
            'health' => 100,
            'energy' => 100,
            'hunger' => 100,
            'cleanliness' => 100,
            'happiness' => 100,
            'age' => 0,
            'is_alive' => true,
        ]);
    
        return redirect()->route('pets.show', $pet);
    }

    public function home()
    {
        $pet = \App\Models\Pet::first();
    
        if (!$pet) {
            return redirect()->route('pets.create');
        }
    
        return redirect()->route('pets.show', $pet);
    }
}