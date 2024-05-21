<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CreateProductMail extends Mailable
{
    use Queueable, SerializesModels;

    public $product;
    /**
     * Create a new message instance.
     */
    public function __construct($product)
    {
        $this->product = $product;
    }

    /**
     * Get the message envelope.
     */
    public function envelope()
    {
        return new Envelope(
            from: 'alipileforooshha@gmail.com',
            subject: 'Instructor Welcome Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'Mails.CreateProduct',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
