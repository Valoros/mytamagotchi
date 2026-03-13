<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;

class PetCreateRequested
{
    use Dispatchable;

    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }
}