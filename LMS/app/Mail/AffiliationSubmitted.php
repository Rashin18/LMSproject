<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Affiliation;

class AffiliationSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $affiliation;

    public function __construct(Affiliation $affiliation)
    {
        $this->affiliation = $affiliation;
    }

    public function build()
    {
        return $this->subject('New Affiliation Form Submission')
                   ->markdown('emails.affiliations.submitted');
    }
}