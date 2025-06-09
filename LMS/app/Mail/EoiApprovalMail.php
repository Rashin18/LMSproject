<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Eoi;


class EoiApprovalMail extends Mailable
{
    use Queueable, SerializesModels;

    public $eoi;
    public $nextFormUrl;

    public function __construct(Eoi $eoi)
    {
        $this->eoi = $eoi;
        $this->nextFormUrl = $eoi->user_id 
            ? route('next-form.create', ['eoi' => $eoi->id])
            : route('register');
    }

    public function build()
    {
        return $this->markdown('emails.eoi.approval')
                    ->subject('Your EOI Has Been Approved');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Eoi Approval Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'view.name',
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
