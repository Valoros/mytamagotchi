<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;

Route::get('/pets/{pet}', [PetController::class, 'show']);
Route::post('/pets/{pet}/action/{action}', [PetController::class, 'action'])
    ->name('pets.action');
Route::post('/pets/{pet}/fast-forward', [PetController::class, 'fastForward'])->name('pets.fastForward');
Route::post('/pets/{pet}/send-info', [PetController::class, 'sendInfo'])
    ->name('pets.sendInfo');
