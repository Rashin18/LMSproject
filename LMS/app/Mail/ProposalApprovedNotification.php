<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Proposal;

class ProposalApprovedNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $proposal;
    public $applicationFormUrl;

    public function __construct(Proposal $proposal, string $applicationFormUrl)
    {
        $this->proposal = $proposal;
        $this->applicationFormUrl = $applicationFormUrl;
    }

    public function build()
    {
        return $this->subject('Your Proposal Has Been Approved: ' . $this->proposal->project_title)
                   ->markdown('emails.proposals.approved');
    }
}