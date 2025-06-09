<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Application;

class ApplicationApproved extends Mailable
{
    use Queueable, SerializesModels;

    public $application;
    public $proposal;
    public $dashboardUrl;

    public function __construct(Application $application)
    {
        $this->application = $application;
        $this->proposal = $application->proposal;
        $this->dashboardUrl = url('/dashboard'); // Or your actual dashboard URL
    }

    public function build()
    {
        return $this->subject('Your Application Has Been Approved')
                   ->markdown('emails.applications.approved');
    }
}