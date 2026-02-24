<?php

namespace App\Mail;

use App\Models\Pet;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PetInfoMail extends Mailable
{
    use Queueable, SerializesModels;

    public Pet $pet;

    public function __construct(Pet $pet)
    {
        $this->pet = $pet;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Информация о вашем питомце'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.pet-info'
        );
    }

    public function attachments(): array
    {
        return [];
    }
}