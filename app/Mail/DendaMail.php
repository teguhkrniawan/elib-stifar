<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DendaMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */

    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Bukti Pelunasan Denda',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.denda',
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

    public function build()
    {

        // Menambahkan header "From" secara manual
        $this->withSwiftMessage(function ($message) {
            $message->getHeaders()
                ->addTextHeader('From', 'STIFAR RIAU <noreply@teguhkrniawan.com>');
        });

        return $this->view('email.denda')
            ->with('data', $this->data)
            ->subject('Penalty Receipt - STIFAR RIAU')
            ->from('noreply@teguhkrniawan.com', 'STIFAR RIAU');
    }
}
