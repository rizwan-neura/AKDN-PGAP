<x-tab-layout :project="$project">
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-body py-0">
                                                
                                                <div class="live-preview">
                                                    <div class="table-responsive">
                                                        <table class="table table-bordered align-middle table-nowrap mb-0">
                                                            <thead>
                                                                <tr class="assessment-header">
                                                                    <th style="width: 3%;" class="text-center py-1">Ref.</th>
                                                                    <th width="60%" class="py-1">Assessment Description</th>
                                                                    <th style="width: 10%; word-wrap: break-word; white-space: normal;" class="text-center py-1">Compliance</th>
                                                                    <th width="15%" class="text-center py-1">Upload</th>
                                                                    
                                                                    <th width="12%" class="text-center py-1">Action</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                            
                                                        @php
                                                        $assessment1 = collect($planningAssessment)->firstWhere('indicator_id', 1);
                                                        $assessment2 = collect($planningAssessment)->firstWhere('indicator_id', 2);
                                                        $assessment3 = collect($planningAssessment)->firstWhere('indicator_id', 3);
                                                        $assessment4 = collect($planningAssessment)->firstWhere('indicator_id', 4);
                                                        $assessment5 = collect($planningAssessment)->firstWhere('indicator_id', 5);
                                                        $assessment6 = collect($planningAssessment)->firstWhere('indicator_id', 6);
                                                        @endphp
                                                        <form id="planning_form_1" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="status-message text-success text-end"></div>
                                                            <div class="d-flex border p-2 align-items-center flex-wrap mb-2" style="border-radius: 5px;">

                                                                <!-- ID -->
                                                                <div class="flex-shrink-0 text-center" style="width: 3%;">
                                                                    1.1
                                                                </div>
                                                            
                                                                <!-- Checklist Name -->
                                                                <div class="flex-grow-1 px-2" style="width: 60%; word-wrap: break-word; white-space: normal;" >
                                                                    Is a feasibility study conducted by the project team to assess, "Should we build" approach concluded? And has this been submitted, along with the justification to the CSA for review and sign off?
                                                                    <span class="required-star">*</span>
                                                                    
                                                                </div>
                                                            
                                                                <!-- Status Select -->
                                                                <div class="px-2 align-items-center" style="width: 10%;">
                                                                    <select name="compliance" class="form-select">
                                                                        <option value="">Choose</option>
                                                                        <option value="2" {{ $assessment1 && $assessment1->compliances_id == 2 ? 'selected' : '' }}>YES</option>
                                                                        <option value="1" {{ $assessment1 && $assessment1->compliances_id == 1 ? 'selected' : '' }}>NO</option>
                                                                        <option value="3" {{ $assessment1 && $assessment1->compliances_id == 3 ? 'selected' : '' }}>N/A</option>
                                                                    </select>
                                                                
                                                                </div>
                                                            
                                                                <!-- File Input -->
                                                                <div class="px-2 align-items-center" style="width: 15%;">
                                                                    <input type="file" class="form-control file-input" name="planning_uploads">
                                                                </div>
                                                            
                                                                <!-- Start: Uploaded File Info -->
                                                                <div class="px-2 d-flex align-items-center justify-content-start gap-2" style="width: 12%;">

                                                                    <!-- Save Button: Left Side -->
                                                                    <div>
                                                                        <button class="btn btn-green-heading btn-sm"
                                                                                type="button"
                                                                                onclick="savePlanningValues('planning_form_1', '{{ route('projects.savePlanningAssessment') }}' , '{{ route('projects.deletePlanningFile') }}'); return false;">
                                                                            Save
                                                                        </button>
                                                                    </div>
                                                                    <div id="fileAfterServer" >
                                                                        <!-- View / Delete: Right Side -->
                                                                            @if(!empty($assessment1->file_path))
                                                                            
                                                                                <div class="d-flex gap-1 uploaded-file">
                                                                    
                                                                                    <!-- View File -->
                                                                                    <a href="{{ asset('storage/' . $assessment1->file_path) }}"
                                                                                    target="_blank"
                                                                                    class="btn btn-sm btn-soft-primary"
                                                                                    data-bs-toggle="tooltip"
                                                                                    data-bs-placement="top"
                                                                                    title="View File"
                                                                                    aria-label="View File">
                                                                                        <i class="ri-eye-line"></i>
                                                                                    </a>
                                                                    
                                                                                    <!-- Delete File -->
                                                                                    <button type="button"
                                                                                            class="btn btn-sm btn-soft-danger"
                                                                                            data-bs-toggle="tooltip"
                                                                                            data-bs-placement="top"
                                                                                            title="Delete File"
                                                                                            aria-label="Delete File"
                                                                                            onclick="deletePlanningFile('planning_form_1', '{{ route('projects.deletePlanningFile') }}' ); return false;">
                                                                                        <i class="ri-delete-bin-line"></i>
                                                                                    </button>
                                                                    
                                                                                </div>
                                                                            @endif
                                                                    </div>
                                                                </div>
                                                                <!-- End: Uploaded File Info -->
                                                                
                                                            </div>
                                                                <input type="hidden" value="1" name="indicator_id">
                                                                <input type="hidden" value="{{ $project->id }}" name="updatedProjectId">
                                                        </form>
                                                        <form id="planning_form_2" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="status-message text-success text-end"></div>
                                                            <div class="d-flex border p-2 align-items-center flex-wrap mb-2" style="border-radius: 5px;">

                                                                <!-- ID -->
                                                                <div class="flex-shrink-0 text-center" style="width: 3%;">
                                                                    1.2
                                                                </div>
                                                            
                                                                <!-- Checklist Name -->
                                                                <div class="flex-grow-1 px-2" style="width: 60%; word-wrap: break-word; white-space: normal;" >
                                                                    As part of feasibility study, is a workshop on environment and climate change and the relevance to the project held?
                                                                </div>
                                                            
                                                                <!-- Status Select -->
                                                                <div class="px-2" style="width: 10%;">
                                                                    <select name="compliance" class="form-select">
                                                                        <option value="">Choose</option>
                                                                        <option value="2" {{ $assessment2 && $assessment2->compliances_id == 2 ? 'selected' : '' }}>YES</option>
                                                                        <option value="1" {{ $assessment2 && $assessment2->compliances_id == 1 ? 'selected' : '' }}>NO</option>
                                                                        <option value="3" {{ $assessment2 && $assessment2->compliances_id == 3 ? 'selected' : '' }}>N/A</option>
                                                                    </select>
                                                                
                                                                </div>
                                                            
                                                                <!-- File Input -->
                                                                <div class="px-2" style="width: 15%;">
                                                                    <input type="file" class="form-control file-input" name="planning_uploads">
                                                                </div>
                                                            
                                                                <!-- Start: Uploaded File Info -->
                                                                <div class="px-2 d-flex align-items-center justify-content-start gap-2" style="width: 12%;">

                                                                    <!-- Save Button: Left Side -->
                                                                    <div>
                                                                        <button class="btn btn-green-heading btn-sm"
                                                                                type="button"
                                                                                onclick="savePlanningValues('planning_form_2', '{{ route('projects.savePlanningAssessment') }}' , '{{ route('projects.deletePlanningFile') }}'); return false;">
                                                                            Save
                                                                        </button>
                                                                    </div>
                                                                    <div id="fileAfterServer" >
                                                                        <!-- View / Delete: Right Side -->
                                                                        @if(!empty($assessment2->file_path))
                                                                        
                                                                            <div class="d-flex gap-1 uploaded-file">
                                                                
                                                                                <!-- View File -->
                                                                                <a href="{{ asset('storage/' . $assessment2->file_path) }}"
                                                                                target="_blank"
                                                                                class="btn btn-sm btn-soft-primary"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-placement="top"
                                                                                title="View File"
                                                                                aria-label="View File">
                                                                                    <i class="ri-eye-line"></i>
                                                                                </a>
                                                                
                                                                                <!-- Delete File -->
                                                                                <button type="button"
                                                                                        class="btn btn-sm btn-soft-danger"
                                                                                        data-bs-toggle="tooltip"
                                                                                        data-bs-placement="top"
                                                                                        title="Delete File"
                                                                                        aria-label="Delete File"
                                                                                        onclick="deletePlanningFile('planning_form_2', '{{ route('projects.deletePlanningFile') }}' ); return false;">
                                                                                    <i class="ri-delete-bin-line"></i>
                                                                                </button>
                                                                
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <!-- End: Uploaded File Info -->
                                                                
                                                                
                                                                                       
                                                            </div>
                                                                <input type="hidden" value="2" name="indicator_id">
                                                                <input type="hidden" value="{{ $project->id }}" name="updatedProjectId">
                                                        </form>
                                                        <form id="planning_form_3" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="status-message text-success text-end"></div>
                                                            <div class="d-flex border p-2 align-items-center flex-wrap mb-2" style="border-radius: 5px;">

                                                                <!-- ID -->
                                                                <div class="flex-shrink-0 text-center" style="width: 3%;">
                                                                    2.1
                                                                </div>
                                                            
                                                                <!-- Checklist Name -->
                                                                <div class="flex-grow-1 px-2" style="width: 60%; word-wrap: break-word; white-space: normal;" >
                                                                    Is the project aligned with the AKAH Habitat Planning Framework?
                                                                </div>
                                                            
                                                                <!-- Status Select -->
                                                                <div class="px-2" style="width: 10%;">
                                                                    <select name="compliance" class="form-select">
                                                                        <option value="">Choose</option>
                                                                        <option value="2" {{ $assessment3 && $assessment3->compliances_id == 2 ? 'selected' : '' }}>YES</option>
                                                                        <option value="1" {{ $assessment3 && $assessment3->compliances_id == 1 ? 'selected' : '' }}>NO</option>
                                                                        <option value="3" {{ $assessment3 && $assessment3->compliances_id == 3 ? 'selected' : '' }}>N/A</option>
                                                                    </select>
                                                                
                                                                </div>
                                                            
                                                                <!-- File Input -->
                                                                <div class="px-2" style="width: 15%;">
                                                                    <input type="file" class="form-control file-input" name="planning_uploads">
                                                                </div>
                                                            
                                                                <!-- Start: Uploaded File Info -->
                                                                <div class="px-2 d-flex align-items-center justify-content-start gap-2" style="width: 12%;">

                                                                    <!-- Save Button: Left Side -->
                                                                    <div>
                                                                        <button class="btn btn-green-heading btn-sm"
                                                                                type="button"
                                                                                onclick="savePlanningValues('planning_form_3', '{{ route('projects.savePlanningAssessment') }}' , '{{ route('projects.deletePlanningFile') }}'); return false;">
                                                                            Save
                                                                        </button>
                                                                    </div>
                                                                    <div id="fileAfterServer" >
                                                                        <!-- View / Delete: Right Side -->
                                                                        @if(!empty($assessment3->file_path))
                                                                        
                                                                            <div class="d-flex gap-1 uploaded-file">
                                                                
                                                                                <!-- View File -->
                                                                                <a href="{{ asset('storage/' . $assessment3->file_path) }}"
                                                                                target="_blank"
                                                                                class="btn btn-sm btn-soft-primary"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-placement="top"
                                                                                title="View File"
                                                                                aria-label="View File">
                                                                                    <i class="ri-eye-line"></i>
                                                                                </a>
                                                                
                                                                                <!-- Delete File -->
                                                                                <button type="button"
                                                                                        class="btn btn-sm btn-soft-danger"
                                                                                        data-bs-toggle="tooltip"
                                                                                        data-bs-placement="top"
                                                                                        title="Delete File"
                                                                                        aria-label="Delete File"
                                                                                        onclick="deletePlanningFile('planning_form_3', '{{ route('projects.deletePlanningFile') }}' ); return false;">
                                                                                    <i class="ri-delete-bin-line"></i>
                                                                                </button>
                                                                
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <!-- End: Uploaded File Info -->
                                                            
                                                            </div>
                                                                <input type="hidden" value="3" name="indicator_id">
                                                                <input type="hidden" value="{{ $project->id }}" name="updatedProjectId">
                                                        </form>
                                                        <form id="planning_form_4" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="status-message text-success text-end"></div>
                                                            <div class="d-flex border p-2 align-items-center flex-wrap mb-2" style="border-radius: 5px;">

                                                                <!-- ID -->
                                                                <div class="flex-shrink-0 text-center" style="width: 3%;">
                                                                    2.2
                                                                </div>
                                                            
                                                                <!-- Checklist Name -->
                                                                <div class="flex-grow-1 px-2" style="width: 60%; word-wrap: break-word; white-space: normal;" >
                                                                    Is the site selected meeting the full scope of technical due diligences?
                                                                    <span class="required-star">*</span>
                                                                </div>
                                                            
                                                                <!-- Status Select -->
                                                                <div class="px-2" style="width: 10%;">
                                                                    <select name="compliance" class="form-select">
                                                                        <option value="">Choose</option>
                                                                        <option value="1" {{ $assessment4 && $assessment4->compliances_id == 1 ? 'selected' : '' }}>NO</option>
                                                                        <option value="4" {{ $assessment4 && $assessment4->compliances_id == 4 ? 'selected' : '' }}>HVRA conducted (Risk - relatively safe)</option>
                                                                        <option value="5" {{ $assessment4 && $assessment4->compliances_id == 5 ? 'selected' : '' }}>HVRA conducted (Risk - Low)</option>
                                                                        <option value="6" {{ $assessment4 && $assessment4->compliances_id == 6 ? 'selected' : '' }}>HVRA conducted (Risk - Medium)</option>
                                                                        <option value="7" {{ $assessment4 && $assessment4->compliances_id == 7 ? 'selected' : '' }}>HVRA conducted (Risk - High)</option>
                                                                    </select>
                                                                
                                                                </div>
                                                            
                                                                <!-- File Input -->
                                                                <div class="px-2" style="width: 15%;">
                                                                    <input type="file" class="form-control file-input" name="planning_uploads">
                                                                </div>
                                                            
                                                                <!-- Start: Uploaded File Info -->
                                                                <div class="px-2 d-flex align-items-center justify-content-start gap-2" style="width: 12%;">

                                                                    <!-- Save Button: Left Side -->
                                                                    <div>
                                                                        <button class="btn btn-green-heading btn-sm"
                                                                                type="button"
                                                                                onclick="savePlanningValues('planning_form_4', '{{ route('projects.savePlanningAssessment') }}' , '{{ route('projects.deletePlanningFile') }}'); return false;">
                                                                            Save
                                                                        </button>
                                                                    </div>
                                                                    <div id="fileAfterServer" >
                                                                        <!-- View / Delete: Right Side -->
                                                                        @if(!empty($assessment4->file_path))
                                                                        
                                                                            <div class="d-flex gap-1 uploaded-file">
                                                                
                                                                                <!-- View File -->
                                                                                <a href="{{ asset('storage/' . $assessment4->file_path) }}"
                                                                                target="_blank"
                                                                                class="btn btn-sm btn-soft-primary"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-placement="top"
                                                                                title="View File"
                                                                                aria-label="View File">
                                                                                    <i class="ri-eye-line"></i>
                                                                                </a>
                                                                
                                                                                <!-- Delete File -->
                                                                                <button type="button"
                                                                                        class="btn btn-sm btn-soft-danger"
                                                                                        data-bs-toggle="tooltip"
                                                                                        data-bs-placement="top"
                                                                                        title="Delete File"
                                                                                        aria-label="Delete File"
                                                                                        onclick="deletePlanningFile('planning_form_4', '{{ route('projects.deletePlanningFile') }}' ); return false;">
                                                                                    <i class="ri-delete-bin-line"></i>
                                                                                </button>
                                                                
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <!-- End: Uploaded File Info -->
                                                            
                                                            </div>
                                                                <input type="hidden" value="4" name="indicator_id">
                                                                <input type="hidden" value="{{ $project->id }}" name="updatedProjectId">
                                                        </form>
                                                        <form id="planning_form_5" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="status-message text-success text-end"></div>
                                                            <div class="d-flex border p-2 align-items-center flex-wrap mb-2" style="border-radius: 5px;">

                                                                <!-- ID -->
                                                                <div class="flex-shrink-0 text-center" style="width: 3%;">
                                                                    2.3
                                                                </div>
                                                            
                                                                <!-- Checklist Name -->
                                                                <div class="flex-grow-1 px-2" style="width: 60%; word-wrap: break-word; white-space: normal;" >
                                                                    Is the site selected considered for use of local resources, including energy, water and materials?
                                                                </div>
                                                            
                                                                <!-- Status Select -->
                                                                <div class="px-2" style="width: 10%;">
                                                                    <select name="compliance" class="form-select">
                                                                        <option value="">Choose</option>
                                                                        <option value="1" {{ $assessment5 && $assessment5->compliances_id == 1 ? 'selected' : '' }}>NO</option>
                                                                        <option value="8" {{ $assessment5 && $assessment5->compliances_id == 8 ? 'selected' : '' }}>Up to 20% of the required material is locally available</option>
                                                                        <option value="9" {{ $assessment5 && $assessment5->compliances_id == 9 ? 'selected' : '' }}>20% to 30% of the required material is locally available</option>
                                                                        <option value="10" {{ $assessment5 && $assessment5->compliances_id == 10 ? 'selected' : '' }}>30% to 50% of the required material is locally available</option>
                                                                        <option value="11" {{ $assessment5 && $assessment5->compliances_id == 11 ? 'selected' : '' }}>More than 50% of the required material is locally available</option>
                                                                    </select>
                                                                
                                                                </div>
                                                            
                                                                <!-- File Input -->
                                                                <div class="px-2" style="width: 15%;">
                                                                    <input type="file" class="form-control file-input" name="planning_uploads">
                                                                </div>
                                                            
                                                                <!-- Start: Uploaded File Info -->
                                                                <div class="px-2 d-flex align-items-center justify-content-start gap-2" style="width: 12%;">

                                                                    <!-- Save Button: Left Side -->
                                                                    <div>
                                                                        <button class="btn btn-green-heading btn-sm"
                                                                                type="button"
                                                                                onclick="savePlanningValues('planning_form_5', '{{ route('projects.savePlanningAssessment') }}' , '{{ route('projects.deletePlanningFile') }}'); return false;">
                                                                            Save
                                                                        </button>
                                                                    </div>
                                                                    <div id="fileAfterServer" >
                                                                        <!-- View / Delete: Right Side -->
                                                                        @if(!empty($assessment5->file_path))
                                                                        
                                                                            <div class="d-flex gap-1 uploaded-file">
                                                                
                                                                                <!-- View File -->
                                                                                <a href="{{ asset('storage/' . $assessment5->file_path) }}"
                                                                                target="_blank"
                                                                                class="btn btn-sm btn-soft-primary"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-placement="top"
                                                                                title="View File"
                                                                                aria-label="View File">
                                                                                    <i class="ri-eye-line"></i>
                                                                                </a>
                                                                
                                                                                <!-- Delete File -->
                                                                                <button type="button"
                                                                                        class="btn btn-sm btn-soft-danger"
                                                                                        data-bs-toggle="tooltip"
                                                                                        data-bs-placement="top"
                                                                                        title="Delete File"
                                                                                        aria-label="Delete File"
                                                                                        onclick="deletePlanningFile('planning_form_5', '{{ route('projects.deletePlanningFile') }}' ); return false;">
                                                                                    <i class="ri-delete-bin-line"></i>
                                                                                </button>
                                                                
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <!-- End: Uploaded File Info -->
                                                            
                                                            </div>
                                                                <input type="hidden" value="5" name="indicator_id">
                                                                <input type="hidden" value="{{ $project->id }}" name="updatedProjectId">
                                                        </form>
                                                        <form id="planning_form_6" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            <div class="status-message text-success text-end"></div>
                                                            <div class="d-flex align-items-center flex-wrap">

                                                                <!-- ID -->
                                                                <div class="flex-shrink-0 text-center" style="width: 3%;">
                                                                    3
                                                                </div>
                                                            
                                                                <!-- Checklist Name -->
                                                                <div class="flex-grow-1 px-2" style="width: 60%; word-wrap: break-word; white-space: normal;" >
                                                                    Does design brief include the AKDN Green Building Section?
                                                                    <span class="required-star">*</span>
                                                                </div>
                                                            
                                                                <!-- Status Select -->
                                                                <div class="px-2" style="width: 10%;">
                                                                    <select name="compliance" class="form-select">
                                                                        <option value="">Choose</option>
                                                                        <option value="2" {{ $assessment6 && $assessment6->compliances_id == 2 ? 'selected' : '' }}>YES</option>
                                                                        <option value="1" {{ $assessment6 && $assessment6->compliances_id == 1 ? 'selected' : '' }}>NO</option>
                                                                        <option value="3" {{ $assessment6 && $assessment6->compliances_id == 3 ? 'selected' : '' }}>N/A</option>
                                                                    </select>
                                                                
                                                                </div>
                                                            
                                                                <!-- File Input -->
                                                                <div class="px-2" style="width: 15%;">
                                                                    <input type="file" class="form-control file-input" name="planning_uploads">
                                                                </div>
                                                            
                                                                <!-- Start: Uploaded File Info -->
                                                                <div class="px-2 d-flex align-items-center justify-content-start gap-2" style="width: 12%;">

                                                                    <!-- Save Button: Left Side -->
                                                                    <div>
                                                                        <button class="btn btn-green-heading btn-sm"
                                                                                type="button"
                                                                                onclick="savePlanningValues('planning_form_6', '{{ route('projects.savePlanningAssessment') }}' , '{{ route('projects.deletePlanningFile') }}'); return false;">
                                                                            Save
                                                                        </button>
                                                                    </div>
                                                                    <div id="fileAfterServer" >
                                                                        <!-- View / Delete: Right Side -->
                                                                        @if(!empty($assessment6->file_path))
                                                                        
                                                                            <div class="d-flex gap-1 uploaded-file">
                                                                
                                                                                <!-- View File -->
                                                                                <a href="{{ asset('storage/' . $assessment6->file_path) }}"
                                                                                target="_blank"
                                                                                class="btn btn-sm btn-soft-primary"
                                                                                data-bs-toggle="tooltip"
                                                                                data-bs-placement="top"
                                                                                title="View File"
                                                                                aria-label="View File">
                                                                                    <i class="ri-eye-line"></i>
                                                                                </a>
                                                                
                                                                                <!-- Delete File -->
                                                                                <button type="button"
                                                                                        class="btn btn-sm btn-soft-danger"
                                                                                        data-bs-toggle="tooltip"
                                                                                        data-bs-placement="top"
                                                                                        title="Delete File"
                                                                                        aria-label="Delete File"
                                                                                        onclick="deletePlanningFile('planning_form_6', '{{ route('projects.deletePlanningFile') }}' ); return false;">
                                                                                    <i class="ri-delete-bin-line"></i>
                                                                                </button>
                                                                
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <!-- End: Uploaded File Info -->
                                                            
                                                            </div>
                                                                <input type="hidden" value="6" name="indicator_id">
                                                                <input type="hidden" value="{{ $project->id }}" name="updatedProjectId">
                                                        </form>
                                                   
                                                           
                                                    </div>
                                                </div>
                                                <div class="d-flex align-items-start gap-3 mt-0 py-3">
                                                    <button type="button" class="btn btn-light btn-sm btn-label prev-step"
                                                    data-prev="#step1" onclick="window.location.href='{{ route('projects.checklist', $project->id) }}'"><i
                                                        class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Back to Checklist</button>
                                                    
                                                        <button type="button" class="btn btn-primary btn-sm btn-label right ms-auto next-step"
                                                        data-next="#step2" onclick="window.location.href='{{ route('projects.planningreview', $project->id) }}'" ><i
                                                                class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Go to Review</button>
                                                </div> 
                                               
                                            </div><!-- end card-body -->
                                        </div><!-- end card -->
                                    </div><!-- end col -->
                                    
                                     
</x-tab-layout>
