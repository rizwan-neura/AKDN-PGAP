<?php

namespace App\Http\Middleware;

use App\Models\Project;
use App\Services\ProjectWorkflowService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Access\AuthorizationException;

class ProjectWorkflowAccess
{
    public function __construct(private ProjectWorkflowService $workflow) {}

    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (! $user || ! in_array((int) $user->role_id, [3, 4, 5], true)) {
            // Roles 1, 2 and 6 retain their existing access, and unrelated roles are not altered here.
            return $next($request);
        }

        $routeName = (string) $request->route()?->getName();
        $viewPhases = [
            'projects.planning' => 'planning',
            'projects.planningreview' => 'planning',
            'projects.design' => 'design',
            'projects.designreview' => 'design',
            'projects.construction' => 'construction',
            'projects.consreview' => 'construction',
        ];
        $editPhases = [
            'projects.savePlanningAssessment' => 'planning',
            'projects.deletePlanningFile' => 'planning',
            'projects.saveDesignAssessment' => 'design',
            'projects.deleteDesignFile' => 'design',
            'projects.saveConstructionAssessment' => 'construction',
            'projects.deleteConstructionFile' => 'construction',
        ];

        if (isset($viewPhases[$routeName])) {
            $project = $this->resolveProject($request);
            $this->workflow->assertCanViewPhase($project, $viewPhases[$routeName]);
        }

        if (isset($editPhases[$routeName])) {
            $project = $this->resolveProject($request);
            $this->workflow->assertCanEditPhase($project, $editPhases[$routeName]);
        }

        if (in_array($routeName, [
            'projects.store',
            'projects.update',
            'projects.saveCheckList',
            'projects.deleteCheckListFile',
            'projects.savesummary',
        ], true)) {
            $project = $this->resolveProjectIfPresent($request);
        
            try {
                $this->workflow->assertCanEditProjectSetup($project);
            } catch (AuthorizationException $e) {
        
                // AJAX/API requests receive a JSON response.
                if ($request->expectsJson()) {
                    return response()->json([
                        'message' => $e->getMessage(),
                    ], 403);
                }
        
                // Normal form requests return to the previous page.
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', $e->getMessage());
            }
        }

        if ($routeName === 'projects.updateCost') {
            $project = $this->resolveProject($request);
            $hasDesignCost = $request->exists('cost_at_design');
            $hasConstructionCost = $request->exists('cost_at_construction');

            if (! $hasDesignCost && ! $hasConstructionCost) {
                abort(403, 'No recognized phase cost field was submitted.');
            }
            if ($hasDesignCost) {
                $this->workflow->assertCanEditPhase($project, 'design');
            }
            if ($hasConstructionCost) {
                $this->workflow->assertCanEditPhase($project, 'construction');
            }
        }

        return $next($request);
    }

    private function resolveProject(Request $request): Project
    {
        return $this->resolveProjectIfPresent($request)
            ?? abort(404, 'Project not found.');
    }

    private function resolveProjectIfPresent(Request $request): ?Project
    {
        $id = $request->route('project') ?? $request->route('id') ?? $request->input('updatedProjectId');
        if ($id instanceof Project) {
            return $id;
        }
        return $id ? Project::query()->findOrFail($id) : null;
    }
}
