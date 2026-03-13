<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PetApiController;

Route::post('/pets', [PetApiController::class, 'store']);