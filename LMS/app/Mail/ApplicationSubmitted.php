<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Application;

class ApplicationSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public $application;
    public $adminDashboardUrl;

    public function __construct(Application $application)
    {
        $this->application = $application;
        $this->adminDashboardUrl = route('admin.applications.index');
    }

    public function build()
    {
        return $this->subject('New Application Submitted: ' . $this->application->proposal->project_title)
                   ->markdown('emails.applications.submitted');
    }
}