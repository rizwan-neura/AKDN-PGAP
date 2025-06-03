

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
                        @isset($project)
                        {{ dump($project) }}
                        @endisset
                            <div id="wizard_horizontal">
                                <h2>Create Project</h2>
                                <section>
                                       
                                        @include('_includes.message')
                                        
                                         @include('_includes.errors')
                                        <form name="create_project" id="create_project" method="POST" action="{{ route('projects.store') }}"> 
                                        @csrf
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
                                                                <input type="text" name="project_name" value="{{old('project_name')}}" class="form-control" placeholder="Enter ...">
                                                                    @error('project_name')<i class="col-red">{{ $message }}</i>@enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <!-- text input -->
                                                            <div class="form-group">
                                                                <label>Current Phase</label>
                                                                <i class="material-icons col-red"><b>*</b></i>
                                                                    <select name="phase_id" class="form-control select2">
                                                                    <option value="">-Select Phase-</option>
                                                                    @foreach($projectPhases as $id => $phase_name)
                                                                        <option value="{{ $id }}" {{ old('phase_id') == $id ? 'selected' : '' }}>{{ $phase_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                @error('phase_id')<i class="col-red">{{ $message }}</i>@enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <!-- text input -->
                                                            <div class="form-group">
                                                                <label>Assessment requirement</label>
                                                                <input type="text" name="assessment_req" id="assessment_req" value="{{old('assessment_req')}}" class="form-control" placeholder="Enter ...">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <!-- text input -->
                                                            <div class="form-group">
                                                                <label>Organization</label>
                                                                <i class="material-icons col-red"><b>*</b></i>
                                                                    <select name="organization_id" class="form-control select2" >
                                                                    <option value="">-Select Organization-</option>
                                                                    @foreach($organizations as $id => $organization_name)
                                                                        <option value="{{ $id }}" {{ old('organization_id') == $id ? 'selected' : '' }}>{{ $organization_name }}</option>
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
                                                                        <input type="text" name="date_gpa" value="{{old('date_gpa')}}" class="form-control" placeholder="Please choose a date...">
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
                                                                        <input type="text" name="start_date" value="{{old('start_date')}}" class="form-control" placeholder="Please choose a date...">
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
                                                                        <input type="text" name="end_date"  value="{{old('end_date')}}" class="form-control" placeholder="Please choose a date...">
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
                                                                <input type="text" class="form-control" value="{{old('location')}}" name="location" placeholder="Enter ...">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <!-- text input -->
                                                            <div class="form-group">
                                                                <label>GPS Coordinates</label>
                                                                <input type="text" class="form-control" value="{{old('coordiates')}}" name="coordiates" placeholder="Enter ...">
                                                            </div>
                                                        </div>
                                                       <!-- Building Type Dropdown -->
                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                <label>Building Type</label>
                                                                <i class="material-icons col-red"><b>*</b></i>
                                                                <select name="type_id" id="type_id" class="form-control select2" onchange="javascript: ajaxFormGet('create_project','{{ route('projects.getBuildingSubTypes') }}','sub_type_id');return false;">
                                                                    <option value="">-Select Type-</option>
                                                                    @foreach($buildingTypes as $id => $type_name)
                                                                        <option value="{{ $id }}" {{ old('type_id') == $id ? 'selected' : '' }}>{{ $type_name }}</option>
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
                                                                <label>Construction Cost (USD) &nbsp; at </label>
                                                                  <select name="phase_id2" style="margin-left:10px;" >
                                                                 <option value="">Planning</option>
                                                                 <option value="">Design</option>
                                                                 <option value="">Construction</option>
                                                                 </select>
                                                                 <i class="material-icons col-red"><b>*</b></i>
                                                                 <input type="text" name="construction_cost" value="{{old('construction_cost')}}" class="form-control" placeholder="Exp 9999.99">
                                                                 @error('construction_cost')<i class="col-red">{{ $message }}</i>@enderror
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <!-- text input -->
                                                            <div class="form-group">
                                                                <label>Mandatory Requirement</label>
                                                                <input type="text" name="requirements" value="{{old('requirements')}}" class="form-control" placeholder="Enter ...">
                                                            </div>
                                                        </div>
                                                        
                                                    
                                                </div>
                                             
                                            </div>
                                            
                                            </div>
                                            <!-- /.card -->
                                           <input type="hidden" name="step" value="0">
                                            <button type="submit" class="btn btn-primary m-t-15 waves-effect">SAVE PROJECT</button>
                                            </div>
                                        <!-- /.container-fluid -->
                                       

                                        <input type="hidden" value="{{ $totalChecklistCount }}" name="totalChecklistCount" id="totalChecklistCount">
                                        
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
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="card">
                                                   
                                                    <div class="body table-responsive">
                                                        <table class="table table-bordered">
                                                            <thead class="header bg-light-green">
                                                                <tr>
                                                                <th width="10%">Checklist #</th>
                                                                    <th width="50%">Requirements</th>
                                                                     <th width="15%">Status</th>
                                                                    <th width="20%">Upload Documents</th>
                                                                    <th align="center" width="5%"></th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                            @foreach ($checklistRequirements as $row)
                                                            <form id="checklist_form_{{ $row->id }}" method="POST" enctype="multipart/form-data" >
                                                                @csrf
                                                                <table class="table table-bordered">
                                                                    <tr class="item-form border p-3 mb-3" data-indexChecklistId="{{ $row->id }}">
                                                                        <td align="center" width="10%">{{ $row->id }}</td>
                                                                        <td width="50%">
                                                                            {{ $row->checklist_name }}
                                                                            @if($row->is_mandatory === 1)
                                                                                <i class="material-icons col-red"><b>(*)</b></i>
                                                                            @endif
                                                                        </td>
                                                                        <td width="15%">
                                                                            <select class="form-control option-select" name="checklistStatus">
                                                                                <option value="">Choose</option>
                                                                                <option value="YES">YES</option>
                                                                                <option value="NO">NO</option>
                                                                            </select>
                                                                        </td>
                                                                        <td width="20%">
                                                                            <input type="file" class="form-control file-input" name="checklist_uploads">
                                                                        </td>
                                                                        <td width="5%">
                                                                            <button class="btn btn-primary waves-effect" type="button"
                                                                                    onclick="saveIndicatorValues('checklist_form_{{ $row->id }}', '{{ route('projects.saveCheckList') }}', {{ $row->id }}, '{{ route('projects.deleteCheckListFile') }}'); return false;">
                                                                                SAVE
                                                                            </button>
                                                                            
                                                                            <div class="status-message text-success mt-2"></div>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                                <input type="hidden" value="{{ $row->id }}" name="checklist_id">
                                                                <input type="hidden" value="5" name="updatedProjectId">

                                                            </form>
                                                            @endforeach

                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- #END# Basic Table -->
                                </section>

                               
                                 <h2>Planning</h2>
                                <section>
                                        
                                        <!-- Basic Table -->
                                        <div class="row clearfix">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="card">
                                                   
                                                    <div class="body table-responsive">
                                                        <table class="table table-bordered">
                                                            <thead class="header bg-light-green">
                                                                <tr>
                                                                    <th>GBG's Ref</th>
                                                                    <th>Assessment Description</th>
                                                                    <th rowspan="0">Degree of compliance</th>
                                                                    <th align="center" colspan="3"> </th>
                                                                </tr>
                                                            </thead>
                                                             
                                                            <tbody>
                                                                
                                                                 
                                                                <tr>
                                                                    <th scope="row">1.1</th>
                                                                    <td>
                                                                    
                                                                    Is a feasibility study conducted by the project team to assess, "Should we build" approach concluded? And has this been submitted, along with the justification to the CSA for review and sign off? </td>
                                                                  
                                                                    <td>
                                                                    <select name="test" id="test">
                                                                    <option value="YES">YES</option>
                                                                    <option value="NO">NO</option>
                                                                    <option value="NA">N/A</option>
                                                                    </select>   
                                                                    
                                                                    </td>
                                                                    
                                                                    <td><input type="file" id="myFile" name="filename">
                                                                    </td>
                                                                     <td><button type="button" class="btn btn-primary waves-effect">SAVE</button></td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">1.2</th>
                                                                    <td>As part of feasibility study, is a workshop on environment and climate change and the relevance to the project held?</td>
                                                                    <td>
                                                                     <select name="test" id="test">
                                                                    <option value="YES">YES</option>
                                                                    <option value="NO">NO</option>
                                                                    <option value="NA">N/A</option>
                                                                    </select>
                                                                    </td>
                                                                     <td><input type="file" id="myFile" name="filename">
                                                                    </td>
                                                                     <td><button type="button" class="btn btn-primary waves-effect">SAVE</button></td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">2.1</th>
                                                                    <td>Is the project aligned with the AKAH Habitat Planning Framework?</td>
                                                                    <td> <select name="test" id="test">
                                                                    <option value="YES">YES</option>
                                                                    <option value="NO">NO</option>
                                                                    <option value="NA">N/A</option>
                                                                    </select></td>
                                                                    <td><input type="file" id="myFile" name="filename">
                                                                    </td>
                                                                     <td><button type="button" class="btn btn-primary waves-effect">SAVE</button></td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">2.2</th>
                                                                    <td>Is the site selected meeting the full scope of technical due diligences?</td>
                                                                    <td> <select name="test" id="test">
                                                                    <option value="YES">YES</option>
                                                                    <option value="NO">NO</option>
                                                                    <option value="NA">N/A</option>
                                                                    </select></td>
                                                                    <td><input type="file" id="myFile" name="filename">
                                                                    </td>
                                                                    <td><button type="button" class="btn btn-primary waves-effect">SAVE</button></td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">2.3</th>
                                                                    <td>Is the site selected considered for use of local resources, including energy, water and materials?</td>
                                                                    <td> <select name="test" id="test">
                                                                    <option value="YES">YES</option>
                                                                    <option value="NO">NO</option>
                                                                    <option value="NA">N/A</option>
                                                                    </select></td>
                                                                    <td><input type="file" id="myFile" name="filename">
                                                                    </td>
                                                                     <td><button type="button" class="btn btn-primary waves-effect">SAVE</button></td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">3</th>
                                                                    <td>Does design brief include the AKDN Green Building Section?</td>
                                                                    <td> <select name="test" id="test">
                                                                    <option value="YES">YES</option>
                                                                    <option value="NO">NO</option>
                                                                    <option value="NA">N/A</option>
                                                                    </select></td>
                                                                    <td><input type="file" id="myFile" name="filename">
                                                                    </td>
                                                                     <td><button type="button" class="btn btn-primary waves-effect">SAVE</button></td>
                                                                    <td></td>
                                                                </tr>
                                                                
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- #END# Basic Table -->
                                </section>

                                 <h2>Planning - Review</h2>
                                <section>
                                        
                                        <!-- Basic Table -->
                                        <div class="row clearfix">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="card">
                                                   
                                                    <div class="body table-responsive">
                                                        <table class="table table-bordered">
                                                            <thead class="header bg-light-green">
                                                                <tr>
                                                                    <th>GBG's Ref</th>
                                                                    <th>Assessment Description</th>
                                                                    <th rowspan="0">Degree of compliance</th>
                                                                    <th align="center" colspan="3"> Assessment </th>
                                                                </tr>
                                                            </thead>
                                                             
                                                            <tbody>
                                                                <tr>
                                                                    <th></th>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td><b>Score</b></td>
                                                                    <td><b>Weightage</b></td>
                                                                    <td><b>Overall Weightage</b></td>
                                                                </tr>
                                                                 <tr>
                                                                    <th></th>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td>45.0</td>
                                                                    <td></td>
                                                                    <td>45%</td>
                                                                </tr>
                                                                
                                                                <tr>
                                                                    <th scope="row">1.1</th>
                                                                    <td>
                                                                    
                                                                    Is a feasibility study conducted by the project team to assess, "Should we build" approach concluded? And has this been submitted, along with the justification to the CSA for review and sign off? </td>
                                                                  
                                                                    <td>
                                                                    YES
                                                                    </td>
                                                                    
                                                                    <td>10</td>
                                                                    <td>10%</td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">1.2</th>
                                                                    <td>As part of feasibility study, is a workshop on environment and climate change and the relevance to the project held?</td>
                                                                    <td>
                                                                    NO
                                                                    </td>

                                                                    <td>0</td>
                                                                    <td>0%</td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">2.1</th>
                                                                    <td>Is the project aligned with the AKAH Habitat Planning Framework?</td>
                                                                    <td>NA</td>

                                                                    <td>10</td>
                                                                    <td>10%</td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">2.2</th>
                                                                    <td>Is the site selected meeting the full scope of technical due diligences?</td>
                                                                    <td> 
                                                                    YES
                                                                    </td>

                                                                    <td>10</td>
                                                                    <td>10%</td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">2.3</th>
                                                                    <td>Is the site selected considered for use of local resources, including energy, water and materials?</td>
                                                                    <td> 
                                                                    YES
                                                                    </select>
                                                                    </td>

                                                                    <td>10</td>
                                                                    <td>10%</td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">3</th>
                                                                    <td>Does design brief include the AKDN Green Building Section?</td>
                                                                    <td> 
                                                                    NA
                                                                    </td>

                                                                    <td>10</td>
                                                                    <td>10%</td>
                                                                    <td></td>
                                                                </tr>
                                                                
                                                                 <tr>
                                                                    <td colspan="6">
                                                                          <div class="body">
                                                                            <div class="button-demo">
                                                                                
                                                                                <button type="button" class="btn btn-primary waves-effect">REVIEWED</button>
                                                                                
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

                                <h2>Design</h2>
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
                                                            <thead class="header bg-light-green">
                                                                <tr>
                                                                    <th>GBG's Ref</th>
                                                                    <th>Assessment Description</th>
                                                                    <th rowspan="0">Degree of compliance</th>
                                                                    <th align="center" colspan="3"> Assessment </th>
                                                                </tr>
                                                            </thead>
                                                             
                                                            <tbody>
                                                                <tr>
                                                                    <th></th>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td><b>Score</b></td>
                                                                    <td><b>Weightage</b></td>
                                                                    <td><b>Overall Weightage</b></td>
                                                                </tr>
                                                                 <tr>
                                                                    <th></th>
                                                                    <td></td>
                                                                    <td></td>
                                                                    <td>45.0</td>
                                                                    <td></td>
                                                                    <td>45%</td>
                                                                </tr>
                                                                
                                                                <tr>
                                                                    <th scope="row">1</th>
                                                                    <td>
                                                                    Is a cross-disciplinary design workshop held?
                                                                    <td>YES</td>
                                                                    
                                                                    <td>10</td>
                                                                    <td>10%</td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">3.1 - 3.14</th>
                                                                    <td>
                                                                    Is the project assessed using EDGE app with various scenarios?, if yes, please provide the EDGE assessment report(s) separately
                                                                    <td>N/A</td>

                                                                    <td>10</td>
                                                                    <td>10%</td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">3.1 - 3.14</th>
                                                                    <td>
                                                                    Does the EDGE assessment of the project meet the minimum criteria established in the green buildings budget guidelines?
                                                                    <td>N/A</td>

                                                                    <td>10</td>
                                                                    <td>10%</td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">3.1</th>
                                                                    <td>
                                                                    What is the ratio of total energy consumption (improved case in KWh/m2/yr) to (base case in KWh/m2/yr) as per EDGE assessment? Please fill in the value in next cell
                                                                    <td>N/A</td>

                                                                    <td>10</td>
                                                                    <td>10%</td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">App.A.5</th>
                                                                    <td>
                                                                    Is "No Generator Use" principle applied in the project design
                                                                    <td>N/A</td>
                                                                    <td>10</td>
                                                                    <td>10%</td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">App.A.6</th>
                                                                    <td>
                                                                    Is COAL used as the source of energy on the site for heating or electricity ?
                                                                    <td>N/A</td>
                                                                    <td>10</td>
                                                                    <td>10%</td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">App.A.4</th>
                                                                    <td>
                                                                    All the heating and cooling needs of the building shall be met without the use of fossil fuel
                                                                    <td>N/A</td>
                                                                    <td>10</td>
                                                                    <td>10%</td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">3.15</th>
                                                                    <td>
                                                                    Does the project have on-site renewable (solar, wind, micro hydro, trigeneration) energy generation?
                                                                    <td>N/A</td>
                                                                    <td>10</td>
                                                                    <td>10%</td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">App.A.7</th>
                                                                    <td>
                                                                    
                                                                    <td>N/A</td>
                                                                    <td>10</td>
                                                                    <td>10%</td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">App.A.7</th>
                                                                    <td>
                                                                    Water closet(s) and urinals in the toilet(s) are  low flow and dual flush respectively
                                                                    <td>N/A</td>
                                                                    <td>10</td>
                                                                    <td>10%</td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">App.A.8</th>
                                                                    <td>
                                                                    Does design include a rainwater harvesting system (RHS) ?
                                                                    <td>N/A</td>
                                                                    <td>10</td>
                                                                    <td>10%</td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">4.3</th>
                                                                    <td>
                                                                    Is a plan for design of deconstruction (DoD) prepared?
                                                                    <td>N/A</td>
                                                                    <td>10</td>
                                                                    <td>10%</td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">6.2</th>
                                                                    <td>
                                                                    Is future climate considered for the design of HVAC and electrical system?
                                                                    <td>N/A</td>
                                                                    <td>10</td>
                                                                    <td>10%</td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">6.3</th>
                                                                    <td>
                                                                    Is a climate change adaptation (CCA) plan created for the project?
                                                                    <td>N/A</td>

                                                                    <td>10</td>
                                                                    <td>10%</td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">App.A.14</th>
                                                                    <td>
                                                                    Is an "Environmental Report" containing all the specified requirements in the GBG generated?
                                                                    <td>N/A</td>
                                                                    <td>10</td>
                                                                    <td>10%</td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <th scope="row">App.A.17</th>
                                                                    <td>
                                                                   Is/are there any EXCEPTION(S) to any of mandatory requirements (highlighted in light red) in this DESIGN section? If "Yes", Please provide the details along with this assessment
                                                                    <td>N/A</td>
                                                                    <td>10</td>
                                                                    <td>10%</td>
                                                                    <td></td>
                                                                </tr>
                                                                
                                                               
                                                            <tr>
                                                                    <th scope="row" colspan="6" class="header bg-light-green">Agency Remarks</th>
                                                                   
                                                                </tr>

                                                                <tr>
                                                                    <td colspan="6">
                                                                           <textarea id="w3review" name="w3review" rows="4" cols="90">Remarks about design indicators
                                                                            </textarea>
                                                                    </td>
                                                                   
                                                                </tr>
                                                                 <tr>
                                                                    <td colspan="6">
                                                                          <div class="body">
                                                                            <div class="button-demo">
                                                                                
                                                                                <button type="button" class="btn btn-primary waves-effect">SAVE DESIGN INDICATORS</button>
                                                                                
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

                                <h2>Construction</h2>
                                <section>
                                    <p>
                                        Quisque at sem turpis, id sagittis diam. Suspendisse malesuada eros posuere mauris vehicula
                                        vulputate. Aliquam sed sem tortor. Quisque sed felis ut mauris feugiat iaculis nec
                                        ac lectus. Sed consequat vestibulum purus, imperdiet varius est pellentesque vitae.
                                        Suspendisse consequat cursus eros, vitae tempus enim euismod non. Nullam ut commodo
                                        tortor.
                                    </p>
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
    //var value = $('#myInputField').val();
    var value = 2;
    if (value === 2) {
        return true;
    } else {
        alert("Please wait until it has been reviewed by higher management..");
        return false;
    }
}

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
