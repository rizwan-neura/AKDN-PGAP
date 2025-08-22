

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>AKDN | Project's Green Building</title>
    <!-- Favicon-->
    <link rel="icon" href="https://gurayyarar.github.io/AdminBSBMaterialDesign/favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="https://gurayyarar.github.io/AdminBSBMaterialDesign/plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="https://gurayyarar.github.io/AdminBSBMaterialDesign/plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="https://gurayyarar.github.io/AdminBSBMaterialDesign/plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Bootstrap Material Datetime Picker Css -->
    <link href="https://gurayyarar.github.io/AdminBSBMaterialDesign/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet" />

    <!-- Bootstrap DatePicker Css -->
    <link href="https://gurayyarar.github.io/AdminBSBMaterialDesign/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css" rel="stylesheet" />

    <!-- Wait Me Css -->
    <link href="https://gurayyarar.github.io/AdminBSBMaterialDesign/plugins/waitme/waitMe.css" rel="stylesheet" />

    <!-- Bootstrap Select Css -->
    <link href="https://gurayyarar.github.io/AdminBSBMaterialDesign/plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="https://gurayyarar.github.io/AdminBSBMaterialDesign/css/style.css" rel="stylesheet">

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="https://gurayyarar.github.io/AdminBSBMaterialDesign/css/themes/all-themes.css" rel="stylesheet" />
</head>



@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 style="color:green;">Project's Green Building Assurance Performance</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Advanced Form</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
   <div class="content" style="margin-left:30px;">
