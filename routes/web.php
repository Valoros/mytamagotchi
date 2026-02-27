<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PetController;

Route::get('/', [PetController::class, 'home'])->name('home');

Route::prefix('pets')
    ->name('pets.')
    ->controller(PetController::class)
    ->group(function () {

        Route::get('create', 'create')->name('create');
        Route::post('/', 'store')->name('store');

        Route::get('{pet}', 'show')
            ->whereNumber('pet')
            ->name('show');

        Route::post('{pet}/action/{action}', 'action')
            ->whereNumber('pet')
            ->name('action');

        Route::post('{pet}/fast-forward', 'fastForward')
            ->whereNumber('pet')
            ->name('fastForward');

        Route::post('{pet}/send-info', 'sendInfo')
            ->whereNumber('pet')
            ->name('sendInfo');
    });