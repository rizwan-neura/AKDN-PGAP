<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProjectWorkflowController;
use App\Http\Middleware\ProjectWorkflowAccess;

//Route::get('/', function () {
   // return view('welcome');
//});

//Route::get('/', function () {
    //return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/',[DashboardController::class,'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('countries', CountryController::class);

    Route::delete('/projects/{project}', [ProjectController::class, 'destroy'])
    ->name('projects.destroy');

   // Route::resource('projects', ProjectController::class);
   
   Route::resource('projects', ProjectController::class)
    ->middleware(ProjectWorkflowAccess::class);
   
    Route::resource('checklists', ChecklistController::class);
    Route::get('getsubtypes', [ProjectController::class, 'getBuildingSubTypes'])->name('projects.getBuildingSubTypes');  
    Route::get('getregions', [ProjectController::class, 'getRegions'])->name('projects.getRegions'); 
    
    Route::put('projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
    
    Route::post('projects/saveplanning', [ProjectController::class, 'savePlanningAssessment'])
    ->middleware(ProjectWorkflowAccess::class)->name('projects.savePlanningAssessment');
    Route::post('projects/delete-planning-file', [ProjectController::class, 'deletePlanningFile'])
    ->middleware(ProjectWorkflowAccess::class)->name('projects.deletePlanningFile');
    Route::post('projects/savedesign', [ProjectController::class, 'saveDesignAssessment'])
    ->middleware(ProjectWorkflowAccess::class)->name('projects.saveDesignAssessment');
    Route::post('projects/savecomments', [ProjectController::class, 'saveComments'])->name('projects.saveComments'); 
    Route::post('projects/store', [ProjectController::class, 'store'])->name('projects.store'); 
    Route::get('projects/{project}/esummary', [ProjectController::class, 'esummary'])->name('projects.esummary');
    Route::get('projects/{project}/checklist', [ProjectController::class, 'checklist'])->name('projects.checklist');
    /* start: new routes added */
    Route::post('projects/delete-design-file', [ProjectController::class, 'deleteDesignFile'])
    ->middleware(ProjectWorkflowAccess::class)->name('projects.deleteDesignFile');
    Route::post('projects/saveconstruction', [ProjectController::class, 'saveConstructionAssessment'])
        ->middleware(ProjectWorkflowAccess::class)->name('projects.saveConstructionAssessment');
    Route::post('projects/delete-construction-file', [ProjectController::class, 'deleteConstructionFile'])
        ->middleware(ProjectWorkflowAccess::class)->name('projects.deleteConstructionFile');
    Route::post('projects/savechecklist', [ProjectController::class, 'saveCheckList'])
        ->middleware(ProjectWorkflowAccess::class)->name('projects.saveCheckList');
    Route::post('projects/delete-checklist-file', [ProjectController::class, 'deleteChecklistFile'])
        ->middleware(ProjectWorkflowAccess::class)->name('projects.deleteCheckListFile');
    Route::put('projects/{id}/save-summary', [ProjectController::class, 'saveSummary'])
        ->middleware(ProjectWorkflowAccess::class)->name('projects.savesummary');
    Route::post('projects/updatecost', [ProjectController::class, 'updateCost'])
        ->middleware(ProjectWorkflowAccess::class)->name('projects.updateCost');
    Route::get('projects/{project}/planning', [ProjectController::class, 'planning'])
        ->middleware(ProjectWorkflowAccess::class)->name('projects.planning');
    Route::get('projects/{project}/planning-review', [ProjectController::class, 'planningReview'])
        ->middleware(ProjectWorkflowAccess::class)->name('projects.planningreview');
    Route::get('projects/{project}/design', [ProjectController::class, 'design'])
        ->middleware(ProjectWorkflowAccess::class)->name('projects.design');
    Route::get('projects/{project}/design-review', [ProjectController::class, 'designReview'])
        ->middleware(ProjectWorkflowAccess::class)->name('projects.designreview');
    Route::get('projects/{project}/construction', [ProjectController::class, 'construction'])
        ->middleware(ProjectWorkflowAccess::class)->name('projects.construction');
    Route::get('projects/{project}/construction-review', [ProjectController::class, 'constructionReview'])
        ->middleware(ProjectWorkflowAccess::class)->name('projects.consreview');
    Route::post('projects/{project}/workflow/{phase}/{action}', [ProjectWorkflowController::class, 'transition'])
        ->whereIn('phase', ['planning', 'design', 'construction'])
        ->whereIn('action', ['submit', 'send-back', 'submit-to-csa', 'reviewed'])
        ->name('projects.workflow.transition');
    
    /* end:  new routes added */
    Route::middleware('admin')->group(function () {
        Route::get('users/access', [UserController::class, 'access'])->name('users.access');
        Route::resource('users', UserController::class)
            ->only(['index', 'store', 'update', 'destroy']);
    });

});
/*
Route::get('/error-test', function () {
    abort(500, 'Test log error');
});
*/

require __DIR__.'/auth.php';