<a href="{{ route('dashboard') }}">GO BACK</a>
   </div>
    <!-- #Top Bar -->
    <section class="content" style="margin-left:45px;margin-top:15px;">
         <!-- Basic Example | Horizontal Layout -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <h2>PGAP - TOOL</h2>
                            <ul class="header-dropdown m-r--5">
                                <li class="dropdown">
                                    <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li><a href="javascript:void(0);">Action</a></li>
                                        <li><a href="javascript:void(0);">Another action</a></li>
                                        <li><a href="javascript:void(0);">Something else here</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <div class="body">
                            <div id="wizard_horizontal">
                                <h2>Create Project</h2>
                                <section>
                                       
                                        @include('_includes.message')
                                        
                                         @include('_includes.errors')
                                        <form name="create_project" id="create_project" method="POST" action="{{ route('projects.update', $project->id) }}"> 
                                        @csrf
                                        @method('PUT')
                                        <!-- Create project content -->    
                                            <div class="container-fluid">
                                            <!-- SELECT2 EXAMPLE -->
                                            <div class="ard card-success">
                                           
                                            <!-- /.card-header -->
                                            <div class="card-body">
                                                <div class="row">
                                                        <div class="col-sm-3">
                                                            <!-- text input -->
                                                            <div class="form-group">
                                                                <label>Project Name</label>
                                                                <input type="text" name="project_name" value="{{ old('project_name', $project->project_name) }}" class="form-control" placeholder="Enter ...">
                                                                    @error('project_name')<i class="col-red">{{ $message }}</i>@enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <!-- text input -->
                                                            <div class="form-group">
                                                                <label>Current Phase</label>
                                                                <i class="material-icons col-red"><b>*</b></i>
                                                                    <select  name="phase_id" id="phase_id" class="form-control select2">
                                                                        <option value="">Select Phase</option>
                                                                        @foreach($projectPhases as $id => $phase_name)
                                                                            <option value="{{ $id }}"
                                                                                {{ old('phase_id', $project->phase_id) == $id ? 'selected' : '' }}>
                                                                                {{ $phase_name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>    
                                                                 
                                                                @error('phase_id')<i class="col-red">{{ $message }}</i>@enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <!-- text input -->
                                                            <div class="form-group">
                                                                <label>Assessment requirement</label>
                                                                <input type="text" name="assessment_req" id="assessment_req" class="form-control" value="{{ old('assessment_req', $project->assessment_req) }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <!-- text input -->
                                                            <div class="form-group">
                                                                <label>Organization</label>
                                                                <i class="material-icons col-red"><b>*</b></i>
                                                                    <select  name="organization_id" id="organization_id" class="form-control select2">
                                                                        <option value="">Select Organizaton</option>
                                                                        @foreach($organizations as $id => $organization_name)
                                                                            <option value="{{ $id }}"
                                                                                {{ old('organization_id', $project->organization_id) == $id ? 'selected' : '' }}>
                                                                                {{ $organization_name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>   

                                                                @error('organization_id')<i class="col-red">{{ $message }}</i>@enderror
                                                            </div>
                                                        </div>
                                                    
                                                </div>
                                                <div class="row">
                                                        <div class="col-sm-3">
                                                            <!-- text input -->
                                                            <div class="form-group">
                                                                <label>Date of GBA* Performance</label>
                                                                 <i class="material-icons col-red"><b>*</b></i>
                                                                 <div class="form-line" id="bs_datepicker_container">
                                                                        <input type="text" name="date_gpa" id="date_gpa" class="form-control" value="{{ old('date_gpa', $project->date_gpa) }}">
                                                                        @error('date_gpa')<i class="col-red">{{ $message }}</i>@enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <!-- text input -->
                                                            <div class="form-group">
                                                                <label>Project Start Date</label>
                                                                <i class="material-icons col-red"><b>*</b></i>
                                                                <div class="form-line" id="bs_datepicker_container">
                                                                        <input type="text" name="start_date" id="start_date" class="form-control" value="{{ old('start_date', $project->start_date) }}">
                                                                        @error('start_date')<i class="col-red">{{ $message }}</i>@enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <!-- text input -->
                                                            <div class="form-group">
                                                                <label>Project End Date</label>
                                                                <i class="material-icons col-red"><b>*</b></i>
                                                                <div class="form-line" id="bs_datepicker_container">
                                                                        <input type="text" name="end_date" id="end_date" class="form-control" value="{{ old('end_date', $project->end_date) }}">
                                                                        @error('end_date')<i class="col-red">{{ $message }}</i>@enderror
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <!-- text input -->
                                                            <div class="form-group">
                                                                <label>Country</label>
                                                                    <select class="form-control select2" name="country_code" style="width: 100%;">
                                                                        <option selected="selected">Alabama</option>
                                                                        <option>Alaska</option>
                                                                        <option>California</option>
                                                                        <option>Delaware</option>
                                                                        <option>Tennessee</option>
                                                                        <option>Texas</option>
                                                                        <option>Washington</option>
                                                                    </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-1">
                                                            <!-- text input -->
                                                            <div class="form-group">
                                                                <label>Region</label>
                                                                    <select class="form-control select2" name="region_code" style="width: 100%;">
                                                                        <option selected="selected">Alabama</option>
                                                                        <option>Alaska</option>
                                                                        <option>California</option>
                                                                        <option>Delaware</option>
                                                                        <option>Tennessee</option>
                                                                        <option>Texas</option>
                                                                        <option>Washington</option>
                                                                    </select>
                                                            </div>
                                                        </div>
                                                    
                                                </div>
                                                <div class="row">
                                                        <div class="col-sm-3">
                                                            <!-- text input -->
                                                            <div class="form-group">
                                                                <label>Location  (Site / HO)</label>
                                                                <input type="text" name="location" id="location" class="form-control" value="{{ old('location', $project->location) }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <!-- text input -->
                                                            <div class="form-group">
                                                                <label>GPS Coordinates</label>
                                                                <input type="text" name="coordinates" id="coordinates" class="form-control" value="{{ old('coordinates', $project->coordinates) }}">
                                                            </div>
                                                        </div>
                                                       <!-- Building Type Dropdown -->
                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                <label>Building Type</label>
                                                                <i class="material-icons col-red"><b>*</b></i>
                                                              
                                                                <select  name="type_id" id="type_id" class="form-control select2">
                                                                        <option value="">Select Type</option>
                                                                        @foreach($buildingTypes as $id => $type_name)
                                                                            <option value="{{ $id }}"
                                                                                {{ old('type_id', $project->type_id) == $id ? 'selected' : '' }}>
                                                                                {{ $type_name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                               @error('type_id')<i class="col-red">{{ $message }}</i>@enderror
                                                            </div>
                                                        </div>

                                                        
                                                        <!-- Sub-Type Dropdown -->
                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                <label>Sub-Type</label>
                                                                <select name="sub_type_id" id="sub_type_id" class="form-control">
                                                                    <option value="">Select Sub-type</option>
                                                                </select>
                                                            </div>
                                                        </div> 
                                                    
                                                </div>
                                                <div class="row">
                                                        <div class="col-md-4">
                                                            <!-- text input -->
                                                            <div class="form-group">
                                                                <label>Construction Cost (USD)&nbsp;at&nbsp;Planning Phase: </label>
                                                                  
                                                                 <i class="material-icons col-red"><b>*</b></i>
                                                                 <input type="text" name="construction_cost" id="construction_cost" class="form-control" value="{{ old('construction_cost', $project->construction_cost) }}">
                                                                 @error('construction_cost')<i class="col-red">{{ $message }}</i>@enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <!-- text input -->
                                                            <div class="form-group">
                                                                <label>Mandatory Requirement</label>
                                                               <input type="text" readonly name="requirements" id="requirements" class="form-control" value="{{ old('requirements', $project->requirements) }}">
                                                            
                                                            </div>
                                                        </div>
                                                        
                                                    
                                                </div>
                                             
                                            </div>
                                            
                                            </div>
                                            <!-- /.card -->
                                           <input type="hidden" name="step" value="0">
                                           <input type="hidden" name="min_cost" id="min_cost" value="{{ $thresholds->min_value }}">
                                           <input type="hidden" name="max_cost"  id="max_cost" value="{{ $thresholds->max_value }}">
                                           <input type="hidden" name="output_1" id="output_1" value="{{ $thresholds->output_1 }}">
                                           <input type="hidden" name="output_2" id="output_2" value="{{ $thresholds->output_2 }}">
                                           <input type="hidden" name="output_3" id="output_3" value="{{ $thresholds->output_3 }}">
                                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">UPDATE PROJECT</button>
                                            </div>
                                        <!-- /.container-fluid -->
                               
                                        </form>
                                        <!-- /.Create project content -->
                                </section>
                                 <h2>Executive Summary</h2>
                                <section>
                                        
                                        <!-- Basic Table -->
                                        <div class="row clearfix">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="card">
                                                    <div class="header">
                                                        <h2>
                                                            AKU Kampala
                                                            <small>Project details modification classes</small>
                                                        </h2>
                                                        
                                                    </div>
                                                    <div class="body table-responsive">
                                                        <table class="table table-bordered">
                                                            
                                                            <tbody>
                                                               
                                                            <tr>
                                                                    <th scope="row" colspan="6" class="header bg-light-green">Executive Summary</th>
                                                                   
                                                                </tr>

                                                                <tr>
                                                                    <td colspan="6">
                                                                           <textarea id="w3review" name="w3review" rows="4" cols="150">Kampala project Executive Summary
                                                                            </textarea>
                                                                    </td>
                                                                   
                                                                </tr>
                                                                 <tr>
                                                                    <td colspan="6">
                                                                          <div class="body">
                                                                            <div class="button-demo">
                                                                                
                                                                                <button type="button" class="btn btn-primary waves-effect">SAVE SUMMARY</button>
                                                                                
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                   
                                                                </tr>
                                                                
                                                                
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- #END# Basic Table -->
                                </section>
                                <h2>Environmental Requirements Checklist</h2>
                                <section>
                                        <!-- Basic Table -->
                                        <div class="row clearfix">
                                                        <table class="table table-bordered">
                                                            <thead class="header bg-light-green">
                                                                <tr>
                                                                <th width="5%">Checklist #</th>
                                                                    <th width="55%">Requirements</th>
                                                                     <th width="15%">Status</th>
                                                                    <th width="20%">Upload Documents</th>
                                                                    <th width="5%"></th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                            @foreach ($projectCheckLists as $row)
                                                            <form id="checklist_form_{{ $row->id }}" method="POST" enctype="multipart/form-data" >
                                                                @csrf
                                                                <div class="status-message text-success mt-2" style="margin-left: 1050px;"></div>
                                                                <table class="table table-bordered">
                                                                    <tr class="item-form border p-3 mb-3" data-indexChecklistId="{{ $row->id }}">
                                                                        <td width="5%">{{ $row->id }}</td>
                                                                        <td width="55%">
                                                                            {{ $row->checklist_name }}
                                                                            @if($row->is_mandatory === 1)
                                                                                <i class="material-icons col-red"><b>(*)</b></i>
                                                                            @endif
                                                                        </td>
                                                                        <td width="15%">
                                                                            <select class="form-control option-select" name="checklistStatus">
                                                                                <option value="">Choose</option>
                                                                                <option value="YES" @selected(old('checklistStatus', $row->status) == 'YES')>YES</option>
                                                                                <option value="NO" @selected(old('checklistStatus', $row->status) == 'NO')>NO</option>
                                                                               
                                                                            </select>
                                                                        </td>
                                                                        <td width="20%">
                                                                            <input type="file" class="form-control file-input" name="checklist_uploads"><br>
                                                                           
                                                                           @if(!empty($row->file_path))
                                                                                <div class="uploaded-file mt-2 d-block">📎 <a href="{{ asset('storage/' . $row->file_path) }}" target="_blank">View Uploaded File</a>
                                                                                <button type="button" class="btn btn-danger waves-effect"
                                                                                    onclick="deleteChecklistFile('checklist_form_{{ $row->id }}', '{{ route('projects.deleteCheckListFile') }}', {{ $row->id }} ); return false;">
                                                                                    Delete file
                                                                                </button>
                                                                             @endif
                                                                        
                                                                        </td>
                                                                        <td width="5%">
                                                                            <button class="btn btn-primary waves-effect" type="button"
                                                                                    onclick="saveIndicatorValues('checklist_form_{{ $row->id }}', '{{ route('projects.saveCheckList') }}', {{ $row->id }}, '{{ route('projects.deleteCheckListFile') }}'); return false;">
                                                                                SAVE
                                                                            </button>
                                                                            
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                                
                                                                <input type="hidden" value="{{ $row->id }}" name="checklist_id">
                                                                <input type="hidden" value="{{ $project->id }}" name="updatedProjectId">

                                                            </form>
                                                            @endforeach
                                                            <input type="hidden" value="{{ $totalChecklistCount }}" name="totalChecklistCount" id="totalChecklistCount">
                                        </div>
                                        <!-- #END# Basic Table -->
                                </section>

                               
                                 <h2>Planning</h2>
                                  {{--
                                   @isset($planningFinalScoreRating)
                                     {{ dump($planningFinalScoreRating) }}
                                    @endisset
                                    --}}
                                <section>
                                        @php
                                        $assessment1 = collect($planningAssessment)->firstWhere('indicator_id', 1);
                                        $assessment2 = collect($planningAssessment)->firstWhere('indicator_id', 2);
                                        $assessment3 = collect($planningAssessment)->firstWhere('indicator_id', 3);
                                        $assessment4 = collect($planningAssessment)->firstWhere('indicator_id', 4);
                                        $assessment5 = collect($planningAssessment)->firstWhere('indicator_id', 5);
                                        $assessment6 = collect($planningAssessment)->firstWhere('indicator_id', 6);
                                        @endphp
                                        <!-- Basic Table -->
                                        <div class="row clearfix">
                                                        <table class="table table-bordered">
                                                            <thead class="header bg-light-green">
                                                                <tr>
                                                                    <th width="5%">GBG's Ref</th>
                                                                    <th width="55%">Assessment Description</th>
                                                                    <th width="15%" rowspan="0">Degree of compliance</th>
                                                                    <th width="20%">Upload Documents</th>
                                                                    <th width="5%"></th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                        <form id="planning_form_1" method="POST" enctype="multipart/form-data" >
                                                                @csrf
                                                                <div class="status-message text-success mt-2" style="margin-left: 1050px;"></div>
                                                                    <table class="table table-bordered">
                                                                    <tr>
                                                                        <td width="5%">1.1</td>
                                                                            <td width="55%">
                                                                            
                                                                            Is a feasibility study conducted by the project team to assess, "Should we build" approach concluded? And has this been submitted, along with the justification to the CSA for review and sign off?
                                                                            <i class="material-icons col-red"><b>(*)</b></i>
                                                                            </td>
                                                                        
                                                                            <td width="15%">
                                                                        
                                                                            <select name="compliance" class="form-control option-select">
                                                                                <option value="">Choose</option>
                                                                                <option value="2" {{ $assessment1 && $assessment1->compliances_id == 2 ? 'selected' : '' }}>YES</option>
                                                                                <option value="1" {{ $assessment1 && $assessment1->compliances_id == 1 ? 'selected' : '' }}>NO</option>
                                                                                <option value="3" {{ $assessment1 && $assessment1->compliances_id == 3 ? 'selected' : '' }}>N/A</option>
                                                                            </select>

                                                                            
                                                                            </td>
                                                                            
                                                                            <td width="20%">
                                                                            <input type="file" class="form-control file-input" name="planning_uploads">
                                                                            @if(!empty($assessment1->file_path))
                                                                                <div class="uploaded-file mt-2 d-block">📎 <a href="{{ asset('storage/' . $assessment1->file_path) }}" target="_blank">View Uploaded File</a><br>
                                                                                <button type="button" class="btn btn-danger waves-effect"
                                                                                    onclick="deletePlanningFile('planning_form_1', '{{ route('projects.deletePlanningFile') }}', 1 ); return false;">
                                                                                    Delete file
                                                                                </button>
                                                                            @endif
                                                                            
                                                                                
                                                                            </td>
                                                                            <td>
                                                                            <button class="btn btn-primary waves-effect" type="button"
                                                                                onclick="savePlanningValues('planning_form_1', '{{ route('projects.savePlanningAssessment') }}', 1 , '{{ route('projects.deletePlanningFile') }}'); return false;">
                                                                            SAVE
                                                                        </button>
                                                                        </td>
                                                                            
                                                                        </tr>
                                                                    </table>
                                                                        <input type="hidden" value="1" name="indicator_id">
                                                                        <input type="hidden" value="{{ $project->id }}" name="updatedProjectId">
                                                                </form>
                                                                <form id="planning_form_2" method="POST" enctype="multipart/form-data" >
                                                                @csrf
                                                                <div class="status-message text-success mt-2" style="margin-left: 1050px;"></div>
                                                                    <table class="table table-bordered">
                                                                    <tr>
                                                                        <td width="5%">1.2</td>
                                                                            <td width="55%">
                                                                            As part of feasibility study, is a workshop on environment and climate change and the relevance to the project held?
                                                                            </td>
                                                                        
                                                                            <td width="15%">
                                                                            <select name="compliance" class="form-control option-select">
                                                                                <option value="">Choose</option>
                                                                                <option value="2" {{ $assessment2 && $assessment2->compliances_id == 2 ? 'selected' : '' }}>YES</option>
                                                                                <option value="1" {{ $assessment2 && $assessment2->compliances_id == 1 ? 'selected' : '' }}>NO</option>
                                                                                <option value="3" {{ $assessment2 && $assessment2->compliances_id == 3 ? 'selected' : '' }}>N/A</option>
                                                                            </select>
                                                                            
                                                                            </td>
                                                                            
                                                                            <td width="20%">
                                                                            <input type="file" class="form-control file-input" name="planning_uploads">
                                                                                @if(!empty($assessment2->file_path))
                                                                                <div class="uploaded-file mt-2 d-block">📎 <a href="{{ asset('storage/' . $assessment2->file_path) }}" target="_blank">View Uploaded File</a><br>
                                                                                <button type="button" class="btn btn-danger waves-effect"
                                                                                    onclick="deletePlanningFile('planning_form_2', '{{ route('projects.deletePlanningFile') }}', 2 ); return false;">
                                                                                    Delete file
                                                                                </button>
                                                                            @endif
                                                                                
                                                                            
                                                                            
                                                                            </td>
                                                                            <td>
                                                                            <button class="btn btn-primary waves-effect" type="button"
                                                                                onclick="savePlanningValues('planning_form_2', '{{ route('projects.savePlanningAssessment') }}', 2, '{{ route('projects.deletePlanningFile') }}'); return false;">
                                                                            SAVE
                                                                        </button>
                                                                        
                                                                            </td>
                                                                            
                                                                        </tr>
                                                                </table>
                                                                        <input type="hidden" value="2" name="indicator_id">
                                                                        <input type="hidden" value="{{ $project->id }}" name="updatedProjectId">
                                                        </form>
                                                        <form id="planning_form_3" method="POST" enctype="multipart/form-data" >
                                                                @csrf
                                                                <div class="status-message text-success mt-2" style="margin-left: 1050px;"></div>
                                                                    <table class="table table-bordered">
                                                                    <tr>
                                                                        <td width="5%">2.1</td>
                                                                            <td width="55%">
                                                                            Is the project aligned with the AKAH Habitat Planning Framework?
                                                                            </td>
                                                                        
                                                                            <td width="15%">
                                                                            <select name="compliance" class="form-control option-select">
                                                                                <option value="">Choose</option>
                                                                                <option value="2" {{ $assessment3 && $assessment3->compliances_id == 2 ? 'selected' : '' }}>YES</option>
                                                                                <option value="1" {{ $assessment3 && $assessment3->compliances_id == 1 ? 'selected' : '' }}>NO</option>
                                                                                <option value="3" {{ $assessment3 && $assessment3->compliances_id == 3 ? 'selected' : '' }}>N/A</option>
                                                                            </select>
                                                                            
                                                                            </td>
                                                                            
                                                                            <td width="20%">
                                                                            <input type="file" class="form-control file-input" name="planning_uploads">
                                                                                @if(!empty($assessment3->file_path))
                                                                                <div class="uploaded-file mt-2 d-block">📎 <a href="{{ asset('storage/' . $assessment3->file_path) }}" target="_blank">View Uploaded File</a><br>
                                                                                <button type="button" class="btn btn-danger waves-effect"
                                                                                    onclick="deletePlanningFile('planning_form_3', '{{ route('projects.deletePlanningFile') }}', 3 ); return false;">
                                                                                    Delete file
                                                                                </button>
                                                                            @endif
                                                                                
                                                                            
                                                                            
                                                                            </td>
                                                                            <td>
                                                                            <button class="btn btn-primary waves-effect" type="button"
                                                                                onclick="savePlanningValues('planning_form_3', '{{ route('projects.savePlanningAssessment') }}', 3 , '{{ route('projects.deletePlanningFile') }}'); return false;">
                                                                            SAVE
                                                                        </button>
                                                                        
                                                                            </td>
                                                                            
                                                                        </tr>
                                                                </table>
                                                                        <input type="hidden" value="3" name="indicator_id">
                                                                        <input type="hidden" value="{{ $project->id }}" name="updatedProjectId">
                                                        </form>
                                                        <form id="planning_form_4" method="POST" enctype="multipart/form-data" >
                                                                @csrf
                                                                <div class="status-message text-success mt-2" style="margin-left: 1050px;"></div>
                                                                    <table class="table table-bordered">
                                                                    <tr>
                                                                        <td width="5%">2.2</td>
                                                                            <td width="55%">
                                                                            Is the site selected meeting the full scope of technical due diligences?
                                                                            <i class="material-icons col-red"><b>(*)</b></i>
                                                                            </td>
                                                                        
                                                                            <td width="15%">
                                                                            <select name="compliance" class="form-control option-select">
                                                                                <option value="">Choose</option>
                                                                                <option value="1" {{ $assessment4 && $assessment4->compliances_id == 1 ? 'selected' : '' }}>NO</option>
                                                                                <option value="4" {{ $assessment4 && $assessment4->compliances_id == 4 ? 'selected' : '' }}>HVRA conducted (Risk - relatively safe)</option>
                                                                                    <option value="5" {{ $assessment4 && $assessment4->compliances_id == 5 ? 'selected' : '' }}>HVRA conducted (Risk - Low)</option>
                                                                                    <option value="6" {{ $assessment4 && $assessment4->compliances_id == 6 ? 'selected' : '' }}>HVRA conducted (Risk - Medium)</option>
                                                                                    <option value="7" {{ $assessment4 && $assessment4->compliances_id == 7 ? 'selected' : '' }}>HVRA conducted (Risk - High)</option>
                                                                            </select>
                                                                            
                                                                            </td>
                                                                            
                                                                            <td width="20%">
                                                                            <input type="file" class="form-control file-input" name="planning_uploads">
                                                                                @if(!empty($assessment4->file_path))
                                                                                <div class="uploaded-file mt-2 d-block">📎 <a href="{{ asset('storage/' . $assessment4->file_path) }}" target="_blank">View Uploaded File</a><br>
                                                                                <button type="button" class="btn btn-danger waves-effect"
                                                                                    onclick="deletePlanningFile('planning_form_4', '{{ route('projects.deletePlanningFile') }}', 4 ); return false;">
                                                                                    Delete file
                                                                                </button>
                                                                            @endif
                                                                                
                                                                            
                                                                            
                                                                            </td>
                                                                            <td>
                                                                            <button class="btn btn-primary waves-effect" type="button"
                                                                                onclick="savePlanningValues('planning_form_4', '{{ route('projects.savePlanningAssessment') }}', 4 , '{{ route('projects.deletePlanningFile') }}'); return false;">
                                                                            SAVE
                                                                        </button>
                                                                        
                                                                            </td>
                                                                            
                                                                        </tr>
                                                                </table>
                                                                        <input type="hidden" value="4" name="indicator_id">
                                                                        <input type="hidden" value="{{ $project->id }}" name="updatedProjectId">
                                                        </form>
                                                        <form id="planning_form_5" method="POST" enctype="multipart/form-data" >
                                                                @csrf
                                                                <div class="status-message text-success mt-2" style="margin-left: 1050px;"></div>
                                                                    <table class="table table-bordered">
                                                                    <tr>
                                                                        <td width="5%">2.3</td>
                                                                            <td width="55%">
                                                                            Is the site selected considered for use of local resources, including energy, water and materials?
                                                                            </td>
                                                                        
                                                                            <td width="15%">
                                                                            <select name="compliance" class="form-control option-select">
                                                                                <option value="">Choose</option>
                                                                                <option value="1" {{ $assessment5 && $assessment5->compliances_id == 1 ? 'selected' : '' }}>NO</option>
                                                                                <option value="8" {{ $assessment5 && $assessment5->compliances_id == 8 ? 'selected' : '' }}>Up to 20% of the required material is locally available</option>
                                                                                    <option value="9" {{ $assessment5 && $assessment5->compliances_id == 9 ? 'selected' : '' }}>20% to 30% of the required material is locally available</option>
                                                                                    <option value="10" {{ $assessment5 && $assessment5->compliances_id == 10 ? 'selected' : '' }}>30% to 50% of the required material is locally available</option>
                                                                                    <option value="11" {{ $assessment5 && $assessment5->compliances_id == 11 ? 'selected' : '' }}>More than 50% of the required material is locally available</option>
                                                                            </select>
                                                                            </td>
                                                                            
                                                                            <td width="20%">
                                                                            <input type="file" class="form-control file-input" name="planning_uploads">
                                                                                @if(!empty($assessment5->file_path))
                                                                                <div class="uploaded-file mt-2 d-block">📎 <a href="{{ asset('storage/' . $assessment5->file_path) }}" target="_blank">View Uploaded File</a><br>
                                                                                <button type="button" class="btn btn-danger waves-effect"
                                                                                    onclick="deletePlanningFile('planning_form_5', '{{ route('projects.deletePlanningFile') }}', 5 ); return false;">
                                                                                    Delete file
                                                                                </button>
                                                                            @endif
                                                                                
                                                                            </td>
                                                                            <td>
                                                                            <button class="btn btn-primary waves-effect" type="button"
                                                                                onclick="savePlanningValues('planning_form_5', '{{ route('projects.savePlanningAssessment') }}', 5 , '{{ route('projects.deletePlanningFile') }}'); return false;">
                                                                            SAVE
                                                                        </button>
                                                                        
                                                                            </td>
                                                                            
                                                                        </tr>
                                                                </table>
                                                                        <input type="hidden" value="5" name="indicator_id">
                                                                        <input type="hidden" value="{{ $project->id }}" name="updatedProjectId">
                                                        </form>
                                                        <form id="planning_form_6" method="POST" enctype="multipart/form-data" >
                                                                @csrf
                                                                <div class="status-message text-success mt-2" style="margin-left: 1050px;"></div>
                                                                    <table class="table table-bordered">
                                                                    <tr>
                                                                    <td width="5%">3</td>
                                                                            <td width="55%">
                                                                            Does design brief include the AKDN Green Building Section?
                                                                            <i class="material-icons col-red"><b>(*)</b></i>
                                                                            </td>
                                                                        
                                                                            <td width="15%">
                                                                                <select name="compliance" class="form-control option-select">
                                                                                <option value="">Choose</option>
                                                                                <option value="2" {{ $assessment6 && $assessment6->compliances_id == 2 ? 'selected' : '' }}>YES</option>
                                                                                <option value="1" {{ $assessment6 && $assessment6->compliances_id == 1 ? 'selected' : '' }}>NO</option>
                                                                                <option value="3" {{ $assessment6 && $assessment6->compliances_id == 3 ? 'selected' : '' }}>N/A</option>
                                                                            </select>
                                                                            </td>
                                                                            
                                                                            <td width="20%">
                                                                            <input type="file" class="form-control file-input" name="planning_uploads">
                                                                                @if(!empty($assessment6->file_path))
                                                                                <div class="uploaded-file mt-2 d-block">📎 <a href="{{ asset('storage/' . $assessment6->file_path) }}" target="_blank">View Uploaded File</a><br>
                                                                                <button type="button" class="btn btn-danger waves-effect"
                                                                                    onclick="deletePlanningFile('planning_form_6', '{{ route('projects.deletePlanningFile') }}', 6 ); return false;">
                                                                                    Delete file
                                                                                </button>
                                                                            @endif
                                                                                
                                                                            </td>
                                                                            <td>
                                                                            <button class="btn btn-primary waves-effect" type="button"
                                                                                onclick="savePlanningValues('planning_form_6', '{{ route('projects.savePlanningAssessment') }}', 6 , '{{ route('projects.deletePlanningFile') }}'); return false;">
                                                                            SAVE
                                                                        </button>
                                                                        
                                                                            </td>
                                                                            
                                                                        </tr>
                                                                </table>
                                                                        <input type="hidden" value="6" name="indicator_id">
                                                                        <input type="hidden" value="{{ $project->id }}" name="updatedProjectId">
                                                                            <input type="hidden" value="6" name="totalPlanningIndicators" id="totalPlanningIndicators">
                                                        </form>
                                         </div>
                                        <!-- #END# Basic Table -->
                                </section>

                                 <h2>Planning - Review</h2>
                                 <section>
                                        
                                        <!-- Basic Table -->
                                        <div class="row clearfix">
                                            
                                            <div class="body table-responsive">
                                
                                                                <!-- Header Row 1 -->
                                                <div class="row bg-light-green text-white fw-bold border border-dark text-center py-2">
                                                    <div class="col-md-1 border-end border-dark">GBG's Ref</div>
                                                    <div class="col-md-5 border-end border-dark">Assessment Description</div>
                                                    <div class="col-md-1 border-end border-dark">Degree of Compliance</div>
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-1">Assessment</div>
                                                    <div class="col-md-1"></div>
                                                </div>

                                                <!-- Header Row 2 (Sub-columns under Assessment) -->
                                                <div class="row bg-blue-grey text-center fw-bold border-start border-end border-bottom border-dark py-2">
                                                    <div class="col-md-1 border-end border-dark">&nbsp;</div>
                                                    <div class="col-md-5 border-end border-dark">&nbsp;</div>
                                                    <div class="col-md-1 border-end border-dark">&nbsp;</div>
                                                    <div class="col-md-1 border-end border-dark">Score</div>
                                                    <div class="col-md-1 border-end border-dark">Weightage</div>
                                                    <div class="col-md-1">Rating</div>
                                                    <div class="col-md-1"></div>
                                                    <div class="col-md-1"></div>
                                                </div>
                                
                                                <!-- Summary Score Row -->

                                                <div class="row bg-grey text-center fw-bold border-start border-end border-bottom border-dark py-2">
                                                    <div class="col-md-1 border-end border-dark">&nbsp;</div>
                                                    <div class="col-md-5 border-end border-dark">&nbsp;</div>
                                                    <div class="col-md-1 border-end border-dark">&nbsp;</div>
                                                    <div class="col-md-1 border-end border-dark  td-finalscore" data-indicator-id="planningFinalScore">
                                                        @if ($planningFinalScoreRating)
                                                        {{ number_format($planningFinalScoreRating->score, 1) }}
                                                        @endif
                                                    
                                                    </div>
                                                    <div class="col-md-1 border-end border-dark">45%</div>
                                                    <div class="col-md-1 td-finalrating" data-indicator-id="planningRating">
                                                        @if ($planningFinalScoreRating)
                                                            {{ $planningFinalScoreRating->rating }}
                                                        @endif
                                                    
                                                    </div>
                                                    <div class="col-md-1">Comments</div>
                                                    <div class="col-md-1">Actions</div>
                                                </div>       

                                                <!-- Dynamic Score Rows -->
                                                @foreach ($planningScoresRatings as $row)
                                                    <form id="comment_form_{{ $row->id }}" method="POST"  class="mb-0">    
                                                        @csrf   
                                                        <div class="status-message text-success mt-2" style="margin-left: 1150px;"></div> 
                                                        <div class="row border-start border-end border-bottom border-dark py-2 item-form" data-indexPlanningIndcaotrId="{{ $row->id }}">
                                                                <div class="col-md-1 border-end border-dark">
                                                                    {{ $row->ref_no }}
                                                                </div>
                                                                <div class="col-md-5 border-end border-dark text-start">
                                                                    {{ $row->indicator_name }}
                                                                    @if($row->is_mandatory === 1)
                                                                        <i class="material-icons col-red"><b>(*)</b></i>
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-1 text-center border-end border-dark td-comp-name" data-indicator-id="{{ $row->id }}">
                                                                    {{ $row->comp_name }}
                                                                </div>
                                                                <div class="col-md-1 text-center border-end border-dark td-comp-score" data-indicator-id="{{ $row->id }}">
                                                                    {{ $row->complianceScore }}
                                                                </div>
                                                                <div class="col-md-1 text-center border-end border-dark td-weightage" data-indicator-id="{{ $row->id }}">
                                                                    {{ number_format($row->indicatorWeightage, 0) }}%
                                                                </div>
                                                                <div class="col-md-1 border-end border-dark">&nbsp;</div>
                                                                <div class="col-md-1"><textarea name="comments" id="comments" rows="2" cols="10">{{ $row->comments }}</textarea></div>
                                                                <div class="col-md-1 text-center">
                                                                    <button class="btn btn-primary waves-effect" type="button"
                                                                                onclick="saveComments('comment_form_{{ $row->id }}', '{{ route('projects.saveComments') }}', {{ $row->id }} ); return false;">
                                                                                SAVE
                                                                            </button>
                                                                </div>
                                                                
                                                            </div>
                                                            <input type="hidden" value="Planning" name="comments_for">
                                                            <input type="hidden" value="{{ $row->id }}" name="indicator_id">
                                                            <input type="hidden" value="{{ $project->id }}" name="updatedProjectId">
                                                    </form>
                                                @endforeach
                                
                                                <!-- Footer Button Row -->
                                                <div class="row border border-dark py-3 text-center">
                                                    <div class="col-12">
                                                        <button type="button" class="btn btn-primary waves-effect">REVIEWED</button>
                                                    </div>
                                                </div>
                                
                                            </div>
                                       
                                </div>
                                        <!-- #END# Basic Table -->
                                </section>


                                <h2>Design</h2>
                                 <section>
                                        
                                        <!-- Basic Table -->
                                        <div class="row clearfix">
                                                    <div class="header">
                                                        <h2>
                                                            AKU Kampala
                                                            <small>Project details modification classes</small>
                                                        </h2>
                                                    </div>
                                                    <form id="design_cost_form" method="POST" class="mb-0">
                                                        @csrf   
                                                        <div class="status-message text-success mt-2" style="margin-left: 1070px;"></div> 
                                                        <div class="row">
                                                            <div class="col-md-5"></div>
                                                            <div class="col-md-4">
                                                                <label for="cost_at_design">
                                                                    Is the Construction Cost (USD) changed at Design Phase:
                                                                    <i class="material-icons col-red"><b>*</b></i>
                                                                </label>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input type="text" name="cost_at_design" id="cost_at_design" class="form-control" value="{{ old('cost_at_design', $project->cost_at_design) }}">
                                                                
                                                            </div>
                                                            <div class="col-md-1">
                                                                <button class="btn btn-primary waves-effect" type="button"
                                                                onclick="updateCost('design_cost_form', '{{ route('projects.updateCost') }}' ); return false;">
                                                                UPDATE
                                                            </button>
                                                            </div>
                                                        </div>
                                                        <input type="hidden" value="cost_at_design" name="cost_phase">
                                                        <input type="hidden" value="{{ $project->id }}" name="updatedProjectId">
                                                    </form>
                                                    
                                                    <div class="body table-responsive">

                                                        <!-- Header -->
                                                        <div class="header bg-light-green border-bottom border-dark pb-0 mb-3">
                                                            <div class="row fw-bold text-dark text-center border border-dark">
                                                                <div class="col-md-1 border-end border-dark py-0">GBG's Ref</div>
                                                                <div class="col-md-6 border-end border-dark py-0">Assessment Description</div>
                                                                <div class="col-md-2 border-end border-dark py-0">Degree of compliance</div>
                                                                <div class="col-md-2 border-end border-dark py-0">Assessment</div>
                                                                <div class="col-md-1 py-0">Actions</div>
                                                            </div>
                                                        </div>
                                                        <hr class="my-3 border border-dark opacity-75">
                                                        <!-- Checklist Rows -->
                                                        @foreach ($designAssessmentInfo as $row)
                                                            <form id="design_form_{{ $row->id }}" method="POST" enctype="multipart/form-data" class="mb-0">
                                                                @csrf
                                                                <div class="status-message text-success mt-2" style="margin-left: 1050px;"></div>
                                                                <div class="border border-dark border-top-0 item-form mb-0" data-indexChecklistId="{{ $row->id }}">
                                                                    <div class="row">
                                                                        <!-- GBG's Ref -->
                                                                        <div class="col-md-1 border-end border-dark py-2">
                                                                            {{ $row->ref_no }}
                                                                        </div>
                                                    
                                                                        <!-- Checklist Name -->
                                                                        <div class="col-md-6 border-end border-dark text-start py-2">
                                                                            {{ $row->indicator_name }}
                                                                            @if($row->is_mandatory === 1)
                                                                                <i class="material-icons col-red"><b>(*)</b></i>
                                                                            @endif
                                                                        </div>
                                                    
                                                                        <!-- Degree of compliance -->
                                                                        @if ($row->id === 4)
                                                                            <div class="col-md-2 border-end border-dark py-2">
                                                                                <select class="form-control option-select" name="compliance">
                                                                                    <option value="">Choose</option>
                                                                                    <option value="2" @selected(old('compliance', $row->compliances_id) == '2')>YES</option>
                                                                                    <option value="4" @selected(old('compliance', $row->compliances_id) == '4')>No but it is upto 30% more than the aspirational value</option>
                                                                                    <option value="5" @selected(old('compliance', $row->compliances_id) == '5')>No but it is 30% to 50% more than the aspirational value</option>
                                                                                    <option value="6" @selected(old('compliance', $row->compliances_id) == '6')>No but it is 50% to 70% more than the aspirational value</option>
                                                                                    <option value="7" @selected(old('compliance', $row->compliances_id) == '7')>No but it is 70% more than the aspirational value</option>
                                                                                </select>
                                                                            </div>
                                                                        @elseif ($row->id === 5)
                                                                            <div class="col-md-2 border-end border-dark py-2">
                                                                                <select class="form-control option-select" name="compliance">
                                                                                    <option value="">Choose</option>
                                                                                    <option value="2" @selected(old('compliance', $row->compliances_id) == '2')>YES</option>
                                                                                    <option value="8" @selected(old('compliance', $row->compliances_id) == '8')>No but a generator is suggested based on < 5% use of normal operations </option>
                                                                                    <option value="1" @selected(old('compliance', $row->compliances_id) == '1')>NO</option>
                                                                                </select>
                                                                            </div>
                                                                        @elseif ($row->id === 8)
                                                                            <div class="col-md-2 border-end border-dark py-2">
                                                                                <select class="form-control option-select" name="compliance">
                                                                                    <option value="">Choose</option>
                                                                                    <option value="1" @selected(old('compliance', $row->compliances_id) == '1')>NO</option>
                                                                                    <option value="9" @selected(old('compliance', $row->compliances_id) == '9')>Yes, the on-site generation is > 80% <= 100% of the total operational energy demand</option>
                                                                                    <option value="10" @selected(old('compliance', $row->compliances_id) == '10')>Yes, the on-site generation is > 50% < 80% of the total operational energy demand</option>
                                                                                    <option value="11" @selected(old('compliance', $row->compliances_id) == '11')>Yes, the on-site generation is > 30% < 50% of the total operational energy demand</option>
                                                                                    <option value="12" @selected(old('compliance', $row->compliances_id) == '12')>Yes, the on-site generation is > 30% < 50% of the total operational energy demand</option>
                                                                                    <option value="13" @selected(old('compliance', $row->compliances_id) == '13')>Yes, the on-site generation is > 15% < 30% of the total operational energy demand</option>
                                                                                </select>
                                                                            </div>
                                                                        @else
                                                                            <div class="col-md-2 border-end border-dark py-2">
                                                                                <select class="form-control option-select" name="compliance">
                                                                                    <option value="">Choose</option>
                                                                                    <option value="2" @selected(old('compliance', $row->compliances_id) == '2')>YES</option>
                                                                                    <option value="1" @selected(old('compliance', $row->compliances_id) == '1')>NO</option>
                                                                                    <option value="3" @selected(old('compliance', $row->compliances_id) == '3')>N/A</option>
                                                                                </select>
                                                                            </div>
                                                                        @endif
                                                                        
                                                                        <!-- File Upload -->
                                                                        <div class="col-md-2 border-end border-dark text-start py-2">
                                                                            <input type="file" class="form-control file-input" name="design_uploads"><br>
                                                                            @if(!empty($row->file_path))
                                                                                <div class="uploaded-file mt-2">
                                                                                    📎 <a href="{{ asset('storage/' . $row->file_path) }}" target="_blank">View Uploaded File</a>
                                                                                    <button type="button" class="btn btn-danger waves-effect mt-2"
                                                                                        onclick="deleteDesignFile('design_form_{{ $row->id }}', '{{ route('projects.deleteDesignFile') }}', {{ $row->id }} ); return false;">
                                                                                        Delete file
                                                                                    </button>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                    
                                                                        <!-- Save Button -->
                                                                        <div class="col-md-1 text-start py-2">
                                                                            <button class="btn btn-primary waves-effect" type="button"
                                                                                onclick="saveDesignValues('design_form_{{ $row->id }}', '{{ route('projects.saveDesignAssessment') }}', {{ $row->id }}, '{{ route('projects.deleteDesignFile') }}'); return false;">
                                                                                SAVE
                                                                            </button>
                                                                           
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <input type="hidden" value="{{ $row->id }}" name="indicator_id">
                                                                <input type="hidden" value="{{ $project->id }}" name="updatedProjectId">
                                                            </form>
                                                        @endforeach
                                                    
                                                    </div>          
                                        </div>
                                        <!-- #END# Basic Table -->
                                
                                    </section>
                                    <h2>Design Review</h2>
                                    <section>
                                         <!-- Basic Table -->
                                         <div class="row clearfix">
                                            
                                                    <div class="body table-responsive">
                                        
                                                                        <!-- Header Row 1 -->
                                                        <div class="row bg-light-green text-white fw-bold border border-dark text-center py-2">
                                                            <div class="col-md-1 border-end border-dark">GBG's Ref</div>
                                                            <div class="col-md-5 border-end border-dark">Assessment Description</div>
                                                            <div class="col-md-1 border-end border-dark">Degree of Compliance</div>
                                                            <div class="col-md-1"></div>
                                                            <div class="col-md-1">Assessment</div>
                                                            <div class="col-md-1"></div>
                                                        </div>

                                                        <!-- Header Row 2 (Sub-columns under Assessment) -->
                                                        <div class="row bg-blue-grey text-center fw-bold border-start border-end border-bottom border-dark py-2">
                                                            <div class="col-md-1 border-end border-dark">&nbsp;</div>
                                                            <div class="col-md-5 border-end border-dark">&nbsp;</div>
                                                            <div class="col-md-1 border-end border-dark">&nbsp;</div>
                                                            <div class="col-md-1 border-end border-dark">Score</div>
                                                            <div class="col-md-1 border-end border-dark">Weightage</div>
                                                            <div class="col-md-1">Rating</div>
                                                            <div class="col-md-1"></div>
                                                            <div class="col-md-1"></div>
                                                        </div>
                                        
                                                        <!-- Summary Score Row -->

                                                        <div class="row bg-grey text-center fw-bold border-start border-end border-bottom border-dark py-2">
                                                            <div class="col-md-1 border-end border-dark">&nbsp;</div>
                                                            <div class="col-md-5 border-end border-dark">&nbsp;</div>
                                                            <div class="col-md-1 border-end border-dark">&nbsp;</div>
                                                            <div class="col-md-1 border-end border-dark  td-dfinalscore" data-indicator-id="designFinalScore">
                                                                @if ($designFinalScoreRating)
                                                                {{ number_format($designFinalScoreRating->score, 1) }}
                                                                @endif
                                                            
                                                            </div>
                                                            <div class="col-md-1 border-end border-dark">45%</div>
                                                            <div class="col-md-1 td-dfinalrating" data-indicator-id="designRating">
                                                                @if ($designFinalScoreRating)
                                                                    {{ $designFinalScoreRating->rating }}
                                                                @endif
                                                            </div>
                                                            <div class="col-md-1">Comments</div>
                                                            <div class="col-md-1">Actions</div>
                                                        </div>       

                                                        <!-- Dynamic Score Rows -->
                                                        @foreach ($designAssessmentInfo as $row)
                                                        <form id="design_comment_form_{{ $row->id }}" method="POST"  class="mb-0">    
                                                            @csrf
                                                            <div class="status-message text-success mt-2" style="margin-left: 1150px;"></div> 
                                                            <div class="row border-start border-end border-bottom border-dark py-2 item-form" data-indexPlanningIndcaotrId="{{ $row->id }}">
                                                                <div class="col-md-1 border-end border-dark">
                                                                    {{ $row->ref_no }}
                                                                </div>
                                                                <div class="col-md-5 border-end border-dark text-start">
                                                                    {{ $row->indicator_name }}
                                                                    @if($row->is_mandatory === 1)
                                                                        <i class="material-icons col-red"><b>(*)</b></i>
                                                                    @endif
                                                                </div>
                                                                <div class="col-md-1 text-center border-end border-dark td-dcomp-name" data-indicator-id="{{ $row->id }}">
                                                                    {{ $row->comp_name }}
                                                                </div>
                                                                <div class="col-md-1 text-center border-end border-dark td-dcomp-score" data-indicator-id="{{ $row->id }}">
                                                                    {{ $row->complianceScore }}
                                                                </div>
                                                                <div class="col-md-1 text-center border-end border-dark td-dweightage" data-indicator-id="{{ $row->id }}">
                                                                    {{ number_format($row->indicatorWeightage, 0) }}%
                                                                </div>
                                                                <div class="col-md-1 border-end border-dark">&nbsp;</div>
                                                                <div class="col-md-1"><textarea name="comments" id="comments" rows="2" cols="10">{{ $row->comments }}</textarea>
                                                                </div>
                                                                <div class="col-md-1 text-center">
                                                                    <button class="btn btn-primary waves-effect" type="button"
                                                                                onclick="saveComments('design_comment_form_{{ $row->id }}', '{{ route('projects.saveComments') }}', {{ $row->id }} ); return false;">
                                                                                SAVE
                                                                            </button>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" value="Design" name="comments_for">
                                                            <input type="hidden" value="{{ $row->id }}" name="indicator_id">
                                                            <input type="hidden" value="{{ $project->id }}" name="updatedProjectId">
                                                        </form>
                                                        @endforeach
                                        
                                                        <!-- Footer Button Row -->
                                                        <div class="row border border-dark py-3 text-center">
                                                            <div class="col-12">
                                                                <button type="button" class="btn btn-primary waves-effect">REVIEWED</button>
                                                            </div>
                                                        </div>
                                        
                                                    </div>
                                               
                                        </div>
                                        
                                        <!-- #END# Basic Table -->
                                    </section>
                                <h2>Construction</h2>
                                <section>
                                    <!-- Basic Table -->
                                    <div class="row clearfix">
                                        <div class="header">
                                            <h2>
                                                AKU Kampala
                                                <small>Project details modification classes</small>
                                            </h2>
                                        </div>
                                        <form id="cons_cost_form" method="POST" class="mb-0">
                                            @csrf   
                                            <div class="status-message text-success mt-2" style="margin-left: 1070px;"></div> 
                                            <div class="row">
                                                <div class="col-md-5"></div>
                                                <div class="col-md-4">
                                                    <label for="cost_at_cons">
                                                        Is the Construction Cost (USD) changed at Construction Phase:
                                                        <i class="material-icons col-red"><b>*</b></i>
                                                    </label>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" name="cost_at_construction" id="cost_at_construction" class="form-control" value="{{ old('cost_at_construction', $project->cost_at_construction) }}">
                                                   
                                                </div>
                                                <div class="col-md-1">
                                                    <button class="btn btn-primary waves-effect" type="button"
                                                    onclick="updateCost('cons_cost_form', '{{ route('projects.updateCost') }}' ); return false;">
                                                    UPDATE
                                                </button>
                                                </div>
                                            </div>
                                            <input type="hidden" value="cost_at_construction" name="cost_phase">
                                            <input type="hidden" value="{{ $project->id }}" name="updatedProjectId">
                                        </form>
                                        <div class="body table-responsive">

                                            <!-- Header -->
                                            <div class="header bg-light-green border-bottom border-dark pb-0 mb-0">
                                                <div class="row fw-bold text-dark text-center border border-dark">
                                                    <div class="col-md-1 border-end border-dark py-0">GBG's Ref</div>
                                                    <div class="col-md-6 border-end border-dark py-0">Assessment Description</div>
                                                    <div class="col-md-2 border-end border-dark py-0">Degree of compliance</div>
                                                    <div class="col-md-2 border-end border-dark py-0">Assessment</div>
                                                    <div class="col-md-1 py-0">Actions</div>
                                                </div>
                                            </div>
                                            <hr class="my-3 border border-dark opacity-75">
                                            <!-- Checklist Rows -->
                                            @foreach ($constructionAssessInfo as $row)
                                                <form id="cons_form_{{ $row->id }}" method="POST" enctype="multipart/form-data" class="mb-0">
                                                    @csrf
                                                    
                                                        <div class="row">
                                                            <!-- GBG's Ref -->
                                                            <div class="col-md-1 border-end border-dark py-2">
                                                                {{ $row->ref_no }}
                                                            </div>
                                        
                                                            <!-- Checklist Name -->
                                                            <div class="col-md-6 border-end border-dark text-start py-2">
                                                                {{ $row->indicator_name }}
                                                               
                                                            </div>
                                        
                                                            <!-- Degree of compliance -->
                                                            @if ($row->id === 2)
                                                                <div class="col-md-2 border-end border-dark py-2">
                                                                    <select class="form-control option-select" name="compliance">
                                                                        <option value="">Choose</option>
                                                                        <option value="4" @selected(old('compliance', $row->compliances_id) == '4')>Yes more than 80% of the vendors/suppliers are local</option>
                                                                        <option value="5" @selected(old('compliance', $row->compliances_id) == '5')>Yes > 50 < 80% of the vendors/suppliers are local</option>
                                                                        <option value="6" @selected(old('compliance', $row->compliances_id) == '6')>Yes < 30% of the vendors/suppliers are local</option>
                                                                        <option value="7" @selected(old('compliance', $row->compliances_id) == '7')>Yes > 30 < 50% of the vendors/suppliers are local</option>
                                                                        <option value="1" @selected(old('compliance', $row->compliances_id) == '1')>NO</option>
                                                                    </select>
                                                                </div>
                                                                @else
                                                                <div class="col-md-2 border-end border-dark py-2">
                                                                    <select class="form-control option-select" name="compliance">
                                                                        <option value="">Choose</option>
                                                                        <option value="2" @selected(old('compliance', $row->compliances_id) == '2')>YES</option>
                                                                        <option value="1" @selected(old('compliance', $row->compliances_id) == '1')>NO</option>
                                                                        <option value="3" @selected(old('compliance', $row->compliances_id) == '3')>N/A</option>
                                                                    </select>
                                                                </div>
                                                            @endif
                                                            
                                                            <!-- File Upload -->
                                                            <div class="col-md-2 border-end border-dark text-start py-2">
                                                                <input type="file" class="form-control file-input" name="cons_uploads"><br>
                                                                @if(!empty($row->file_path))
                                                                    <div class="uploaded-file mt-2">
                                                                        📎 <a href="{{ asset('storage/' . $row->file_path) }}" target="_blank">View Uploaded File</a>
                                                                        <button type="button" class="btn btn-danger waves-effect mt-2"
                                                                            onclick="deleteConstructionFile('cons_form_{{ $row->id }}', '{{ route('projects.deleteConstructionFile') }}', {{ $row->id }} ); return false;">
                                                                            Delete file
                                                                        </button>
                                                                    </div>
                                                                @endif
                                                            </div>
                                        
                                                            <!-- Save Button -->
                                                            <div class="col-md-1 text-start py-2">
                                                                <button class="btn btn-primary waves-effect" type="button"
                                                                    onclick="saveConstructionValues('cons_form_{{ $row->id }}', '{{ route('projects.saveConstructionAssessment') }}', {{ $row->id }}, '{{ route('projects.deleteConstructionFile') }}'); return false;">
                                                                    SAVE
                                                                </button>
                                                                <div class="status-message text-success mt-2"></div>
                                                            </div>
                                                        </div>
                                                    
                                                    <input type="hidden" value="{{ $row->id }}" name="indicator_id">
                                                    <input type="hidden" value="{{ $project->id }}" name="updatedProjectId">
                                                </form>
                                            @endforeach
                                        
                                        </div>          
                            </div>
                            <!-- #END# Basic Table -->
                                </section>
                                <h2>Construction Review</h2>
                                <section>
                                     <!-- Basic Table -->
                                     <div class="row clearfix">
                                            
                                        <div class="body table-responsive">
                            
                                            <!-- Header Row 1 -->
                                            <div class="row bg-light-green text-white fw-bold border border-dark text-center py-2">
                                                <div class="col-md-1 border-end border-dark">GBG's Ref</div>
                                                <div class="col-md-5 border-end border-dark">Assessment Description</div>
                                                <div class="col-md-1 border-end border-dark">Degree of Compliance</div>
                                                <div class="col-md-1"></div>
                                                <div class="col-md-1">Assessment</div>
                                                <div class="col-md-1"></div>
                                            </div>

                                            <!-- Header Row 2 (Sub-columns under Assessment) -->
                                            <div class="row bg-blue-grey text-center fw-bold border-start border-end border-bottom border-dark py-2">
                                                <div class="col-md-1 border-end border-dark">&nbsp;</div>
                                                <div class="col-md-5 border-end border-dark">&nbsp;</div>
                                                <div class="col-md-1 border-end border-dark">&nbsp;</div>
                                                <div class="col-md-1 border-end border-dark">Score</div>
                                                <div class="col-md-1 border-end border-dark">Weightage</div>
                                                <div class="col-md-1">Rating</div>
                                                <div class="col-md-1"></div>
                                                <div class="col-md-1"></div>
                                            </div>
                            
                                            <!-- Summary Score Row -->

                                            <div class="row bg-grey text-center fw-bold border-start border-end border-bottom border-dark py-2">
                                                <div class="col-md-1 border-end border-dark">&nbsp;</div>
                                                <div class="col-md-5 border-end border-dark">&nbsp;</div>
                                                <div class="col-md-1 border-end border-dark">&nbsp;</div>
                                                <div class="col-md-1 border-end border-dark  td-cfinalscore" data-indicator-id="consFinalScore">
                                                    @if ($constructionFinalScoreRating)
                                                    {{ number_format($constructionFinalScoreRating->score, 1) }}
                                                    @endif
                                                
                                                </div>
                                                <div class="col-md-1 border-end border-dark">45%</div>
                                                <div class="col-md-1 td-cfinalrating" data-indicator-id="consRating">
                                                    @if ($constructionFinalScoreRating)
                                                        {{ $constructionFinalScoreRating->rating }}
                                                    @endif
                                                </div>
                                                <div class="col-md-1">Comments</div>
                                                <div class="col-md-1">Actions</div>
                                            </div>       

                                            <!-- Dynamic Score Rows -->
                                            @foreach ($constructionAssessInfo as $row)
                                            <form id="cons_comment_form_{{ $row->id }}" method="POST"  class="mb-0">    
                                                @csrf
                                                <div class="status-message text-success mt-2" style="margin-left: 1150px;"></div>     
                                                <div class="row border-start border-end border-bottom border-dark py-2 item-form" data-indexConsIndcaotrId="{{ $row->id }}">
                                                    <div class="col-md-1 border-end border-dark">{{ $row->ref_no }}</div>
                                                    <div class="col-md-5 border-end border-dark text-start"> {{ $row->indicator_name }}</div>
                                                    <div class="col-md-1 text-center border-end border-dark td-ccomp-name" data-indicator-id="{{ $row->id }}">{{ $row->comp_name }}</div>
                                                    <div class="col-md-1 text-center border-end border-dark td-ccomp-score" data-indicator-id="{{ $row->id }}">{{ $row->complianceScore }}</div>
                                                    <div class="col-md-1 text-center border-end border-dark td-cweightage" data-indicator-id="{{ $row->id }}">{{ number_format($row->indicatorWeightage, 0) }}%</div>
                                                    <div class="col-md-1 border-end border-dark">&nbsp;</div>
                                                    <div class="col-md-1"><textarea name="comments" id="comments" rows="2" cols="10">{{ $row->comments }}</textarea></div>
                                                    <div class="col-md-1 text-center">
                                                            <button class="btn btn-primary waves-effect" type="button"
                                                                onclick="saveComments('cons_comment_form_{{ $row->id }}', '{{ route('projects.saveComments') }}', {{ $row->id }} ); return false;">SAVE
                                                            </button>
                                                    </div>
                                                </div>
                                                <input type="hidden" value="Construction" name="comments_for">
                                                <input type="hidden" value="{{ $row->id }}" name="indicator_id">
                                                <input type="hidden" value="{{ $project->id }}" name="updatedProjectId">
                                            </form>
                                            @endforeach
                            
                                            <!-- Footer Button Row -->
                                            <div class="row border border-dark py-3 text-center">
                                                <div class="col-12">
                                                    <button type="button" class="btn btn-primary waves-effect">REVIEWED</button>
                                                </div>
                                            </div>
                            
                                        </div>
                                   
                            </div>
                            
                            <!-- #END# Basic Table -->
                                </section>
                            </div>  
                        </div>
                        
                    </div>
                </div>
            </div>
            <!-- #END# Basic Example | Horizontal Layout -->
           
    </section>

<!-- ./wrapper -->

<!-- Jquery Core Js -->
    <script src="https://gurayyarar.github.io/AdminBSBMaterialDesign/plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="https://gurayyarar.github.io/AdminBSBMaterialDesign/plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Select Plugin Js  
    <script src="https://gurayyarar.github.io/AdminBSBMaterialDesign/plugins/bootstrap-select/js/bootstrap-select.js"></script>
    -->

    <!-- Slimscroll Plugin Js -->
    <script src="https://gurayyarar.github.io/AdminBSBMaterialDesign/plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Jquery Validation Plugin Css -->
    <script src="https://gurayyarar.github.io/AdminBSBMaterialDesign/plugins/jquery-validation/jquery.validate.js"></script>

    <script src="https://gurayyarar.github.io/AdminBSBMaterialDesign/plugins/jquery-steps/jquery.steps.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="https://gurayyarar.github.io/AdminBSBMaterialDesign/plugins/node-waves/waves.js"></script>

    <!-- Autosize Plugin Js -->
    <script src="https://gurayyarar.github.io/AdminBSBMaterialDesign/plugins/autosize/autosize.js"></script>

    <!-- Moment Plugin Js -->
    <script src="https://gurayyarar.github.io/AdminBSBMaterialDesign/plugins/momentjs/moment.js"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="https://gurayyarar.github.io/AdminBSBMaterialDesign/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

    <!-- Bootstrap Datepicker Plugin Js -->
    <script src="https://gurayyarar.github.io/AdminBSBMaterialDesign/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

    <!-- Custom Js -->
    <script src="https://gurayyarar.github.io/AdminBSBMaterialDesign/js/admin.js"></script>
<!--
<script src="https://gurayyarar.github.io/AdminBSBMaterialDesign/js/pages/forms/form-wizard.js"></script>
-->
    <script src="https://gurayyarar.github.io/AdminBSBMaterialDesign/js/pages/forms/basic-form-elements.js"></script>

    <!-- Demo Js -->
    <script src="https://gurayyarar.github.io/AdminBSBMaterialDesign/js/demo.js"></script>


<script src="{{asset('js/helper.js')}}"></script>


<!-- Dropdown Script 
<script>
$(document).ready(function(){
    $('#type_id').on('change', function() {
                var typeID = $(this).val();
                // alert(typeID);
            if (typeID) {
                $.ajax({
                    url: '/getBuildingSubTypes/' + typeID,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        $('#sub_type_id').empty().append('<option value="">-- Select Subtype --</option>');
                        $.each(data, function (key, value) {
                            $('#sub_type_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#sub_type_id').empty().append('<option value="">-- Select Subtype --</option>');
            }
    });
});
</script>
-->
<script>
$(function () {

    $("#wizard_horizontal").steps({
        headerTag: "h2",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        autoFocus: true,

        onStepChanging: function (event, currentIndex, newIndex) {
            // Only block forward movement
            // Only when going from Step 1 to Step 2 (index 0 to 1)
            if (currentIndex === 3 && newIndex === 4) {
                if (!waitForReview()) {
                    return false; // Block going to Step 2
                }
            }
            if (currentIndex === 2 && newIndex === 3) {
                if (!allChecklist()) {
                    return false; // Block going to Step 2
                }
            }

            return true; // Allow all other transitions
        }
    });

});

// Example custom JS function
function waitForReview() {
    // Your custom logic here
    // For example, check if a field is filled
    // var value = $('#totalPlanningIndicators').val();
   // alert(value);
    var value = 2;
    if (value === 2) {
        return true;
    } else {
        alert("Please wait until it has been reviewed by higher management..");
        return false;
    }
}

// To check all checklists are answered or not on step 3....
function allChecklist() {
    // Your custom logic here
    // For example, check if a field is filled
    //var value = $('#myInputField').val();
    var value = 2;
    if (value === 2) {
        return true;
    } else {
        alert("Some checklist items have not been answered..");
        return false;
    }
}

</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let oneMillion = parseFloat($('#min_cost').val());
        let fiveMillion = parseFloat($('#max_cost').val());
        let output_1 = $('#output_1').val();
        let output_2 = $('#output_2').val();
        let output_3 = $('#output_3').val();
    
        const inputField = document.getElementById('construction_cost');
        const resultField = document.getElementById('requirements');
    
        if (!inputField || !resultField) return;
    
        inputField.addEventListener('input', function () {
            const value = this.value.trim();
            const num = parseFloat(value);
            let result = '';
    
            if (value === '') {
                result = 'Please enter a number';
                resultField.style.color = 'gray';
            } else if (isNaN(num)) {
                result = 'Invalid input';
                resultField.style.color = 'red';
            } else {
                if (num < oneMillion) {
                    result = output_1;
                    resultField.style.color = 'orange';
                } else if (num >= oneMillion && num < fiveMillion) {
                    result = output_2;
                    resultField.style.color = 'green';
                } else {
                    result = output_3;
                    resultField.style.color = 'red';
                }
            }
    
            resultField.value = result;
        });
    });
 </script>