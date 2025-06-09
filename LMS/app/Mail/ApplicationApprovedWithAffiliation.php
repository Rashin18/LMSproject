<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Application;

class ApplicationApprovedWithAffiliation extends Mailable
{
    use Queueable, SerializesModels;

    public $application;
    public $affiliationFormUrl;

    public function __construct(Application $application, string $affiliationFormUrl)
    {
        $this->application = $application;
        $this->affiliationFormUrl = $affiliationFormUrl;
    }

    public function build()
    {
        return $this->subject('Application Approved - Complete Affiliation Form')
                   ->markdown('emails.applications.approved-with-affiliation');
    }
}