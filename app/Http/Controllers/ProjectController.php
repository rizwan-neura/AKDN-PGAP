<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProjectRequest;

use App\Repositories\ProjectRepository;

use App\Http\Requests\ProjectChecklistRequest;
use App\Http\Requests\PlanningAssessRequest;
use App\Http\Requests\DesignAssessRequest;
use App\Http\Requests\ConstructionAssessRequest;
use App\Http\Requests\CommentsRequest;
use App\Http\Requests\ExecutiveSummaryRequest;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Exception;
use Illuminate\Support\Facades\Log;

class ProjectController extends Controller
{
    
    protected $projectRepository;
    protected $checklistRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository = $projectRepository;
        
       
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $this->projectRepository->getAll($request);
        //dd($data);
        return view('projects.index', compact('data'));   
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projectPhases = $this->projectRepository->getProjectPhases();
        $organizations = $this->projectRepository->getOrganizations();
        $buildingTypes = $this->projectRepository->getBuildingTypes();
        $thresholds = $this->projectRepository->getthresholds();// Get Mandatory requirements
        return view('projects.create', compact('projectPhases', 'organizations', 'buildingTypes','thresholds'));   
    }
    /**
     * Store a newly created resource in storage.
     */
    /*
     public function store(ProjectRequest $request)
    {
        $project = $this->projectRepository->create($request);   
        return redirect()->to(route('projects.edit',$project->id))->with(['message' => 'Project has been added successfully.']);
    }
        */
    public function store(ProjectRequest $request)
    {
        try {
                $project = $this->projectRepository->create($request);   
                return response()->json([
                    'status' => 'success',
                    'redirect_url' => route('projects.edit', $project->id),
                    'project_id' => $project->id
                ]);   
            
        } catch (\Exception $e) {
            Log::error('Save info failed: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred during file upload.',
            ], 500);
        }
            
    }
    /**
     * Display the subtype dropdowns.
     */
    
    public function getBuildingSubTypes(Request $request)
    {
        //return response()->json(['data' => $request->type_id]);
        $buildingSubTypes = $this->projectRepository->getBuildingSubTypes($request->type_id);
        $data = view('projects.subtypes', compact('buildingSubTypes'))->render();
        $statusCode = 201;
            //$response = parse_json_api_response($data, $statusCode);
            $response = [
                'message' => 'Data found',
                'success' => true,
                'data' => $data,
                'status' => $statusCode
            ];
            return response()->json($response, $statusCode);
    }
    /**
     * Save project checklists information.
     */
    
   public function saveCheckList(ProjectChecklistRequest $request)
    {
        $canDelete = true; 
        try {
            //Safe file access
            $file = $request->file('checklist_uploads');
            $filename = null;
            $path = null;

            if ($file) {
                // Get original name and extension
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                // Slugify the base name (removes spaces, special chars)
                $cleanName = Str::slug($originalName); 
                // Add unique ID or timestamp
                $filename = $cleanName . '_' . uniqid() . '.' . $extension;
                // Define path
                $path = 'uploads/project_checklist/' . $filename;
                Storage::disk('public')->putFileAs('uploads/project_checklist', $file, $filename);
            }
            // Check if checklist already exists
            $checklist = $this->projectRepository->getProjectChecklistInfo($request->updatedProjectId,$request->checklist_id);

            if ($checklist) {
                // Delete old file if uploading new one
                if ($file && !is_null($checklist->file_path) && Storage::disk('public')->exists($checklist->file_path)) {
                    Storage::disk('public')->delete($checklist->file_path);
                }
                // Update record
                if ($file) {
                    $checklist->file_name = $filename;
                    $checklist->file_path = $path;
                }
                $checklist->status = $request->checklistStatus;
                $checklist->updated_by = auth()->user()->id;
                $checklist->save();

                return response()->json([
                    'status' => 'success',
                    'message' => $checklist ? 'Checklist updated!' : 'Checklist saved!',
                    'file_name' => $filename,
                    'file_url' => $file ? Storage::url($path) : null,
                    'checklist_id' => $request->checklist_id,
                    'can_delete' => $canDelete, // ✅ Include this
                ]);
            } 
            else {
                // New insert
                $request->request->add(['filename' => $filename, 'path' => $path]);
                $checklist = $this->projectRepository->createProjectChecklistItem($request);

                return response()->json([
                    'status' => 'success',
                    'message' => $checklist ? 'Checklist saved!' : 'Checklist saved!',
                    'file_name' => $filename,
                    'file_url' => $file ? Storage::url($path) : null,
                    'checklist_id' => $request->checklist_id,
                    'can_delete' => $canDelete, // ✅ Include this
                ]);
            }

        } catch (Exception $e) {
            Log::error('Checklist Save Failed: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred during file upload.',
            ], 500);
        }
    }
    public function deleteChecklistFile(Request $request)
    {
        $this->projectRepository->resetProjectChecklistInfo($request->updatedProjectId,$request->checklist_id);
        return response()->json(['status' => 'success', 'message' => 'File deleted.']);
    }
    public function savePlanningAssessment(PlanningAssessRequest $request)
    {
        $canDelete = true; 
        //return response()->json(['data' => $request->updatedProjectId]);
        
        try {
            //Safe file access
            $file = $request->file('planning_uploads');
            $filename = null;
            $path = null;

            if ($file) {
                // Get original name and extension
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                // Slugify the base name (removes spaces, special chars)
                $cleanName = Str::slug($originalName); 
                // Add unique ID or timestamp
                $filename = $cleanName . '_' . uniqid() . '.' . $extension;
                // Define path
                $path = 'uploads/planning/' . $filename;
                Storage::disk('public')->putFileAs('uploads/planning', $file, $filename);
            }
        
            // Check if indicator already exists
            $dataExists = $this->projectRepository->getPlanningAssessInfo($request->updatedProjectId,$request->indicator_id);
               
            if ($dataExists) {
                $request->request->add(['filename' => $filename, 'path' => $path]);
                //Update existing data...
                $this->projectRepository->resetPlanningAssessInfo($request,$dataExists);
                //To show in Review Portion: Get Planning info against Project ID and Indicator ID
                //$planningReviewPortion = $this->projectRepository->getPlanningByProjectIndicator($request->updatedProjectId,$request->indicator_id,'Planning');
                
                return response()->json([
                    'status' => 'success',
                    'message' => $dataExists ? 'Info updated successfully!' : 'Info saved!',
                    'file_name' => $filename,
                    'file_url' => $file ? Storage::url($path) : null,
                    //'indicator_id' => $request->indicator_id,
                    'can_delete' => $canDelete, 
                    //'planning_review_info' => $planningReviewPortion, 
                ]);
            } 
            else {
                // New insert
                $request->request->add(['filename' => $filename, 'path' => $path]);
                $newData = $this->projectRepository->createPlanningAssessmentItem($request);
                //To show in Review Portion: Get Planning info against Project ID and Indicator ID
                //$planningReviewPortion = $this->projectRepository->getPlanningByProjectIndicator($request->updatedProjectId,$request->indicator_id,'Planning');
                return response()->json([
                    'status' => 'success',
                    'message' => $newData ? 'Info saved successfully!' : 'Info saved!',
                    'file_name' => $filename,
                    'file_url' => $file ? Storage::url($path) : null,
                    //'indicator_id' => $request->indicator_id,
                    'can_delete' => $canDelete,
                    //'planning_review_info' => $planningReviewPortion, 
                ]);
                
            }

        } catch (\Exception $e) {
            Log::error('Infos Save Failed: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred during file upload.',
            ], 500);
        }
            
    }

    public function deletePlanningFile(Request $request)
    {
        $this->projectRepository->resetPlanningAssessFile($request->updatedProjectId,$request->indicator_id);
        return response()->json(['status' => 'success', 'message' => 'File deleted successfully.']);
    }
    /*
    Save planning reveiw comments
    */
    public function saveComments(CommentsRequest $request)
    {
        $canDelete = true; 
        try {
            // Check if comment already exists
            $dataExists = $this->projectRepository->getCommentsInfo($request->updatedProjectId,$request->indicator_id,$request->comments_for,$request->comment_id);
            if ($dataExists) {
                //Update existing data...
                $this->projectRepository->resetCommentsInfo($request,$dataExists);
                return response()->json([
                    'status' => 'success',
                    'message' => $dataExists ? 'Comment updated successfully!' : 'Info saved!',
                    'indicator_id' => $request->indicator_id,
                    'can_delete' => $canDelete, 
                ]);
            } 
            else {
                // New insert
                $newData = $this->projectRepository->createCommentsItem($request);
                return response()->json([
                    'status' => 'success',
                    'message' => $newData ? 'Comment saved successfully!' : 'Info saved!',
                    'indicator_id' => $request->indicator_id,
                    'can_delete' => $canDelete,
                ]);    
            }
        } catch (\Exception $e) {
            Log::error('Save info failed: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred during file upload.',
            ], 500);
        }
            
    }
        /*
    Save planning reveiw comments
    */
    public function saveSummary(ExecutiveSummaryRequest $request, $id)
    {
        try {
            // Get project by ID (safely)
            $this->projectRepository->saveSummary($request);
    
            // Return back with success message
            return redirect()
                ->back()
                ->with('success', 'Executive Summary updated successfully.');
        } catch (\Exception $e) {
            // Log the error for debugging
            Log::error('Executive Summary Update Error: '.$e->getMessage());
    
            // Return back with error message
            return redirect()
                ->back()
                ->with('error', 'An error occurred while updating the Executive Summary.');
        }
    }
     /*
        Update construction cost in Design and construction
    */
    public function updateCost(ProjectRequest $request)
    {
        try {
            $this->projectRepository->resetCostInfo($request);
            return response()->json([
                'status' => 'success',
                'message' => 'Cost updated successfully!',
                
            ]);
          
        } catch (\Exception $e) {
            Log::error('Save info failed: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred during file upload.',
            ], 500);
        }
            
    }
    public function saveDesignAssessment(DesignAssessRequest $request)
    {
        $canDelete = true; 
        //return response()->json(['data' => $request->updatedProjectId]);
        
        try {
            //Safe file access
            $file = $request->file('design_uploads');
            $filename = null;
            $path = null;

            if ($file) {
                // Get original name and extension
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                // Slugify the base name (removes spaces, special chars)
                $cleanName = Str::slug($originalName); 
                // Add unique ID or timestamp
                $filename = $cleanName . '_' . uniqid() . '.' . $extension;
                // Define path
                $path = 'uploads/design/' . $filename;
                Storage::disk('public')->putFileAs('uploads/design', $file, $filename);
            }
        
            // Check if indicator already exists
            $dataExists = $this->projectRepository->getDesignAssessInfo($request->updatedProjectId,$request->indicator_id);
               
            if ($dataExists) {
                $request->request->add(['filename' => $filename, 'path' => $path]);
                //Update existing data...
                $this->projectRepository->resetDesignAssessInfo($request,$dataExists);
                //To show in Review Portion: Get Design info against each Project ID and each Indicator ID
                //$desingReviewPortion = $this->projectRepository->getDesignByProjectIndicator($request->updatedProjectId,$request->indicator_id,'Design');
                
                return response()->json([
                    'status' => 'success',
                    'message' => $dataExists ? 'Info updated successfully!' : 'Info saved!',
                    'file_name' => $filename,
                    'file_url' => $file ? Storage::url($path) : null,
                    //'indicator_id' => $request->indicator_id,
                    'can_delete' => $canDelete, 
                    //'design_review_info' => $desingReviewPortion, 
                ]);
            } 
            else {
                // New insert
                $request->request->add(['filename' => $filename, 'path' => $path]);
                $newData = $this->projectRepository->createDesingAssessmentItem($request);
                 //To show in Review Portion: Get Design info against each Project ID and each Indicator ID
                 //$desingReviewPortion = $this->projectRepository->getDesignByProjectIndicator($request->updatedProjectId,$request->indicator_id,'Design');
                
                return response()->json([
                    'status' => 'success',
                    'message' => $newData ? 'Info saved successfully!' : 'Info saved!',
                    'file_name' => $filename,
                    'file_url' => $file ? Storage::url($path) : null,
                    //'indicator_id' => $request->indicator_id,
                    'can_delete' => $canDelete,
                    //'design_review_info' => $desingReviewPortion, 
                ]);
                
            }

        } catch (\Exception $e) {
            Log::error('Infos Save Failed: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred during file upload.',
            ], 500);
        }
            
    }
    public function deleteDesignFile(Request $request)
    {
        $this->projectRepository->resetDesignAssessFile($request->updatedProjectId,$request->indicator_id);
        return response()->json(['status' => 'success', 'message' => 'File deleted successfully.']);
    }

    public function saveConstructionAssessment(ConstructionAssessRequest $request)
    {
        $canDelete = true; 
        //return response()->json(['data' => $request->updatedProjectId]);
        
        try {
            //Safe file access
            $file = $request->file('cons_uploads');
            $filename = null;
            $path = null;

            if ($file) {
                // Get original name and extension
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                // Slugify the base name (removes spaces, special chars)
                $cleanName = Str::slug($originalName); 
                // Add unique ID or timestamp
                $filename = $cleanName . '_' . uniqid() . '.' . $extension;
                // Define path
                $path = 'uploads/construction/' . $filename;
                Storage::disk('public')->putFileAs('uploads/construction', $file, $filename);
            }
        
            // Check if indicator already exists
            $dataExists = $this->projectRepository->getConstructionAssessInfo($request->updatedProjectId,$request->indicator_id);
               
            if ($dataExists) {
                $request->request->add(['filename' => $filename, 'path' => $path]);
                //Update existing data...
                $this->projectRepository->resetConstructionAssessInfo($request,$dataExists);
                //To show in Review Portion: Get Design info against each Project ID and each Indicator ID
                //$consReviewPortion = $this->projectRepository->getConstructionByProjectIndicator($request->updatedProjectId,$request->indicator_id,'Construction');
                
                return response()->json([
                    'status' => 'success',
                    'message' => $dataExists ? 'Info updated successfully!!' : 'Info saved!',
                    'file_name' => $filename,
                    'file_url' => $file ? Storage::url($path) : null,
                    'indicator_id' => $request->indicator_id,
                    'can_delete' => $canDelete, 
                    //'cons_review_info' => $consReviewPortion, 
                ]);
            } 
            else {
                // New insert
                $request->request->add(['filename' => $filename, 'path' => $path]);
                $newData = $this->projectRepository->createConstructionAssessmentItem($request);
                 //To show in Review Portion: Get Construction info against each Project ID and each Indicator ID
                //$consReviewPortion = $this->projectRepository->getConstructionByProjectIndicator($request->updatedProjectId,$request->indicator_id,'Construction');
                
                return response()->json([
                    'status' => 'success',
                    'message' => $newData ? 'Info saved successfully!' : 'Info saved!',
                    'file_name' => $filename,
                    'file_url' => $file ? Storage::url($path) : null,
                    'indicator_id' => $request->indicator_id,
                    'can_delete' => $canDelete,
                    //'cons_review_info' => $consReviewPortion, 
                ]);
                
            }

        } catch (\Exception $e) {
            Log::error('Infos Save Failed: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred during file upload.',
            ], 500);
        }
            
    }
    public function deleteConstructionFile(Request $request)
    {
        $this->projectRepository->resetConstructionAssessFile($request->updatedProjectId,$request->indicator_id);
        return response()->json(['status' => 'success', 'message' => 'File deleted successfully.']);
    }
   
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $project = $this->projectRepository->getById($id);  
        $projectPhases = $this->projectRepository->getProjectPhases();
        $organizations = $this->projectRepository->getOrganizations();
        $buildingTypes = $this->projectRepository->getBuildingTypes();
        $thresholds = $this->projectRepository->getthresholds();// Get Mandatory requirements

        return view('projects.edit', compact('projectPhases', 'organizations', 'buildingTypes','project','thresholds'));   
   
    }
    /*
    public function edit($id)
    {
        $project = $this->projectRepository->getById($id);  
        $projectPhases = $this->projectRepository->getProjectPhases();
        $organizations = $this->projectRepository->getOrganizations();
        $buildingTypes = $this->projectRepository->getBuildingTypes();
       
        $projectCheckLists = $this->projectRepository->getChecklistsByProjectId($id); 
        $totalChecklistCount = $projectCheckLists->count(); // This is required..

        // Planning assessment page... where indicators are static in blade
        $planningAssessment = $this->projectRepository->getPlanningAssessmentsByProject($id); 
        //$totalChecklistCount = $planningAssessment->count(); // This is required..
        
        // To show in review portion page.. where indicators and all values are getting from DB with loop...
        $planningScoresRatings = $this->projectRepository->getPlanningInfoByProjectId($id); 
        // To show in review page.. for final scoring and ratings...
        $planningFinalScoreRating = $this->projectRepository->getPhaseFinalScoreRating($id,'Planning');

        // Get design indicators,compliances and assessments...
        $designAssessmentInfo = $this->projectRepository->getDesignInfoByProjectId($id); 
        // To show in review page.. for final scoring and ratings...
        $designFinalScoreRating = $this->projectRepository->getPhaseFinalScoreRating($id,'Design');

        // Get construction indicators,compliances and assessments...
        $constructionAssessInfo = $this->projectRepository->getConstructionInfoByProjectId($id); 
        // To show in review page.. for final scoring and ratings...
        $constructionFinalScoreRating = $this->projectRepository->getPhaseFinalScoreRating($id,'Construction');

        $thresholds = $this->projectRepository->getthresholds();// Get Mandatory requirements

        return view('projects.edit', compact('projectPhases', 'organizations', 'buildingTypes',
         'totalChecklistCount','project','projectCheckLists','planningAssessment','planningScoresRatings','planningFinalScoreRating',
        'designAssessmentInfo','designFinalScoreRating','constructionAssessInfo','constructionFinalScoreRating','thresholds'));   
   
    }
    */
    public function checklist($id)
    {
        $project = $this->projectRepository->getById($id); 
        $projectCheckLists = $this->projectRepository->getChecklistsByProjectId($id); 
        $totalChecklistCount = $projectCheckLists->count(); // This is required..

        return view('projects.checklist', compact('project','projectCheckLists','totalChecklistCount'));   
   
    }
    public function planning($id)
    {
        $project = $this->projectRepository->getById($id); 
        // Planning assessment page... where indicators are static in blade
        $planningAssessment = $this->projectRepository->getPlanningAssessmentsByProject($id); 
        //$totalChecklistCount = $planningAssessment->count(); // This is required.. 
        return view('projects.planning', compact('project','planningAssessment'));   
   
    }
    public function planningReview($id)
    {
        $project = $this->projectRepository->getById($id); 
        
         // To show in review portion page.. where indicators and all values are getting from DB with loop...
         $planningScoresRatings = $this->projectRepository->getPlanningInfoByProjectId($id); 
         //dd($planningScoresRatings);
         // To show in review page.. for final scoring and ratings...
         $planningFinalScoreRating = $this->projectRepository->getPhaseFinalScoreRating($id,'Planning');
        return view('projects.planning-review', compact('project','planningScoresRatings','planningFinalScoreRating',));   
   
    }
    public function design($id)
    {
        $project = $this->projectRepository->getById($id); 
        // Get design indicators,compliances and assessments...
        $designAssessmentInfo = $this->projectRepository->getDesignInfoByProjectId($id); 
        return view('projects.design', compact('project','designAssessmentInfo'));   
   
    }
    public function designReview($id)
    {
        $project = $this->projectRepository->getById($id); 
        // To show in review page.. for final scoring and ratings...
        $designAssessmentInfo = $this->projectRepository->getDesignInfoByProjectId($id); 
        $designFinalScoreRating = $this->projectRepository->getPhaseFinalScoreRating($id,'Design');
        return view('projects.design-review', compact('project','designAssessmentInfo','designFinalScoreRating'));   
   
    }
    public function constructionReview($id)
    {
        $project = $this->projectRepository->getById($id); 
        $constructionAssessInfo = $this->projectRepository->getConstructionInfoByProjectId($id); 
        $constructionFinalScoreRating = $this->projectRepository->getPhaseFinalScoreRating($id,'Construction');
        return view('projects.construction-review', compact('project','constructionAssessInfo','constructionFinalScoreRating'));   
   
    }
    
    public function construction($id)
    {
        $project = $this->projectRepository->getById($id); 
        // Get construction indicators,compliances and assessments...
        $constructionAssessInfo = $this->projectRepository->getConstructionInfoByProjectId($id); 
        return view('projects.construction', compact('project','constructionAssessInfo'));   
   
    }
    public function esummary($id)
    {
        $project = $this->projectRepository->getById($id); 

        return view('projects.esummary', compact('project'));   
   
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(ProjectRequest $request, string $id)
    {
        try {
            $this->projectRepository->update($id, $request);
            session()->flash('success', 'Project updated successfully.');

            $project = $this->projectRepository->getById($id);  
            $projectPhases = $this->projectRepository->getProjectPhases();
            $organizations = $this->projectRepository->getOrganizations();
            $buildingTypes = $this->projectRepository->getBuildingTypes();
        
            $projectCheckLists = $this->projectRepository->getChecklistsByProjectId($id); 
            $totalChecklistCount = $projectCheckLists->count(); // This is required..

            // Planning assessment page... where indicators are static in blade
            $planningAssessment = $this->projectRepository->getPlanningAssessmentsByProject($id); 
            //$totalChecklistCount = $planningAssessment->count(); // This is required..
            
            // To show in review portion page.. where indicators and all values are getting from DB with loop...
            $planningScoresRatings = $this->projectRepository->getPlanningInfoByProjectId($id); 
            // To show in review page.. for final scoring and ratings...
            $planningFinalScoreRating = $this->projectRepository->getPhaseFinalScoreRating($id,'Planning');

            // Get design indicators,compliances and assessments...
            $designAssessmentInfo = $this->projectRepository->getDesignInfoByProjectId($id); 
            // To show in review page.. for final scoring and ratings...
            $designFinalScoreRating = $this->projectRepository->getPhaseFinalScoreRating($id,'Design');

            // Get construction indicators,compliances and assessments...
            $constructionAssessInfo = $this->projectRepository->getConstructionInfoByProjectId($id); 
            // To show in review page.. for final scoring and ratings...
            $constructionFinalScoreRating = $this->projectRepository->getPhaseFinalScoreRating($id,'Construction');

            $thresholds = $this->projectRepository->getthresholds();// Get Mandatory requirements

            return view('projects.edit', compact('projectPhases', 'organizations', 'buildingTypes',
            'totalChecklistCount','project','projectCheckLists','planningAssessment','planningScoresRatings','planningFinalScoreRating',
            'designAssessmentInfo','designFinalScoreRating','constructionAssessInfo','constructionFinalScoreRating','thresholds'));   

        } catch (\Exception $e) {
            Log::error('Project update error: ' . $e->getMessage());
            session()->flash('error', 'An error occurred while updating the project.');
        }     
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
