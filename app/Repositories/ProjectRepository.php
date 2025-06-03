<?php

namespace App\Repositories;
use Carbon\Carbon;
use App\Models\Project;
use App\Models\ProjectChecklist;
use App\Models\PlanningAssess;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProjectRepository
{
    public function getAll($request)
    {
        $limit = env('PER_PAGE_LIMIT', 10);
        $projects = Project::select(
                'projects.id',
                'projects.project_name',
                'projects.date_gpa',
                'projects.start_date',
                'projects.end_date',
                'phase.phase_name',
                'org.organization_name',
                'b.type_name'
            )->leftJoin('project_phases as phase', 'phase.id', '=', 'projects.phase_id')
            ->leftJoin('organization as org', 'org.id', '=', 'projects.organization_id')
            ->leftJoin('building_types as b', 'b.id', '=', 'projects.type_id')
            ->orderBy('projects.id', 'DESC')->paginate($limit)->setPath('');
        $projects->appends($request->all());
        return $projects;
    }
    
    public function getById($id)
    {
        return Project::find($id);
    }

    public function create($request)
    {
        //dd($request->country_name);
        $project = new Project();
        $project->project_name = $request->project_name;
        $project->phase_id = $request->phase_id;
        $project->assessment_req = $request->assessment_req;
        $project->organization_id = $request->organization_id;
        $project->date_gpa = Carbon::parse($request->date_gpa)->format('Y-m-d');
        $project->start_date = Carbon::parse($request->start_date)->format('Y-m-d');
        $project->end_date = Carbon::parse($request->end_date)->format('Y-m-d');
        $project->location = $request->location;
        $project->coordinates = $request->coordinates;
        $project->type_id = $request->type_id;
        $project->sub_type_id = $request->sub_type_id;
        $project->construction_cost = $request->construction_cost;
        $project->requirements = $request->requirements;
        $project->created_by = auth()->user()->id;
        DB::transaction(function () use ($project) { $project->save(); });
        //$lastInsertedId = $project->id;
        return $project;
    }

    public function update($id, $request)
    {
        /*
        $country = $this->getById($id);
        $country->country_name = $request->country_name;

        DB::transaction(function () use ($country) {
            $country->save();
        });

        return $country;
        */
    }

    public function delete($id)
    {
        $country = $this->getById($id);
        //$country->checkRelation('states');
        DB::transaction(function () use ($country) {
            $country->delete();
            //$country->forceDelete();
        });

        return $country;
    }
    public function getProjectPhases()
    {   
        $projectPhases = DB::table('project_phases')->pluck('phase_name', 'id');
        return $projectPhases;
    }
    public function getOrganizations()
    {   
        $organizations = DB::table('organization')->pluck('organization_name', 'id');
        return $organizations;
    }
    public function getBuildingTypes()
    {   
        $buildingTypes = DB::table('building_types')->pluck('type_name', 'id');
        return $buildingTypes;
    }
    public function getBuildingSubTypes($type_id)
    {   
        $buildingSubTypes = DB::table('building_sub_types')->where('building_type_id', $type_id)->pluck('sub_type_name', 'id');
        return $buildingSubTypes;
    }
    public function getProjectChecklistInfo($project_id,$checklist_id){
        return ProjectChecklist::where('project_id', $project_id)
        ->where('checklist_id', $checklist_id)
        ->first();

    }
    public function getPlanningAssessInfo($project_id,$indicator_id){
        return PlanningAssess::where('project_id', $project_id)
        ->where('indicator_id', $indicator_id)
        ->first();

    }
    public function createProjectChecklistItem($request)
    {
        //dd($request->country_name);
        $newChecklist = new ProjectChecklist();
        $newChecklist->project_id = $request->updatedProjectId;
        $newChecklist->checklist_id = $request->checklist_id;
        $newChecklist->status = $request->checklistStatus;
        $newChecklist->created_by = auth()->user()->id;

        if ($request->file('checklist_uploads')) {
            $newChecklist->file_name = $request->filename;
            $newChecklist->file_path = $request->path;
        }

        //$newChecklist->save();
        DB::transaction(function () use ($newChecklist) { $newChecklist->save(); });
        //$lastInsertedId = $project->id;
        return $newChecklist;
    }
    public function resetProjectChecklistInfo($project_id,$checklist_id)
    {
        $checklist = $this->getProjectChecklistInfo($project_id,$checklist_id);
        if ($checklist && $checklist->file_path && Storage::disk('public')->exists($checklist->file_path)) {
            Storage::disk('public')->delete($checklist->file_path);
            $checklist->file_path = null;
            $checklist->file_name = null;
            $checklist->save();    
        }

    }
    public function getPlanningIndicatorWeightage($indicator_id)
    {   
        $pIndcatorWeight = DB::table('planning_indicators')->where('id', $indicator_id)->value('weightage');
        return $pIndcatorWeight;
    }
    public function getPlanningComplianceScore($compliance_id)
    {   
        $pComplianceScore = DB::table('planning_compliances_scores')->where('id', $compliance_id)->value('score');
        return $pComplianceScore;
    }

    public function resetPlanningAssessFile($project_id,$indicator_id)
    {
        $checklist = $this->getPlanningAssessInfo($project_id,$indicator_id);
        if ($checklist && $checklist->file_path && Storage::disk('public')->exists($checklist->file_path)) {
            Storage::disk('public')->delete($checklist->file_path);
            $checklist->file_path = null;
            $checklist->file_name = null;
            $checklist->save();    
        }

    }
    public function resetPlanningAssessInfo($request,$dataExists)
    {
        $assessScore = $this->calculatePlanningIndicatorScore($request->indicator_id,$request->compliance);
        // Delete old file if uploading new one
        if ($request->file('planning_uploads') && !is_null($dataExists->file_path) && Storage::disk('public')->exists($dataExists->file_path)) {
            Storage::disk('public')->delete($dataExists->file_path);
        }
        // Update record
        if ($request->file('planning_uploads')) {
            $dataExists->file_name = $request->filename;
            $dataExists->file_path = $request->path;
        }
        $dataExists->compliances_id = $request->compliance;
        $dataExists->score = $assessScore;
        $dataExists->updated_by = auth()->user()->id;
        $dataExists->save();

        // Get sum of Planning scores for all indicators against project id...
        $planningTotalScores = $this->getPlanningTotalScore($request->updatedProjectId);
        $fixedWeightPlanning = 0.45; // 45%
        $finalPlanningScore =  $planningTotalScores * 10 * $fixedWeightPlanning;
        $calculateRating = ($finalPlanningScore / 45)*100; //45%
        $this->insertFinalScoreRating($request->updatedProjectId,'Planning',$finalPlanningScore,$calculateRating);

    }
    // Sum up total score for all indicators against project id...
    public function getPlanningTotalScore($projectId){
        $hasZero = PlanningAssess::where('project_id', $projectId)->whereIn('indicator_id', [1, 4, 6])->where('score', 0)->exists();
        $totalScore = $hasZero ? 0 : PlanningAssess::where('project_id', $projectId)->sum('score');
        return $totalScore;

    }
    public function getFinalRating($calculateRating)
    {
        if ($calculateRating < 50) {
            return 'NC';
        } elseif ($calculateRating >= 50 && $calculateRating <= 60) {
            return 'G';
        } elseif ($calculateRating > 60 && $calculateRating <= 80) {
            return 'G+';
        } elseif ($calculateRating > 80) {
            return 'G++';
        }
        // Optional: fallback
        return 'Undefined';
    }
    //insert or update final score and rating against project id and phases...
    public function insertFinalScoreRating($projectId,$phase,$finalScores,$calculateRating)
    {
        $finalRating = $this->getFinalRating($calculateRating);
        
        DB::table('final_rating_score')->updateOrInsert(
            [
                'project_id' => $projectId,
                'phase' => $phase
            ],
            [
                'score' => $finalScores, 
                'phase' => $phase,
                'rating' => $finalRating,
                'reviewed' => 0,
                'updated_at' => now(),
                'created_at' => now(), 
            ]
        );

    }
    public function getPlanningFinalScoreRating($projectId,$phaseName)
    {
       // dd($projectId, $phaseName);
        $scoreRatings = DB::table('final_rating_score')
        ->select('score', 'rating')
        ->where('phase', $phaseName)
        ->where('project_id', $projectId)
        ->first();
        
        return $scoreRatings;
    }
    public function calculatePlanningIndicatorScore($indicator_id,$compliance_id)
    {
        $pIndcatorWeight = $this->getPlanningIndicatorWeightage($indicator_id);
        $pComplianceScore = $this->getPlanningComplianceScore($compliance_id);
        $assessScore = $pIndcatorWeight * $pComplianceScore;
        return $assessScore;

    }
    public function createPlanningAssessmentItem($request)
    {
        //dd($request->country_name);
        $newChecklist = new PlanningAssess();
        $assessScore = $this->calculatePlanningIndicatorScore($request->indicator_id,$request->compliance);
        $newChecklist->project_id = $request->updatedProjectId;
        $newChecklist->indicator_id = $request->indicator_id;
        $newChecklist->compliances_id = $request->compliance;
        $newChecklist->score = $assessScore;
        $newChecklist->created_by = auth()->user()->id;

        if ($request->file('planning_uploads')) {
            $newChecklist->file_name = $request->filename;
            $newChecklist->file_path = $request->path;
        }
        DB::transaction(function () use ($newChecklist) { $newChecklist->save(); });
        // Get sum of Planning scores for all indicators against project id...
        $planningTotalScores = $this->getPlanningTotalScore($request->updatedProjectId);
        $fixedWeightPlanning = 0.45; // 45%
        $finalPlanningScore =  $planningTotalScores * 10 * $fixedWeightPlanning;
        $calculateRating = ($finalPlanningScore / 45)*100; //45%
        $this->insertFinalScoreRating($request->updatedProjectId,'Planning',$finalPlanningScore,$calculateRating);

        return $newChecklist;
    }
    
    public function getChecklistsByProjectId($project_id)
    {
        $projectChecklists = DB::table('checklists')
        ->leftJoin('project_checklists', function ($join) use ($project_id) {
            $join->on('checklists.id', '=', 'project_checklists.checklist_id')->where('project_checklists.project_id', '=', $project_id);
        })->select(
            'checklists.id',
            'checklists.checklist_name',
            'checklists.is_mandatory',
            'project_checklists.status',
            'project_checklists.file_name',
            'project_checklists.file_path',
            'project_checklists.project_id'
        ) ->get();
        return $projectChecklists;
    }
    public function getPlanningAssessmentsByProject($project_id)
    {
        $planningAssessData = PlanningAssess::select('id',
                'indicator_id',
                'compliances_id',
                'file_name',
                'file_path',
                'project_id')
            ->where('project_id', $project_id)
            ->get();
        return $planningAssessData;
    }

    public function getPlanningInfoByProjectId($project_id)
    {
        $planningInfo = DB::table('planning_indicators')
        ->leftJoin('planning_assessment', function ($join) use ($project_id) {
        $join->on('planning_indicators.id', '=', 'planning_assessment.indicator_id')
        ->where('planning_assessment.project_id', '=', $project_id);
        })
        ->leftJoin('planning_compliances_scores', function ($join) use ($project_id) {
        $join->on('planning_compliances_scores.id', '=', 'planning_assessment.compliances_id');
        })
        ->select(
        'planning_indicators.id',
        'planning_indicators.ref_no',
        'planning_indicators.indicator_name',
        'planning_indicators.is_mandatory',
        DB::raw('planning_indicators.weightage * 100 as indicatorWeightage'),
        'planning_assessment.score',
        'planning_compliances_scores.comp_name',
        'planning_compliances_scores.score as complianceScore'
        )
        ->get();

        return $planningInfo;
    }
    // Get Planning info against Project Id and Indicator Id...
    public function getPlanningByProjectIndicator($project_id,$indicator_id,$phaseName)
    {
        $planningInfo = PlanningAssess::select(
            'planning_assessment.id',
            'planning_assessment.indicator_id',
            'planning_compliances_scores.comp_name',
            'planning_compliances_scores.score as complianceScore',
            DB::raw('planning_indicators.weightage * 100 as indicatorWeightage'),
            'final_rating_score.score as finalScore',
            'final_rating_score.rating as finalRating',
        )
        ->leftJoin('planning_compliances_scores', 'planning_compliances_scores.id', '=', 'planning_assessment.compliances_id')
        ->leftJoin('planning_indicators', 'planning_indicators.id', '=', 'planning_assessment.indicator_id')
        ->leftJoin('final_rating_score', 'final_rating_score.project_id', '=', 'planning_assessment.project_id')
        ->where('planning_assessment.project_id', $project_id)
        ->where('planning_assessment.indicator_id', $indicator_id)
        ->where('final_rating_score.phase', $phaseName)
        ->first();

        return $planningInfo;
    }

}
