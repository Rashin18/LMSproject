<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EoiApprovalNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $eoi;
    public $proposalFormUrl;

    public function __construct($eoi, $proposalFormUrl)
    {
        $this->eoi = $eoi;
        $this->proposalFormUrl = $proposalFormUrl;
    }

    public function build()
    {
        return $this->markdown('emails.eoi.approval')
                   ->with([
                       'eoi' => $this->eoi,
                       'proposalFormUrl' => $this->proposalFormUrl
                   ]);
    }
}