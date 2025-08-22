<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

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
    Route::resource('projects', ProjectController::class);
    
    Route::resource('checklists', ChecklistController::class);
    Route::get('getsubtypes', [ProjectController::class, 'getBuildingSubTypes'])->name('projects.getBuildingSubTypes');  
   
    Route::post('projects/savechecklist', [ProjectController::class, 'saveCheckList'])->name('projects.saveCheckList');  
    Route::post('projects/delete-checklist-file', [ProjectController::class, 'deleteChecklistFile'])->name('projects.deleteCheckListFile');
    Route::put('projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');

    Route::post('projects/saveplanning', [ProjectController::class, 'savePlanningAssessment'])->name('projects.savePlanningAssessment'); 
    Route::post('projects/delete-planning-file', [ProjectController::class, 'deletePlanningFile'])->name('projects.deletePlanningFile');
    
    Route::post('projects/savedesign', [ProjectController::class, 'saveDesignAssessment'])->name('projects.saveDesignAssessment'); 
    Route::post('projects/delete-design-file', [ProjectController::class, 'deleteDesignFile'])->name('projects.deleteDesignFile');

    Route::post('projects/saveconstruction', [ProjectController::class, 'saveConstructionAssessment'])->name('projects.saveConstructionAssessment'); 
    Route::post('projects/delete-construction-file', [ProjectController::class, 'deleteConstructionFile'])->name('projects.deleteConstructionFile');

    Route::post('projects/savecomments', [ProjectController::class, 'saveComments'])->name('projects.saveComments'); 
    Route::post('projects/updatecost', [ProjectController::class, 'updateCost'])->name('projects.updateCost'); 
    Route::post('projects/store', [ProjectController::class, 'store'])->name('projects.store'); 


   //Route::post('updatechecklist', [ProjectController::class, 'updateCheckList'])->name('projects.updateCheckList');  
});
/*
Route::get('/error-test', function () {
    abort(500, 'Test log error');
});
*/

require __DIR__.'/auth.php';

