<?php

namespace App\Repositories;
use Carbon\Carbon;
use App\Models\Project;
use App\Models\ProjectChecklist;
use App\Models\PlanningIndicators;
use App\Models\PlanningAssess;
use App\Models\PlanningComment;
use App\Models\DesignIndicators;
use App\Models\DesignAssess;
use App\Models\DesignComment;
use App\Models\ConstructionIndicators;
use App\Models\ConstructionAssess;
use App\Models\ConstructionComment;
use App\Models\Thresholds;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProjectRepository
{
    public function getAll($request)
    {
        $limit = env('PER_PAGE_LIMIT', 10);
        $projects= Project::with(['current_phase:id,phase_name','organization:id,organization_name','building_type:id,type_name'])
        ->orderBy('id', 'DESC')->paginate($limit)->setPath('');
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
       // dd("repooo");
        
        $project = $this->getById($id);
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
        $project->updated_by = auth()->user()->id;
        DB::transaction(function () use ($project) { $project->save(); });
        //$lastInsertedId = $project->id;
        return $project;
        
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
        $organizations = DB::table('organizations')->pluck('organization_name', 'id');
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
    public function getCommentsInfo($project_id,$indicator_id,$comments_for,$comment_id){
       if($comments_for == 'Planning'){
        return PlanningComment::where('project_id', $project_id)
        ->where('indicator_id', $indicator_id)
        ->where('id', $comment_id)
        ->first();
       }
       if($comments_for == 'Design'){
        return DesignComment::where('project_id', $project_id)
        ->where('indicator_id', $indicator_id)
        ->where('id', $comment_id)
        ->first();
       }
       if($comments_for == 'Construction'){
        return ConstructionComment::where('project_id', $project_id)
        ->where('indicator_id', $indicator_id)
        ->where('id', $comment_id)
        ->first();
       }
    }
   
    public function getDesignAssessInfo($project_id,$indicator_id){
        return DesignAssess::where('project_id', $project_id)
        ->where('indicator_id', $indicator_id)
        ->first();

    }
    public function getConstructionAssessInfo($project_id,$indicator_id){
        return ConstructionAssess::where('project_id', $project_id)
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
    public function getDesignIndicatorWeightage($indicator_id)
    {   
        $pIndcatorWeight = DB::table('design_indicators')->where('id', $indicator_id)->value('weightage');
        return $pIndcatorWeight;
    }
    public function getDesignComplianceScore($compliance_id)
    {   
        $pComplianceScore = DB::table('design_compliances_scores')->where('id', $compliance_id)->value('score');
        return $pComplianceScore;
    }
    public function getConstructionIndicatorWeightage($indicator_id)
    {   
        $pIndcatorWeight = DB::table('construction_indicators')->where('id', $indicator_id)->value('weightage');
        return $pIndcatorWeight;
    }
    public function getConstructionComplianceScore($compliance_id)
    {   
        $pComplianceScore = DB::table('construction_compliances_scores')->where('id', $compliance_id)->value('score');
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

    public function resetDesignAssessFile($project_id,$indicator_id)
    {
        $checklist = $this->getDesignAssessInfo($project_id,$indicator_id);
        if ($checklist && $checklist->file_path && Storage::disk('public')->exists($checklist->file_path)) {
            Storage::disk('public')->delete($checklist->file_path);
            $checklist->file_path = null;
            $checklist->file_name = null;
            $checklist->save();    
        }
    }
    public function resetConstructionAssessFile($project_id,$indicator_id)
    {
        $checklist = $this->getConstructionAssessInfo($project_id,$indicator_id);
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
    public function saveSummary($request)
    {
        $project = Project::find($request->updatedProjectId); 
            $project->executive_summary = $request->executive_summary;
            $project->updated_by = auth()->user()->id;
            $project->save();

    }
    public function resetCommentsInfo($request,$dataExists)
    {
        $dataExists->comments = $request->comments;
        $dataExists->updated_by = auth()->user()->id;
        $dataExists->save();

    }
    public function resetCostInfo($request)
    {
        if($request->cost_phase =='cost_at_design'){
            $project = Project::find($request->updatedProjectId); 
            $project->cost_at_design = $request->cost_at_design;
            $project->updated_by = auth()->user()->id;
            $project->save();
        }
        if($request->cost_phase =='cost_at_construction'){
            $project = Project::find($request->updatedProjectId); 
            $project->cost_at_construction = $request->cost_at_construction;
            $project->updated_by = auth()->user()->id;
            $project->save();

        }
    }
    public function resetDesignAssessInfo($request,$dataExists)
    {
        $assessScore = $this->calculateDesignIndicatorScore($request->indicator_id,$request->compliance);
        // Delete old file if uploading new one
        if ($request->file('design_uploads') && !is_null($dataExists->file_path) && Storage::disk('public')->exists($dataExists->file_path)) {
            Storage::disk('public')->delete($dataExists->file_path);
        }
        // Update record
        if ($request->file('design_uploads')) {
            $dataExists->file_name = $request->filename;
            $dataExists->file_path = $request->path;
        }
        $dataExists->compliances_id = $request->compliance;
        $dataExists->score = $assessScore;
        $dataExists->updated_by = auth()->user()->id;
        $dataExists->save();

        // Get sum of Design scores for all indicators against project id...
        $designTotalScores = $this->getDesignTotalScore($request->updatedProjectId);
        $fixedWeightDesign = 0.45; // 45%
        $finalDesignScore =  $designTotalScores * 10 * $fixedWeightDesign;
        $calculateRating = ($finalDesignScore / 45)*100; //45%
        $this->insertFinalScoreRating($request->updatedProjectId,'Design',$finalDesignScore,$calculateRating);

    }

    public function resetConstructionAssessInfo($request,$dataExists)
    {
        $assessScore = $this->calculateConstructionIndicatorScore($request->indicator_id,$request->compliance);
        // Delete old file if uploading new one
        if ($request->file('cons_uploads') && !is_null($dataExists->file_path) && Storage::disk('public')->exists($dataExists->file_path)) {
            Storage::disk('public')->delete($dataExists->file_path);
        }
        // Update record
        if ($request->file('cons_uploads')) {
            $dataExists->file_name = $request->filename;
            $dataExists->file_path = $request->path;
        }
        $dataExists->compliances_id = $request->compliance;
        $dataExists->score = $assessScore;
        $dataExists->updated_by = auth()->user()->id;
        $dataExists->save();

        // Get sum of Construction scores for all indicators against project id...
        $consTotalScores = $this->getConstructionTotalScore($request->updatedProjectId);
        $fixedWeightCons = 0.1; // 10%
        $finalConsScore =  $consTotalScores * 10 * $fixedWeightCons;
        $calculateRating = ($finalConsScore / 10)*100; //10%
        $this->insertFinalScoreRating($request->updatedProjectId,'Construction',$finalConsScore,$calculateRating);

    }
    // Sum up total score for all indicators against project id...
    public function getConstructionTotalScore($projectId){
        //$hasZero = ConstructionAssess::where('project_id', $projectId)->whereIn('indicator_id', [2, 3, 5, 6, 7, 9, 10, 11, 14, 15, 16])->where('score', 0)->exists();
        //$totalScore = $hasZero ? 0 : DesignAssess::where('project_id', $projectId)->sum('score');
        $totalScore = ConstructionAssess::where('project_id', $projectId)->sum('score');
        return $totalScore;

    }

    // Sum up total score for all indicators against project id...
    public function getPlanningTotalScore($projectId){
        $hasZero = PlanningAssess::where('project_id', $projectId)->whereIn('indicator_id', [1, 4, 6])->where('score', 0)->exists();
        $totalScore = $hasZero ? 0 : PlanningAssess::where('project_id', $projectId)->sum('score');
        return $totalScore;

    }
    // Sum up total score for all indicators against project id...
    public function getDesignTotalScore($projectId){
        $hasZero = DesignAssess::where('project_id', $projectId)->whereIn('indicator_id', [2, 3, 5, 6, 7, 9, 10, 11, 14, 15, 16])->where('score', 0)->exists();
        $totalScore = $hasZero ? 0 : DesignAssess::where('project_id', $projectId)->sum('score');
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
    public function getPhaseFinalScoreRating($projectId,$phaseName)
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
    public function calculateDesignIndicatorScore($indicator_id,$compliance_id)
    {
        $pIndcatorWeight = $this->getDesignIndicatorWeightage($indicator_id);
        $pComplianceScore = $this->getDesignComplianceScore($compliance_id);
        $assessScore = $pIndcatorWeight * $pComplianceScore;
        return $assessScore;

    }
    public function calculateConstructionIndicatorScore($indicator_id,$compliance_id)
    {
        $pIndcatorWeight = $this->getConstructionIndicatorWeightage($indicator_id);
        $pComplianceScore = $this->getConstructionComplianceScore($compliance_id);
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

    public function createCommentsItem($request)
    {
        if($request->comments_for == 'Planning'){
            $newComments = new PlanningComment();
        }
        if($request->comments_for == 'Design'){
            $newComments = new DesignComment();
        }
        if($request->comments_for == 'Construction'){
            $newComments = new ConstructionComment();
        }
        $newComments->project_id = $request->updatedProjectId;
        $newComments->indicator_id = $request->indicator_id;
        $newComments->comments = $request->comments;
        $newComments->created_by = auth()->user()->id;
        DB::transaction(function () use ($newComments) { $newComments->save(); });
        return $newComments;
    }
    public function createDesingAssessmentItem($request)
    {
        //dd($request->country_name);
        $newChecklist = new DesignAssess();
        $assessScore = $this->calculateDesignIndicatorScore($request->indicator_id,$request->compliance);
        $newChecklist->project_id = $request->updatedProjectId;
        $newChecklist->indicator_id = $request->indicator_id;
        $newChecklist->compliances_id = $request->compliance;
        $newChecklist->score = $assessScore;
        $newChecklist->created_by = auth()->user()->id;

        if ($request->file('design_uploads')) {
            $newChecklist->file_name = $request->filename;
            $newChecklist->file_path = $request->path;
        }
        DB::transaction(function () use ($newChecklist) { $newChecklist->save(); });
        // Get sum of Planning scores for all indicators against project id...
        $designTotalScores = $this->getDesignTotalScore($request->updatedProjectId);
        $fixedWeightDesign= 0.45; // 45%
        $finalDesignScore =  $designTotalScores * 10 * $fixedWeightDesign;
        $calculateRating = ($finalDesignScore / 45)*100; //45%
        $this->insertFinalScoreRating($request->updatedProjectId,'Design',$finalDesignScore,$calculateRating);

        return $newChecklist;
    }

    public function createConstructionAssessmentItem($request)
    {
        //dd($request->country_name);
        $newChecklist = new ConstructionAssess();
        $assessScore = $this->calculateConstructionIndicatorScore($request->indicator_id,$request->compliance);
        $newChecklist->project_id = $request->updatedProjectId;
        $newChecklist->indicator_id = $request->indicator_id;
        $newChecklist->compliances_id = $request->compliance;
        $newChecklist->score = $assessScore;
        $newChecklist->created_by = auth()->user()->id;

        if ($request->file('cons_uploads')) {
            $newChecklist->file_name = $request->filename;
            $newChecklist->file_path = $request->path;
        }
        DB::transaction(function () use ($newChecklist) { $newChecklist->save(); });
        // Get sum of Construction scores for all indicators against project id...
        $consTotalScores = $this->getConstructionTotalScore($request->updatedProjectId);
        $fixedWeightCons = 0.1; // 10%
        $finalConsScore =  $consTotalScores * 10 * $fixedWeightCons;
        $calculateRating = ($finalConsScore / 10)*100; //10%
        $this->insertFinalScoreRating($request->updatedProjectId,'Construction',$finalConsScore,$calculateRating);

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
        /*
        $planningInfo = DB::table('planning_indicators')
        ->leftJoin('planning_assessment', function ($join) use ($project_id) {
            $join->on('planning_indicators.id', '=', 'planning_assessment.indicator_id')
                ->where('planning_assessment.project_id', '=', $project_id);
        })
        ->leftJoin('planning_compliances_scores', function ($join) {
            $join->on('planning_compliances_scores.id', '=', 'planning_assessment.compliances_id');
        })
        ->leftJoin('planning_comments', function ($join) use ($project_id) {
            $join->on('planning_comments.indicator_id', '=', 'planning_indicators.id')
                ->where('planning_comments.project_id', '=', $project_id);
        })
        ->select(
            'planning_indicators.id',
            'planning_indicators.ref_no',
            'planning_indicators.indicator_name',
            'planning_indicators.is_mandatory',
            DB::raw('planning_indicators.weightage * 100 as indicatorWeightage'),
            'planning_assessment.score',
            'planning_compliances_scores.comp_name',
            'planning_compliances_scores.score as complianceScore',
            'planning_comments.comments as comments',
            'planning_comments.id as comment_id'
        )
        ->get();
        return $planningInfo;
        */
        // Fetch indicators with related data
        $indicators = PlanningIndicators::with([
            'assessments' => function ($q) use ($project_id) {
                $q->where('project_id', $project_id)->with('compliance');
            },
            'comments' => function ($q) use ($project_id) {
                $q->where('project_id', $project_id)->with('user');
            }
        ])->get();
        
        $planningScoresRatings = $indicators->map(function ($indicator) {
            $assessment = $indicator->assessments->first();
            $compliance = $assessment?->compliance;
        
            return (object)[
                'id' => $indicator->id,
                'ref_no' => $indicator->ref_no,
                'indicator_name' => $indicator->indicator_name,
                'is_mandatory' => $indicator->is_mandatory,
                'indicatorWeightage' => $indicator->weightage * 100,
                'score' => $assessment?->score,
                'comp_name' => $compliance?->comp_name,
                'complianceScore' => $compliance?->score,
                'comments' => $indicator->comments,
                'comment_id' => $indicator->comments->first()?->id,
            ];
        });
        return $planningScoresRatings;
        
    }
    public function getDesignInfoByProjectId($project_id)
    {
        /*
        $designInfo = DB::table('design_indicators')
        ->leftJoin('design_assessment', function ($join) use ($project_id) {
        $join->on('design_indicators.id', '=', 'design_assessment.indicator_id')
        ->where('design_assessment.project_id', '=', $project_id);
        })
        ->leftJoin('design_compliances_scores', function ($join) use ($project_id) {
        $join->on('design_compliances_scores.id', '=', 'design_assessment.compliances_id');
        })
        ->leftJoin('design_comments', function ($join) use ($project_id) {
            $join->on('design_comments.indicator_id', '=', 'design_indicators.id')
                ->where('design_comments.project_id', '=', $project_id);
        })
        ->select(
        'design_indicators.id',
        'design_indicators.ref_no',
        'design_indicators.indicator_name',
        'design_indicators.is_mandatory',
        DB::raw('design_indicators.weightage * 100 as indicatorWeightage'),
        'design_assessment.compliances_id',
        'design_assessment.score',
        'design_assessment.file_path',
        'design_compliances_scores.comp_name',
        'design_compliances_scores.score as complianceScore',
        'design_comments.comments as comments'
        )
        ->get();
        return $designInfo;
        */

        $indicators = DesignIndicators::with([
            'assessments' => function ($q) use ($project_id) {
                $q->where('project_id', $project_id)->with('compliance');
            },
            'comments' => function ($q) use ($project_id) {
                $q->where('project_id', $project_id)->with('user');
            }
        ])->get();
        
        $designInfo = $indicators->map(function ($indicator) {
            $assessment = $indicator->assessments->first();
            $compliance = $assessment?->compliance;
        
            return (object)[
                'id' => $indicator->id,
                'ref_no' => $indicator->ref_no,
                'indicator_name' => $indicator->indicator_name,
                'is_mandatory' => $indicator->is_mandatory,
                'indicatorWeightage' => $indicator->weightage * 100,
                'score' => $assessment?->score,
                'compliances_id' => $assessment?->compliances_id,
                'file_path' => $assessment?->file_path,
                'comp_name' => $compliance?->comp_name,
                'complianceScore' => $compliance?->score,
                'comments' => $indicator->comments,
                'comment_id' => $indicator->comments->first()?->id,
            ];
        });
        return $designInfo;



    }
    public function getConstructionInfoByProjectId($project_id)
    {
        /*
        $designInfo = DB::table('construction_indicators')
        ->leftJoin('construction_assessment', function ($join) use ($project_id) {
        $join->on('construction_indicators.id', '=', 'construction_assessment.indicator_id')
        ->where('construction_assessment.project_id', '=', $project_id);
        })
        ->leftJoin('construction_compliances_scores', function ($join) use ($project_id) {
        $join->on('construction_compliances_scores.id', '=', 'construction_assessment.compliances_id');
        })
        ->leftJoin('construction_comments', function ($join) use ($project_id) {
            $join->on('construction_comments.indicator_id', '=', 'construction_indicators.id')
                ->where('construction_comments.project_id', '=', $project_id);
        })
        ->select(
        'construction_indicators.id',
        'construction_indicators.ref_no',
        'construction_indicators.indicator_name',
        'construction_indicators.is_mandatory',
        DB::raw('construction_indicators.weightage * 100 as indicatorWeightage'),
        'construction_assessment.compliances_id',
        'construction_assessment.score',
        'construction_assessment.file_path',
        'construction_compliances_scores.comp_name',
        'construction_compliances_scores.score as complianceScore',
        'construction_comments.comments as comments'
        )
        ->get();

        return $designInfo;
        */
        $indicators = ConstructionIndicators::with([
            'assessments' => function ($q) use ($project_id) {
                $q->where('project_id', $project_id)->with('compliance');
            },
            'comments' => function ($q) use ($project_id) {
                $q->where('project_id', $project_id)->with('user');
            }
        ])->get();
        
        $constructionInfo = $indicators->map(function ($indicator) {
            $assessment = $indicator->assessments->first();
            $compliance = $assessment?->compliance;
        
            return (object)[
                'id' => $indicator->id,
                'ref_no' => $indicator->ref_no,
                'indicator_name' => $indicator->indicator_name,
                'is_mandatory' => $indicator->is_mandatory,
                'indicatorWeightage' => $indicator->weightage * 100,
                'score' => $assessment?->score,
                'compliances_id' => $assessment?->compliances_id,
                'file_path' => $assessment?->file_path,
                'comp_name' => $compliance?->comp_name,
                'complianceScore' => $compliance?->score,
                'comments' => $indicator->comments,
                'comment_id' => $indicator->comments->first()?->id,
            ];
        });
        return $constructionInfo;
    }



    // Get Planning info against Project Id and Indicator Id...
    /*
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
    */

     // Get Desing info against each Project Id and each Indicator Id...
     /*
     public function getDesignByProjectIndicator($project_id,$indicator_id,$phaseName)
     {
         $planningInfo = DesignAssess::select(
             'design_assessment.id',
             'design_assessment.indicator_id',
             'design_compliances_scores.comp_name',
             'design_compliances_scores.score as complianceScore',
             DB::raw('design_indicators.weightage * 100 as indicatorWeightage'),
             'final_rating_score.score as finalScore',
             'final_rating_score.rating as finalRating',
         )
         ->leftJoin('design_compliances_scores', 'design_compliances_scores.id', '=', 'design_assessment.compliances_id')
         ->leftJoin('design_indicators', 'design_indicators.id', '=', 'design_assessment.indicator_id')
         ->leftJoin('final_rating_score', 'final_rating_score.project_id', '=', 'design_assessment.project_id')
         ->where('design_assessment.project_id', $project_id)
         ->where('design_assessment.indicator_id', $indicator_id)
         ->where('final_rating_score.phase', $phaseName)
         ->first();
 
         return $planningInfo;
     }
         */
     // Get construction info against each Project Id and each Indicator Id...
     /*
     public function getConstructionByProjectIndicator($project_id,$indicator_id,$phaseName)
     {
         $planningInfo = ConstructionAssess::select(
             'construction_assessment.id',
             'construction_assessment.indicator_id',
             'construction_compliances_scores.comp_name',
             'construction_compliances_scores.score as complianceScore',
             DB::raw('construction_indicators.weightage * 100 as indicatorWeightage'),
             'final_rating_score.score as finalScore',
             'final_rating_score.rating as finalRating',
         )
         ->leftJoin('construction_compliances_scores', 'construction_compliances_scores.id', '=', 'construction_assessment.compliances_id')
         ->leftJoin('construction_indicators', 'construction_indicators.id', '=', 'construction_assessment.indicator_id')
         ->leftJoin('final_rating_score', 'final_rating_score.project_id', '=', 'construction_assessment.project_id')
         ->where('construction_assessment.project_id', $project_id)
         ->where('construction_assessment.indicator_id', $indicator_id)
         ->where('final_rating_score.phase', $phaseName)
         ->first();
 
         return $planningInfo;
     }
    */
    
    /*
     Get Mandatory Requirement values against Construction cost..
    */
    public function getthresholds()
    {
        return Thresholds::select('id', 'min_value', 'max_value', 'output_1', 'output_2', 'output_3')->first();
    }


}
