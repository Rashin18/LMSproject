<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Proposal;

class ProposalConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $proposal;

    public function __construct(Proposal $proposal)
    {
        $this->proposal = $proposal;
    }

    public function build()
    {
        return $this->subject('Your Proposal Submission Confirmation')
                   ->markdown('emails.proposals.confirmation');
    }
}