<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $messageContent;  

    public function __construct($message)
    {
        $this->messageContent = $message;  // Store in messageContent
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Message from Dashboard',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.dashboard-message',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
