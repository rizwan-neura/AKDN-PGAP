<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WorkflowNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $projectName,
        public string $phase,
        public string $action,
        public string $actionLabel,
        public string $actorName,
        public string $status,
        public ?string $comments = null,
        public ?string $projectUrl = null,
    ) {}

    public function build()
    {
        $subjects = [
            'submit' => 'PGAP: Project Submitted for Review',
            'send-back' => 'PGAP: Corrections Required',
            'submit-to-csa' => 'PGAP: CSA Review Requested',
            'send-back-to-global-afp' => 'PGAP: Further Action Required',
            'reviewed' => 'PGAP: Phase Reviewed',
        ];

        $subject = $subjects[$this->action]
            ?? 'PGAP Workflow Update';

        return $this->subject(
            $subject . ' — ' . $this->projectName
        )->view('emails.workflow-notification');
    }
}