<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Proposal;

class ProposalSubmittedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $proposal;

    public function __construct(Proposal $proposal)
    {
        $this->proposal = $proposal;
    }

    public function build()
    {
        return $this->subject('New Proposal Submitted: ' . $this->proposal->project_title)
                   ->markdown('emails.proposals.submitted');
    }
}