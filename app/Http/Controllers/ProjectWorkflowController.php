<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\ProjectWorkflowService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProjectWorkflowController extends Controller
{
    public function __construct(private ProjectWorkflowService $workflow) {}

    public function transition(Request $request, Project $project, string $phase, string $action)
    {
        $request->validate([
            'comment' => ['nullable', 'string', 'max:2000'],
        ]);

        abort_unless(in_array($phase, ['planning', 'design', 'construction'], true), 404);
        abort_unless(in_array($action, ['submit', 'send-back', 'submit-to-csa', 'reviewed'], true), 404);

        $this->workflow->transition($project, $phase, $action, $request->input('comment'));

        return back()->with('success', ucfirst($phase) . ' workflow updated successfully.');
    }
}
