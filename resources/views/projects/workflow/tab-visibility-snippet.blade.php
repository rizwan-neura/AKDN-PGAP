{{-- Add this near the top of tab-layout.blade.php, before the wizard tabs. --}}
@php
    $workflowRoleId = (int) auth()->user()->role_id;
    $workflowIsManagement = in_array($workflowRoleId, [1, 2, 6], true);
    $workflowCanSeeDesign = $workflowIsManagement
        || ! in_array($workflowRoleId, [3, 4, 5], true)
        || (($project->planning_workflow_status ?? 'draft') === 'reviewed');
    $workflowCanSeeConstruction = $workflowIsManagement
        || ! in_array($workflowRoleId, [3, 4, 5], true)
        || (($project->design_workflow_status ?? 'draft') === 'reviewed');
@endphp

{{-- Wrap the existing Design nav-item in: @if ($workflowCanSeeDesign) ... @endif --}}
{{-- Wrap the existing Construction and Construction Review nav-items in: @if ($workflowCanSeeConstruction) ... @endif --}}
