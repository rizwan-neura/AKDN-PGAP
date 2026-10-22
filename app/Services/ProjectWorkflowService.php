<?php

namespace App\Services;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Access\AuthorizationException;

class ProjectWorkflowService
{
    public const MANAGEMENT_ROLE_IDS = [1, 2, 6];
    public const WORKFLOW_ROLE_IDS = [3, 4, 5];

    public function roleId(): int
    {
        return (int) auth()->user()?->role_id;
    }

    public function isManagementBypass(): bool
    {
        return in_array($this->roleId(), self::MANAGEMENT_ROLE_IDS, true);
    }

    public function status(Project $project, string $phase): string
    {
        $this->validatePhase($phase);
        return (string) ($project->{$phase . '_workflow_status'} ?: 'draft');
    }

    public function assertCanViewPhase(Project $project, string $phase): void
    {
        $this->validatePhase($phase);

        if ($this->isManagementBypass() || ! in_array($this->roleId(), self::WORKFLOW_ROLE_IDS, true)) {
            return;
        }

        if ($phase === 'design' && $this->status($project, 'planning') !== 'reviewed') {
            abort(403, 'Design is available after Planning has been reviewed.');
        }

        if ($phase === 'construction' && $this->status($project, 'design') !== 'reviewed') {
            abort(403, 'Construction is available after Design has been reviewed.');
        }
    }

    public function assertCanEditPhase(Project $project, string $phase): void
    {
        $this->assertCanViewPhase($project, $phase);

        if ($this->isManagementBypass()) {
            return;
        }

        if ($this->roleId() !== 3) {
            throw new AuthorizationException('Only ACFP can edit assessment data during the workflow.');
        }

        $allowedStatuses = ['draft', 'returned_to_acfp'];
        if (! in_array($this->status($project, $phase), $allowedStatuses, true)) {
            throw new AuthorizationException('This phase is locked while it is under review or has been reviewed.');
        }
    }

    public function assertCanEditProjectSetup(?Project $project = null): void
    {
        if ($this->isManagementBypass()) {
            return;
        }

        if ($this->roleId() !== 3) {
            throw new AuthorizationException('Please send back to ACFP. Only ACFP can edit project setup data during the workflow.');
        }

        if ($project && ! in_array($this->status($project, 'planning'), ['draft', 'returned_to_acfp'], true)) {
            throw new AuthorizationException('Project setup is locked while its is under review.');
        }
    }

    public function transition(Project $project, string $phase, string $action, ?string $comment = null): string
    {
        $this->validatePhase($phase);
        $roleId = $this->roleId();

        if (! in_array($roleId, self::WORKFLOW_ROLE_IDS, true)) {
            throw new AuthorizationException('This role does not perform workflow transitions.');
        }

        $this->assertCanViewPhase($project, $phase);
        $column = $phase . '_workflow_status';
        $current = $this->status($project, $phase);

        $transitions = [
            3 => [
                'submit' => [
                    'from' => ['draft', 'returned_to_acfp'],
                    'to' => 'submitted_to_global_afp',
                    'recipient_role' => 4,
                    'label' => 'submitted to Global AFP',
                    'email_action' => 'submit',
                ],
            ],
            4 => [
                'send-back' => [
                    'from' => ['submitted_to_global_afp', 'returned_to_global_afp'],
                    'to' => 'returned_to_acfp',
                    'recipient_role' => 3,
                    'label' => 'returned to ACFP for corrections',
                    'email_action' => 'send-back',
                ],
                'submit-to-csa' => [
                    'from' => ['submitted_to_global_afp', 'returned_to_global_afp'],
                    'to' => 'submitted_to_csa',
                    'recipient_role' => 5,
                    'label' => 'submitted to CSA for final review',
                    'email_action' => 'submit-to-csa',
                ],
            ],
            5 => [
                'send-back' => [
                    'from' => ['submitted_to_csa'],
                    'to' => 'returned_to_global_afp',
                    'recipient_role' => 4,
                    'label' => 'returned to Global AFP for corrections',
                    'email_action' => 'send-back-to-global-afp',
                ],
                'reviewed' => [
                    'from' => ['submitted_to_csa'],
                    'to' => 'reviewed',
                    'recipient_role' => 4,
                    'label' => 'marked Reviewed',
                    'email_action' => 'reviewed',
                ],
            ],
        ];

        $definition = $transitions[$roleId][$action] ?? null;
        if (! $definition || ! in_array($current, $definition['from'], true)) {
            throw new AuthorizationException('This workflow action is not allowed for the current role or phase status.');
        }

        DB::transaction(function () use ($project, $column, $definition, $comment, $phase) {
            $project->{$column} = $definition['to'];
            $project->{$phase . '_workflow_comment'} = $comment;
            $project->{$phase . '_workflow_updated_by'} = auth()->id();
            $project->{$phase . '_workflow_updated_at'} = now();
            $project->save();
        });

        $this->notifyRole(
            (int) $definition['recipient_role'],
            $project,
            $phase,
            (string) $definition['email_action'],
            (string) $definition['label'],
            (string) $definition['to'],
            $comment
        );

        return (string) $definition['to'];
    }

    private function notifyRole(
        int $roleId,
        Project $project,
        string $phase,
        string $action,
        string $actionLabel,
        string $status,
        ?string $comment
    ): void {
        $emails = User::query()
            ->where('role_id', $roleId)
            ->whereRaw('LOWER(status) = ?', ['active'])
            ->whereNotNull('email')
            ->where('email', '!=', '')
            ->pluck('email')
            ->filter(fn ($email) => filter_var($email, FILTER_VALIDATE_EMAIL))
            ->unique()
            ->values()
            ->all();
    
        if (empty($emails)) {
            Log::info('PGAP workflow notification skipped: no active recipients.', [
                'role_id' => $roleId,
                'project_id' => $project->id,
                'phase' => $phase,
                'action' => $action,
            ]);
    
            return;
        }
    
        $user = auth()->user();
    
        $actorName = trim(
            ($user->first_name ?? '') . ' ' . ($user->last_name ?? '')
        );
    
        if ($actorName === '') {
            $actorName = $user->email ?? 'PGAP User';
        }
    
        $phaseRoutes = [
            'planning' => 'projects.planningreview',
            'design' => 'projects.designreview',
            'construction' => 'projects.consreview',
        ];
    
        try {
            $projectUrl = route($phaseRoutes[$phase], $project);
    
            Mail::to($emails)->send(
                new \App\Mail\WorkflowNotificationMail(
                    projectName: $project->project_name,
                    phase: $phase,
                    action: $action,
                    actionLabel: $actionLabel,
                    actorName: $actorName,
                    status: $status,
                    comments: $comment,
                    projectUrl: $projectUrl,
                )
            );
        } catch (\Throwable $e) {
            Log::error('PGAP workflow email failed.', [
                'project_id' => $project->id,
                'phase' => $phase,
                'action' => $action,
                'recipient_role_id' => $roleId,
                'error' => $e->getMessage(),
            ]);
        }
    }

    private function validatePhase(string $phase): void
    {
        if (! in_array($phase, ['planning', 'design', 'construction'], true)) {
            abort(404, 'Unknown project phase.');
        }
    }
}
