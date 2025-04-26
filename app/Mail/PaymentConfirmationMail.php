<?php

namespace App\Mail;

use App\Models\Saving;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class PaymentConfirmationMail extends Mailable
{
    public function __construct(
        private Saving $saving,
        private float $totalSavings,
        private float $progress
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Konfirmasi Pembayaran KKL',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.payment-confirmation',
            with: [
                'saving' => $this->saving,
                'totalSavings' => $this->totalSavings,
                'progress' => $this->progress,
            ],
        );
    }
}
