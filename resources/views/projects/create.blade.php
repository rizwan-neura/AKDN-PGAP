@extends('layouts.master')
@section('title')
    @lang('translation.wizard')
@endsection
@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Forms
        @endslot
        @slot('title')
            PGAP - Tool
        @endslot
    @endcomponent

    <div class="row">
        
        <div class="col-xl-12">

            <div class="card">
                <div class="card-header">
                    <h4 class="text-green-heading">Project's Green Building Assurance Performances</h4>
                </div><!-- end card header -->
                <div class="card-body">
                    <form action="#" class="form-steps" autocomplete="off" name="create_project" id="create_project" method="POST">
                        @csrf 
                        <div class="step-arrow-nav mb-4">

                           

                            <ul class="nav nav-pills mb-3" id="wizardSteps">
                                <li class="nav-item">
                                  <a class="nav-link active" data-bs-toggle="tab" href="#step1">Create Project</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link" data-bs-toggle="tab" href="#step2">Executive Summary</a>
                                </li>
                                <li class="nav-item">
                                  <a class="nav-link" data-bs-toggle="tab" href="#step3">Enviromental Requirements checklist</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#step4">Planning</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#step5">Planning Review</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#step6">Design</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-bs-toggle="tab" href="#step7">Construction</a>
                                </li>
                            </ul>
                              

                        </div>

                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="step1">
                              <form class="needs-validation" novalidate>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            
                                            <div class="card-body">
                                                <div class="live-preview">
                                                    <div class="row gy-4">
                                                        <div class="col-xxl-3 col-md-6">
                                                            <div>
                                                                <label for="basiInput" class="form-label">Project Name</label>
                                                                <input type="text" name="project_name" value="{{old('project_name')}}" class="form-control" required>
                                                                <div class="invalid-feedback">Please enter project name</div>
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                        <div class="col-xxl-3 col-md-6">
                                                            <div>
                                                                <label for="cphase" class="form-label">Current Phase</label>
                                                                <select name="phase_id" class="form-select" required>
                                                                    <option value="">-Select Phase-</option>
                                                                    @foreach($projectPhases as $id => $phase_name)
                                                                        <option value="{{ $id }}" {{ old('phase_id') == $id ? 'selected' : '' }}>{{ $phase_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="invalid-feedback">Please select a phase</div>
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                        <div class="col-xxl-3 col-md-6">
                                                            <div>
                                                                <label for="basiInput" class="form-label">Assessment Requirement</label>
                                                                <input type="text" name="assessment_req" id="assessment_req" value="{{old('assessment_req')}}" class="form-control">    
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                        <div class="col-xxl-3 col-md-6">
                                                            <div>
                                                                <label for="cphase" class="form-label">Organization</label>
                                                                <select name="organization_id" id="organization_id" class="form-select" required>
                                                                    <option value="">-Select Organization-</option>
                                                                    @foreach($organizations as $id => $organization_name)
                                                                        <option value="{{ $id }}" {{ old('organization_id') == $id ? 'selected' : '' }}>{{ $organization_name }}</option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="invalid-feedback">Please select a organization</div>
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                        <div class="col-xxl-3 col-md-6">
                                                            <div>
                                                                <label for="date_gpa" class="form-label">Date of GBA* Performance</label>
                                                                <input type="date" class="form-control" id="date_gpa" name="date_gpa" value="{{old('date_gpa')}}" required>
                                                                <div class="invalid-feedback">Please select Date of GBA*</div>
                                                            </div>
                                                        </div>
                                                        
                                                        <!--end col-->
                                                        <div class="col-xxl-3 col-md-6">
                                                            <div>
                                                                <label for="startdate" class="form-label">Project Start Date</label>
                                                                <input type="date" name="start_date" value="{{old('start_date')}}" class="form-control"
                                                                    required>
                                                                    <div class="invalid-feedback">Please select start date</div>
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                        <div class="col-xxl-3 col-md-6">
                                                            <div>
                                                                <label for="enddate" class="form-label">Project End Date</label>
                                                                <input type="date" name="end_date" value="{{old('end_date')}}" class="form-control"
                                                                    required>
                                                                    <div class="invalid-feedback">Please select end date</div>
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end card body -->
                                            <div class="card-body">
                                                <div class="live-preview">
                                                    <div class="row gy-4">
                                                        <div class="col-xxl-3 col-md-6">
                                                            <div>
                                                                <label for="country" class="form-label">Country</label>
                                                                <select class="form-select" name="country_code" style="width: 100%;">
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
                                                        <!--end col-->
                                                        <div class="col-xxl-3 col-md-6">
                                                            <div>
                                                                <label for="region" class="form-label">Region</label>
                                                                <select class="form-select" name="region_code" style="width: 100%;">
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
                                                        <!--end col-->
                                                        <div class="col-xxl-3 col-md-6">
                                                            <div>
                                                                <label for="location" class="form-label">Location  (Site / HO)</label>
                                                                <input type="text" name="location" id="location" value="{{old('location')}}" class="form-control">    
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                        <div class="col-xxl-3 col-md-6">
                                                            <div>
                                                                <label for="coordiates" class="form-label">GPS Coordinates</label>
                                                                <input type="text" name="coordinates" id="coordinates" value="{{old('coordinates')}}" class="form-control"> 
                                                                <div class="invalid-feedback">Please coordinates in decimal</div>   
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                        <div class="col-xxl-3 col-md-6">
                                                            <div>
                                                                <label for="buildingtype" class="form-label">Building Type</label>
                                                                    <select name="type_id" id="type_id" class="form-select" onchange="javascript: ajaxFormGet('create_project','{{ route('projects.getBuildingSubTypes') }}','sub_type_id');return false;" required>
                                                                        <option value="">-Select Type-</option>
                                                                        @foreach($buildingTypes as $id => $type_name)
                                                                            <option value="{{ $id }}" {{ old('type_id') == $id ? 'selected' : '' }}>{{ $type_name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <div class="invalid-feedback">Please select building type</div>
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                        <div class="col-xxl-3 col-md-6">
                                                            <div>
                                                                <label for="subtype" class="form-label">Sub-Type</label>
                                                                <select name="sub_type_id" id="sub_type_id" class="form-select" required>
                                                                    <option value="">Select Sub-type</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                        <div class="col-xxl-3 col-md-6">
                                                            <div>
                                                                <label for="conscost" class="form-label">Construction Cost (USD)
                                                                    </label>
                                                                    <input type="number" name="construction_cost" id="construction_cost" value="{{old('construction_cost')}}" class="form-control" placeholder="Exp 9999.99" required>
                                                                    <div class="invalid-feedback">Please enter construction cost</div>
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                        <div class="col-xxl-3 col-md-6">
                                                            <div>
                                                                <label for="costphase" class="form-label">Construction Cost @
                                                                    </label>
                                                                    <select name="cost_phasex" class="form-select">
                                                                        <option value="">Planning</option>
                                                                        <option value="">Design</option>
                                                                        <option value="">Construction</option>
                                                                        </select>
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                        <div class="col-xxl-6 col-md-6">
                                                            <div>
                                                                <label for="exampleInputpassword" class="form-label">Mandatory Requirement
                                                                </label>
                                                                <input type="text" readonly name="requirements" id="requirements" value="{{old('requirements')}}" class="form-control">
                                                            </div>
                                                        </div>
                                                        <!--end col-->
                                                        <input type="hidden" name="step" value="0">
                                                        <input type="hidden" name="min_cost" id="min_cost" value="{{ $thresholds->min_value }}">
                                                        <input type="hidden" name="max_cost"  id="max_cost" value="{{ $thresholds->max_value }}">
                                                        <input type="hidden" name="output_1" id="output_1" value="{{ $thresholds->output_1 }}">
                                                        <input type="hidden" name="output_2" id="output_2" value="{{ $thresholds->output_2 }}">
                                                        <input type="hidden" name="output_3" id="output_3" value="{{ $thresholds->output_3 }}">
                                                    </div>
                                                    <!--end row-->
                                                </div>
                                            </div>
                                            <!-- end card body -->
                                            
                                        </div>
                                        <!-- end card -->
                                    </div>
                                    <!--end col-->
                                </div>
                                
                                <div class="text-start">
                                    <button type="button" class="btn btn-success"
                                    onclick="saveTabData('step1', '{{ route('projects.store') }}')">Create Project</button>
                                <button type="button" class="btn btn-primary next-step" data-next="#step2">Next
                                    
                                </button>
                                </div>    
                            </form>
                            </div>
                          
                            <div class="tab-pane fade" id="step2">
                              <form class="needs-validation" novalidate>
                                    <div class="col-xl-12 col-md-12">
                                            <blockquote class="blockquote custom-blockquote blockquote-info rounded material-shadow mb-0">
                                                <p class="text-body mb-2">Kindly ensure the previous steps are completed before proceeding.</p>
                                            </blockquote>
                                    </div>
                                <div style="margin-top: 30px;"></div>
                                <button type="button" class="btn btn-secondary prev-step" data-prev="#step1">Previous</button>
                                <button type="button" class="btn btn-primary next-step" data-next="#step3">Next</button>
                              </form>
                            </div>
                          
                            <div class="tab-pane fade" id="step3">
                                <form class="needs-validation" novalidate>
                                    <div class="col-xl-12 col-md-12">
                                        <blockquote class="blockquote custom-blockquote blockquote-info rounded material-shadow mb-0">
                                            <p class="text-body mb-2">Kindly ensure the previous steps are completed before proceeding.</p>
                                        </blockquote>
                                    </div>
                                    <div style="margin-top: 30px;"></div>
                                    <button type="button" class="btn btn-secondary prev-step" data-prev="#step2">Previous</button>
                                    <button type="button" class="btn btn-primary next-step" data-next="#step4">Next</button>
                                  </form>
                            </div>
                            <div class="tab-pane fade" id="step4">
                                <form class="needs-validation" novalidate>
                                    <div class="col-xl-12 col-md-12">
                                        <blockquote class="blockquote custom-blockquote blockquote-info rounded material-shadow mb-0">
                                            <p class="text-body mb-2">Kindly ensure the previous steps are completed before proceeding.</p>
                                        </blockquote>
                                    </div>
                                    <div style="margin-top: 30px;"></div>
                                    <button type="button" class="btn btn-secondary prev-step" data-prev="#step3">Previous</button>
                                    <button type="button" class="btn btn-primary next-step" data-next="#step5">Next</button>
                                  </form>
                            </div>
                            <div class="tab-pane fade" id="step5">
                                <form class="needs-validation" novalidate>
                                    <div class="col-xl-12 col-md-12">
                                        <blockquote class="blockquote custom-blockquote blockquote-info rounded material-shadow mb-0">
                                            <p class="text-body mb-2">Kindly ensure the previous steps are completed before proceeding.</p>
                                        </blockquote>
                                    </div>
                                    <div style="margin-top: 30px;"></div>
                                    <button type="button" class="btn btn-secondary prev-step" data-prev="#step4">Previous</button>
                                    <button type="button" class="btn btn-primary next-step" data-next="#step6">Next</button>
                                  </form>
                            </div>
                            <div class="tab-pane fade" id="step6">
                                <form class="needs-validation" novalidate>
                                    <div class="col-xl-12 col-md-12">
                                        <blockquote class="blockquote custom-blockquote blockquote-info rounded material-shadow mb-0">
                                            <p class="text-body mb-2">Kindly ensure the previous steps are completed before proceeding.</p>
                                        </blockquote>
                                    </div>
                                    <div style="margin-top: 30px;"></div>
                                    <button type="button" class="btn btn-secondary prev-step" data-prev="#step5">Previous</button>
                                    <button type="button" class="btn btn-primary next-step" data-next="#step7">Next</button>
                                  </form>
                            </div>
                            <div class="tab-pane fade" id="step7">
                                <form class="needs-validation" novalidate>
                                    <div class="col-xl-12 col-md-12">
                                        <blockquote class="blockquote custom-blockquote blockquote-info rounded material-shadow mb-0">
                                            <p class="text-body mb-2">Kindly ensure the previous steps are completed before proceeding.</p>
                                        </blockquote>
                                    </div>
                                    <div style="margin-top: 30px;"></div>
                                    <button type="button" class="btn btn-secondary prev-step" data-prev="#step6">Previous</button>
                                    
                                  </form>
                            </div>
                          </div>
                          
                        <!-- end tab content -->
                    </form>
                </div>
                <!-- end card body -->
            </div>
            <!-- end card -->
        </div>
        <!-- end col -->
    </div><!-- end row -->

@endsection
@section('script')
    <script src="{{ URL::asset('build/js/pages/form-wizard.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
