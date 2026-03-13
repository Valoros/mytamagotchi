<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Events\PetCreateRequested;

class PetApiController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string'
        ]);

        event(new PetCreateRequested($data));

        return response()->json([
            'message' => 'Pet creation queued'
        ]);
    }
}