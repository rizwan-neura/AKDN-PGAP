{{-- resources/views/projects/edit.blade.php --}}
<x-tab-layout :project="$project">
    
    <div class="text-start">
        <form id="design_cost_form" method="POST" class="mb-0">
        @csrf   
        <table class="table align-start table-nowrap mb-0">
            <thead>
                <!-- Question 1 -->
                <tr>
                    <th width="25%" class="text-start align-middle">
                        Has this project been reviewed by CSA before? <i style="color: red;"><b>( * )</b></i>
                    </th>
                    <th width="25%" class="text-start align-middle">
                        <select name="reviewed_before" id="reviewed_before" class="form-select" required>
                            <option value="">-Select-</option>
                            <option value="YES">YES</option>
                            <option value="NO">NO</option>
                        </select>
                    </th>
                    <th class="align-middle"></th>
                </tr>
        
                <!-- Question 2 -->
                <tr id="phase_row" style="display: none;">
                    <th width="25%" class="text-start align-middle">
                        If YES, which phase? <i style="color: red;"><b>( * )</b></i>
                    </th>
                    <th width="25%" class="text-start align-middle">
                        <select name="reviewed_phase" id="reviewed_phase" class="form-select">
                            <option value="">-Select-</option>
                            <option value="Planning">Planning</option>
                            <option value="Design">Design</option>
                            <option value="Construction">Construction</option>
                        </select>
                    </th>
                    <th class="align-middle"></th>
                </tr>
        
                <!-- Question 3 -->
                <tr>
                    <th width="25%" class="text-start align-middle">
                        Is this project now being assessed for next phase? <i style="color: red;"><b>( * )</b></i>
                    </th>
                    <th width="25%" class="text-start align-middle">
                        <select name="next_phase" id="next_phase" class="form-select" required>
                            <option value="">-Select-</option>
                            <option value="YES">YES</option>
                            <option value="NO">NO</option>
                        </select>
                    </th>
                    <th class="align-middle"></th>
                </tr>
            </thead>
        </table>
        
        
        
        <input type="hidden" value="cost_at_design" name="cost_phase">
        <input type="hidden" value="{{ $project->id }}" name="updatedProjectId">
        </form>
    </div>

    <form name="create_project" id="create_project" method="POST" action="{{ route('projects.update', $project->id) }}">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="live-preview">
                            <div class="row gy-4">
                                {{-- Project Name --}}
                                <div class="col-xxl-3 col-md-6">
                                    <label class="form-label">Project Name</label>
                                    <input type="text" name="project_name" value="{{ old('project_name', $project->project_name) }}" class="form-control" required>
                                    <div class="invalid-feedback">Please enter project name</div>
                                </div>

                                {{-- Current Phase --}}
                                <div class="col-xxl-3 col-md-6">
                                    <label class="form-label">Current Phase</label>
                                    <select name="phase_id" class="form-select" required>
                                        <option value="">Select Phase</option>
                                        @foreach($projectPhases as $id => $phase_name)
                                            <option value="{{ $id }}" {{ old('phase_id', $project->phase_id) == $id ? 'selected' : '' }}>
                                                {{ $phase_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select a phase</div>
                                </div>

                                {{-- Assessment Requirement --}}
                                <div class="col-xxl-3 col-md-6">
                                    <label class="form-label">Assessment Requirement</label>
                                    <input type="text" name="assessment_req" value="{{ old('assessment_req', $project->assessment_req) }}" class="form-control">
                                </div>

                                {{-- Organization --}}
                                <div class="col-xxl-3 col-md-6">
                                    <label class="form-label">Organization</label>
                                    <select name="organization_id" class="form-select" required>
                                        <option value="">Select Organization</option>
                                        @foreach($organizations as $id => $name)
                                            <option value="{{ $id }}" {{ old('organization_id', $project->organization_id) == $id ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select an organization</div>
                                </div>

                                {{-- Date of GBA Performance --}}
                                <div class="col-xxl-3 col-md-6">
                                    <label class="form-label">Date of GBA* Performance</label>
                                    <input type="date" name="date_gpa" value="{{ old('date_gpa', $project->date_gpa) }}" class="form-control" required>
                                    <div class="invalid-feedback">Please select Date of GBA</div>
                                </div>

                                {{-- Start Date --}}
                                <div class="col-xxl-3 col-md-6">
                                    <label class="form-label">Project Start Date</label>
                                    <input type="date" name="start_date" value="{{ old('start_date', $project->start_date) }}" class="form-control" required>
                                    <div class="invalid-feedback">Please select start date</div>
                                </div>

                                {{-- End Date --}}
                                <div class="col-xxl-3 col-md-6">
                                    <label class="form-label">Project End Date</label>
                                    <input type="date" name="end_date" value="{{ old('end_date', $project->end_date) }}" class="form-control" required>
                                    <div class="invalid-feedback">Please select end date</div>
                                </div>

                                {{-- Country --}}
                                <div class="col-xxl-3 col-md-6">
                                    <label class="form-label">Country</label>
                                    <select name="country_code" class="form-select">
                                        <option selected>Alabama</option>
                                        <option>Alaska</option>
                                        <option>California</option>
                                        <option>Delaware</option>
                                        <option>Tennessee</option>
                                        <option>Texas</option>
                                        <option>Washington</option>
                                    </select>
                                </div>

                                {{-- Region --}}
                                <div class="col-xxl-3 col-md-6">
                                    <label class="form-label">Region</label>
                                    <select name="region_code" class="form-select">
                                        <option selected>Alabama</option>
                                        <option>Alaska</option>
                                        <option>California</option>
                                        <option>Delaware</option>
                                        <option>Tennessee</option>
                                        <option>Texas</option>
                                        <option>Washington</option>
                                    </select>
                                </div>

                                {{-- Location --}}
                                <div class="col-xxl-3 col-md-6">
                                    <label class="form-label">Location (Site / HO)</label>
                                    <input type="text" name="location" value="{{ old('location', $project->location) }}" class="form-control">
                                </div>

                                {{-- Coordinates --}}
                                <div class="col-xxl-3 col-md-6">
                                    <label class="form-label">GPS Coordinates</label>
                                    <input type="text" name="coordinates" value="{{ old('coordinates', $project->coordinates) }}" class="form-control">
                                    <div class="invalid-feedback">Please enter coordinates in decimal</div>
                                </div>

                                {{-- Building Type --}}
                                <div class="col-xxl-3 col-md-6">
                                    <label class="form-label">Building Type</label>
                                    <select name="type_id" id="type_id" class="form-select" onchange="ajaxFormGet('create_project','{{ route('projects.getBuildingSubTypes') }}','sub_type_id')" required>
                                        <option value="">Select Type</option>
                                        @foreach($buildingTypes as $id => $type_name)
                                            <option value="{{ $id }}" {{ old('type_id', $project->type_id) == $id ? 'selected' : '' }}>
                                                {{ $type_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">Please select building type</div>
                                </div>

                                {{-- Sub-Type --}}
                                <div class="col-xxl-3 col-md-6">
                                    <label class="form-label">Sub-Type</label>
                                    <select name="sub_type_id" id="sub_type_id" class="form-select" required>
                                        <option value="">Select Sub-type</option>
                                    </select>
                                    <div class="invalid-feedback">Please select sub type</div>
                                </div>

                                {{-- Construction Cost --}}
                                <div class="col-xxl-3 col-md-6">
                                    <label class="form-label">Construction Cost (USD)</label>
                                    <input type="number" name="construction_cost" value="{{ old('construction_cost', $project->construction_cost) }}" class="form-control" placeholder="Exp 9999.99" required>
                                    <div class="invalid-feedback">Please enter construction cost</div>
                                </div>

                                {{-- Cost Phase --}}
                                <div class="col-xxl-3 col-md-6">
                                    <label class="form-label">Construction Cost @</label>
                                    <select name="cost_phasex" class="form-select">
                                        <option value="">Planning</option>
                                        <option value="">Design</option>
                                        <option value="">Construction</option>
                                    </select>
                                </div>

                                {{-- Mandatory Requirement --}}
                                <div class="col-xxl-6 col-md-6">
                                    <label class="form-label">Mandatory Requirement</label>
                                    <input type="text" readonly name="requirements" value="{{ old('requirements', $project->requirements) }}" class="form-control">
                                </div>

                                {{-- Hidden Fields --}}
                                <input type="hidden" name="step" value="0">
                                <input type="hidden" name="min_cost" id="min_cost" value="{{ $thresholds->min_value }}">
                                <input type="hidden" name="max_cost" id="max_cost" value="{{ $thresholds->max_value }}">
                                <input type="hidden" name="output_1" id="output_1" value="{{ $thresholds->output_1 }}">
                                <input type="hidden" name="output_2" id="output_2" value="{{ $thresholds->output_2 }}">
                                <input type="hidden" name="output_3" id="output_3" value="{{ $thresholds->output_3 }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form Buttons --}}
        <div class="d-flex align-items-start gap-3 mt-4">
            <button type="submit" class="btn btn-success">Update Project</button>
            <button type="button" class="btn btn-success btn-label right ms-auto next-step"
                data-next="#step2" onclick="window.location.href='{{ route('projects.esummary', $project->id) }}'">
                <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Go to Ex. Summary
            </button>
        </div>
    </form>
    
</x-tab-layout>
