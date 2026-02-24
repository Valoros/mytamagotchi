<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;

Route::get('/pets/create', [PetController::class, 'create'])->name('pets.create');
Route::post('/pets', [PetController::class, 'store'])->name('pets.store');

Route::get('/pets/{pet}', [PetController::class, 'show'])
    ->name('pets.show');
Route::post('/pets/{pet}/action/{action}', [PetController::class, 'action'])
    ->name('pets.action');
Route::post('/pets/{pet}/fast-forward', [PetController::class, 'fastForward'])
    ->name('pets.fastForward');
Route::post('/pets/{pet}/send-info', [PetController::class, 'sendInfo'])
    ->name('pets.sendInfo');
Route::get('/', [PetController::class, 'home'])->name('home');
