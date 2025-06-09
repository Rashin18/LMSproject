<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Affiliation;

class AffiliationApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $affiliation;
    public $password;
    public $loginUrl;

    public function __construct(Affiliation $affiliation, string $password)
    {
        $this->affiliation = $affiliation;
        $this->password = $password;
        $this->loginUrl = route('login');
    }

    public function build()
    {
        return $this->subject('Your ATC Account Credentials')
                   ->markdown('emails.affiliations.approved');
    }
}