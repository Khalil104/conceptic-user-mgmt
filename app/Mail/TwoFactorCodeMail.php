<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TwoFactorCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    // 1. Le constructeur reçoit le code
    public function __construct(public string $code) {
        //
    }

    // 2. L'enveloppe (Sujet du mail)
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Votre code de vérification de sécurité',
        );
    }

    // 3. LE CONTENU
    public function content(): Content
    {
        return new Content(
            view: 'emails.2fa-code', // Le fichier en question existe dans resources/views/emails/
        );
    }

    public function attachments(): array
    {
        return [];
    }
}