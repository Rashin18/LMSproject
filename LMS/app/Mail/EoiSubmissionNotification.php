<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Eoi;

class EoiSubmissionNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $eoi;

    public function __construct(Eoi $eoi)
    {
        $this->eoi = $eoi;
    }
    public function build()
    {
        return $this->markdown('emails.eoi.submission')
                    ->subject('New EOI Submission: '.$this->eoi->name)
                    ->with([
                        'eoi' => $this->eoi,
                        'adminUrl' => route('admin.eois.show', $this->eoi->id)
                    ]);
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Eoi Submission Notification',
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
