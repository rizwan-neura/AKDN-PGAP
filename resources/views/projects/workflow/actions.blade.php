{{-- Include from a phase review Blade with: @include('projects.workflow.actions', ['project' => $project, 'phase' => 'planning']) --}}
<div class="d-flex align-items-center justify-content-center gap-2 flex-wrap">
    @php
        $workflowRoleId = (int) auth()->user()->role_id;
        $workflowStatus = $project->{$phase . '_workflow_status'} ?? 'draft';
        $workflowActions = [];

        if ($workflowRoleId === 3 && in_array($workflowStatus, ['draft', 'returned_to_acfp'], true)) {
            $workflowActions = [['submit', 'Submit for Review', 'btn-green-heading']];
        } elseif ($workflowRoleId === 4 && in_array($workflowStatus, ['submitted_to_global_afp', 'returned_to_global_afp'], true)) {
            $workflowActions = [
                ['send-back', 'Send Back to ACFP', 'btn-warning'],
                ['submit-to-csa', 'Submit for CSA Review', 'btn-green-heading'],
            ];
        } elseif ($workflowRoleId === 5 && $workflowStatus === 'submitted_to_csa') {
            $workflowActions = [
                ['send-back', 'Send Back to Global AFP', 'btn-warning'],
                ['reviewed', 'Reviewed', 'btn-success'],
            ];
        }
    @endphp

    @if (count($workflowActions))
        <form method="POST" action="{{ route('projects.workflow.transition', [$project->id, $phase, $workflowActions[0][0]]) }}"
            class="d-flex flex-wrap align-items-center gap-2 mt-3">
            @csrf
            <input type="text" name="comment" class="form-control form-control-sm"
                placeholder="Optional review comment" maxlength="2000" style="max-width: 360px;">
            @foreach ($workflowActions as [$action, $label, $class])
                <button type="submit" class="btn {{ $class }} btn-sm"
                        formaction="{{ route('projects.workflow.transition', [$project->id, $phase, $action]) }}">
                    {{ $label }}
                </button>
            @endforeach
        </form>
    @endif
</div>
