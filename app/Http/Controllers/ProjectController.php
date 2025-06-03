<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProjectRequest;

use App\Repositories\ProjectRepository;
use App\Http\Requests\ProjectChecklistRequest;
use App\Http\Requests\PlanningAssessRequest;

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
        return view('projects.create', compact('projectPhases', 'organizations', 'buildingTypes'));   
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(ProjectRequest $request)
    {
        $project = $this->projectRepository->create($request);   
        return redirect()->to(route('projects.edit',$project->id))->with(['message' => 'Project has been added successfully.']);
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
                    'message' => $checklist ? 'Checklist updated!' : 'Checklist saved!',
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
                $planningReviewPortion = $this->projectRepository->getPlanningByProjectIndicator($request->updatedProjectId,$request->indicator_id,'Planning');
                
                return response()->json([
                    'status' => 'success',
                    'message' => $dataExists ? 'File updated!' : 'Info saved!',
                    'file_name' => $filename,
                    'file_url' => $file ? Storage::url($path) : null,
                    'indicator_id' => $request->indicator_id,
                    'can_delete' => $canDelete, 
                    'planning_review_info' => $planningReviewPortion, 
                ]);
            } 
            else {
                // New insert
                $request->request->add(['filename' => $filename, 'path' => $path]);
                $newData = $this->projectRepository->createPlanningAssessmentItem($request);
                //To show in Review Portion: Get Planning info against Project ID and Indicator ID
                $planningReviewPortion = $this->projectRepository->getPlanningByProjectIndicator($request->updatedProjectId,$request->indicator_id,'Planning');
                return response()->json([
                    'status' => 'success',
                    'message' => $newData ? 'File updated!' : 'Info saved!',
                    'file_name' => $filename,
                    'file_url' => $file ? Storage::url($path) : null,
                    'indicator_id' => $request->indicator_id,
                    'can_delete' => $canDelete,
                    'planning_review_info' => $planningReviewPortion, 
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
        return response()->json(['status' => 'success', 'message' => 'File deleted.']);
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
       
        $projectCheckLists = $this->projectRepository->getChecklistsByProjectId($id); 
        $totalChecklistCount = $projectCheckLists->count(); // This is required..

        $planningAssessment = $this->projectRepository->getPlanningAssessmentsByProject($id); 
        //$totalChecklistCount = $planningAssessment->count(); // This is required..

        $planningScoresRatings = $this->projectRepository->getPlanningInfoByProjectId($id); 
        $planningFinalScoreRating = $this->projectRepository->getPlanningFinalScoreRating($id,'Planning');

        return view('projects.edit', compact('projectPhases', 'organizations', 'buildingTypes',
         'totalChecklistCount','project','projectCheckLists','planningAssessment','planningScoresRatings','planningFinalScoreRating'));   
   
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
