<x-tab-layout :project="$project">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Project Design Phase</h4>
                
            </div><!-- end card header -->
            
            <div class="card-body">
                
                <div class="live-preview">
                    
                    <div class="table-responsive">
                        <form id="design_cost_form" method="POST" class="mb-0">
                            @csrf   
                            <div class="status-message text-success mt-2" style="margin-left: 800px;"></div> 
                            <table class="table align-middle table-nowrap mb-0">
                                <thead>
                                    <tr >
                                        <th style="width: 5%; word-wrap: break-word; white-space: normal;"></th>
                                        <th  class="text-end align-middle">Is the construction cost (USD) changed at design phase:
                                            <i style="color: red;"><b>( * )</b></i>
                                        
                                        <th width="10%"><input type="text" name="cost_at_design" id="cost_at_design" class="form-control" value="{{ old('cost_at_design', $project->cost_at_design) }}">
                                        </th>
                                        <th width="5%" class="align-middle"><button class="btn btn-success btn-sm" type="button"
                                            onclick="updateCost('design_cost_form', '{{ route('projects.updateCost') }}' ); return false;">
                                            UPDATE
                                        </button></th>
                                    </tr>
                                </thead>
                            </table>
                            <input type="hidden" value="cost_at_design" name="cost_phase">
                            <input type="hidden" value="{{ $project->id }}" name="updatedProjectId">
                        </form>
                        <table class="table table-bordered align-middle table-nowrap mb-0">
                            <thead>
                                <tr class="table-primary">
                                    <th style="width: 5%; word-wrap: break-word; white-space: normal;">GBG's Ref</th>
                                    <th width="55%">Assessment Description</th>
                                    <th style="width: 10%; word-wrap: break-word; white-space: normal;">Degree of Compliance</th>
                                    <th width="15%">Upload</th>
                                    <th width="10%">File</th>
                                    <th width="5%">Action</th>
                                </tr>
                            </thead>
                        </table>
                        @foreach ($designAssessmentInfo as $row)
                        <form id="design_form_{{ $row->id }}" method="POST" enctype="multipart/form-data" class="mb-0">
                            @csrf
                            <div class="status-message text-success mt-2" style="margin-left: 800px;"></div>
                        
                            <table class="table table-bordered align-middle">
                                <tr>
                                    <!-- Ref No -->
                                    <td style="width: 5%; text-align: center;">
                                        {{ $row->ref_no }}
                                    </td>
                        
                                    <!-- Indicator Name -->
                                    <td style="width: 55%;">
                                        {{ $row->indicator_name }}
                                        @if($row->is_mandatory === 1)
                                            <i style="color: red;"><b>(*)</b></i>
                                        @endif
                                    </td>
                        
                                    <!-- Compliance Dropdown -->
                                    <td style="width: 10%;">
                                        <select class="form-select" name="compliance">
                                            <option value="">Choose</option>
                        
                                            @if ($row->id === 4)
                                                <option value="2" @selected(old('compliance', $row->compliances_id) == '2')>YES</option>
                                                <option value="4" @selected(old('compliance', $row->compliances_id) == '4')>No but it is upto 30% more than the aspirational value</option>
                                                <option value="5" @selected(old('compliance', $row->compliances_id) == '5')>No but it is 30% to 50% more than the aspirational value</option>
                                                <option value="6" @selected(old('compliance', $row->compliances_id) == '6')>No but it is 50% to 70% more than the aspirational value</option>
                                                <option value="7" @selected(old('compliance', $row->compliances_id) == '7')>No but it is 70% more than the aspirational value</option>
                                            
                                            @elseif ($row->id === 5)
                                                <option value="2" @selected(old('compliance', $row->compliances_id) == '2')>YES</option>
                                                <option value="8" @selected(old('compliance', $row->compliances_id) == '8')>No but a generator is suggested based on < 5% use of normal operations </option>
                                                <option value="1" @selected(old('compliance', $row->compliances_id) == '1')>NO</option>
                                            
                                            @elseif ($row->id === 8)
                                                <option value="1" @selected(old('compliance', $row->compliances_id) == '1')>NO</option>
                                                <option value="9" @selected(old('compliance', $row->compliances_id) == '9')>Yes, the on-site generation is > 80% <= 100%</option>
                                                <option value="10" @selected(old('compliance', $row->compliances_id) == '10')>Yes, the on-site generation is > 50% < 80%</option>
                                                <option value="11" @selected(old('compliance', $row->compliances_id) == '11')>Yes, the on-site generation is > 30% < 50%</option>
                                                <option value="12" @selected(old('compliance', $row->compliances_id) == '12')>Yes, the on-site generation is > 30% < 50%</option>
                                                <option value="13" @selected(old('compliance', $row->compliances_id) == '13')>Yes, the on-site generation is > 15% < 30%</option>
                        
                                            @else
                                                <option value="2" @selected(old('compliance', $row->compliances_id) == '2')>YES</option>
                                                <option value="1" @selected(old('compliance', $row->compliances_id) == '1')>NO</option>
                                                <option value="3" @selected(old('compliance', $row->compliances_id) == '3')>N/A</option>
                                            @endif
                                        </select>
                                    </td>
                        
                                    <!-- File Input -->
                                    <td style="width: 15%;">
                                        <input type="file" class="form-control file-input" name="design_uploads">
                                    </td>
                        
                                    <!-- Uploaded File Info -->
                                    <td style="width: 10%;" id="fileAfterServer">
                                        @if(!empty($row->file_path))
                                            <div class="d-flex flex-column uploaded-file mt-2">
                                                <a href="{{ asset('storage/' . $row->file_path) }}" target="_blank" class="text-primary d-inline-flex align-items-center">
                                                    <i class="mdi mdi-file-document-outline me-1"></i> View File
                                                </a>
                                                <div style="height: 8px;"></div>
                                                <button type="button" class="btn btn-link text-danger p-0 d-inline-flex align-items-center"
                                                    onclick="deleteDesignFile('design_form_{{ $row->id }}', '{{ route('projects.deleteDesignFile') }}' ); return false;">
                                                    <i class="mdi mdi-delete-outline me-1"></i> Delete
                                                </button>
                                            </div>
                                        @endif
                                    </td>
                        
                                    <!-- Save Button -->
                                    <td style="width: 5%;">
                                        <button class="btn btn-success btn-sm" type="button"
                                            onclick="saveDesignValues('design_form_{{ $row->id }}', '{{ route('projects.saveDesignAssessment') }}', '{{ route('projects.deleteDesignFile') }}'); return false;">
                                            SAVE
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        
                            <!-- Hidden Fields -->
                            <input type="hidden" value="{{ $row->id }}" name="indicator_id">
                            <input type="hidden" value="{{ $project->id }}" name="updatedProjectId">
                        </form>
                        
                        @endforeach
                        
                            
                    </div>
                </div>
                <div class="d-none code-view">

                </div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div><!-- end col -->
    <div class="d-flex align-items-start gap-3 mt-4">
        <button type="button" class="btn btn-light btn-label prev-step"
        data-prev="#step1" onclick="window.location.href='{{ route('projects.planningreview', $project->id) }}'"><i
            class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Back to Planning Review</button>
        
            <button type="button" class="btn btn-primary btn-label right ms-auto next-step"
            data-next="#step2" onclick="window.location.href='{{ route('projects.designreview', $project->id) }}'" ><i
                    class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Go to Review</button>
    </div> 
</x-tab-layout>
                            
