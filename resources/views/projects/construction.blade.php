<x-tab-layout :project="$project">
    <div class="col-xl-12">
        <div class="card">
            
            <!-- end card header -->

            <div class="card-body py-0">
                
                <div class="live-preview">
                    <div class="table-responsive">
                        <!-- FIRST TABLE: Construction cost -->
                        <form id="cons_cost_form" method="POST" class="mb-0 py-0">
                            @csrf
                
                            <table class="table table-nowrap mb-0 design-cost-table">
                               <thead>
                                                    <tr >
                                                        <td width="20%" class="align-middle">Is the construction cost (USD) changed at construction phase:
                                                            <span class="required-star">*</span>
                                                        </td>
                                                        <td width="12%">
                                                            <input type="number" required name="cost_at_construction" id="cost_at_construction" class="form-control" value="{{ old('cost_at_construction', $project->cost_at_construction) }}">
                                                        </td>
                                                        <td width="6%" class="align-middle">
                                                            <button class="btn btn-green-heading btn-sm" type="button"
                                                            onclick="updateCost('cons_cost_form', '{{ route('projects.updateCost') }}' ); return false;">
                                                                UPDATE
                                                            </button>
                                                        </td>
                                                        <td  class="status-message text-success mt-2 align-middle"></td>
                                                    </tr>
                                                </thead>
                            </table>
                            <input type="hidden" value="cost_at_construction" name="cost_phase">
                            <input type="hidden" value="{{ $project->id }}" name="updatedProjectId">
                        </form>
                        
                        <table class="table table-bordered align-middle table-nowrap mb-0">
                            <thead>
                                <tr class="assessment-header">
                                    <th width="3%" class="text-center py-1">Ref.</th>
                                    <th width="58%" class="py-1">Assessment Description</th>
                                    <th width="11%" class="text-center py-1">Compliance</th>
                                    <th width="16%" class="text-center py-1">Upload</th>
                                    <th width="12%" class="text-center py-1">Actions</th>
                                </tr>
                            </thead>
                        </table>
                            
                        @foreach ($constructionAssessInfo as $row)
                        <form id="construction_form_{{ $row->id }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="status-message text-success text-end"></div>
                            <div class="d-flex align-items-center flex-wrap">

                                <!-- ID -->
                                <div class="flex-shrink-0 text-center" style="width: 3%;">
                                    {{ $row->ref_no }}
                                </div>
                            
                                <!-- Checklist Name -->
                                <div class="flex-grow-1 px-2" style="width: 58%; word-wrap: break-word; white-space: normal;" title="{{ $row->indicator_name }}">
                                    {{ $row->indicator_name }}
                                    @if($row->is_mandatory === 1)
                                    <span class="required-star">*</span>
                                    @endif
                                </div>
                            
                                <!-- Status Select -->
                                <div class="px-2" style="width: 11%;">
                                    @if ($row->id === 2)
                                                    <select class="form-select" name="compliance">
                                                        <option value="">Choose</option>
                                                        <option value="4" @selected(old('compliance', $row->compliances_id) == '4')>Yes more than 80% of the vendors/suppliers are local</option>
                                                        <option value="5" @selected(old('compliance', $row->compliances_id) == '5')>Yes > 50 < 80% of the vendors/suppliers are local</option>
                                                        <option value="6" @selected(old('compliance', $row->compliances_id) == '6')>Yes < 30% of the vendors/suppliers are local</option>
                                                        <option value="7" @selected(old('compliance', $row->compliances_id) == '7')>Yes > 30 < 50% of the vendors/suppliers are local</option>
                                                        <option value="1" @selected(old('compliance', $row->compliances_id) == '1')>NO</option>
                                                    </select>
                                                
                                                @else
                                                    <select class="form-select" name="compliance">
                                                        <option value="">Choose</option>
                                                        <option value="2" @selected(old('compliance', $row->compliances_id) == '2')>YES</option>
                                                        <option value="1" @selected(old('compliance', $row->compliances_id) == '1')>NO</option>
                                                        <option value="3" @selected(old('compliance', $row->compliances_id) == '3')>N/A</option>
                                                    </select>
                                                
                                            @endif
                                </div>
                            
                                <!-- File Input -->
                                <div class="px-2" style="width: 16%;">
                                    <input type="file" class="form-control file-input w-100" name="cons_uploads">
                                </div>
                            
                                <!-- Start: Uploaded File Info -->
                                <div class="px-2 d-flex align-items-center justify-content-start gap-2" style="width: 12%;">

                                    <!-- Save Button: Left Side -->
                                   
                                        <button class="btn btn-green-heading btn-sm"
                                                type="button"
                                                onclick="saveConstructionValues('construction_form_{{ $row->id }}', '{{ route('projects.saveConstructionAssessment') }}', '{{ route('projects.deleteConstructionFile') }}'); return false;">
                                            Save
                                        </button>
                                    
                                    <div id="fileAfterServer" >
                                        <!-- View / Delete: Right Side -->
                                        @if(!empty($row->file_path))
                                            
                                                <div class="d-flex gap-1 uploaded-file">
                                    
                                                    <!-- View File -->
                                                    <a href="{{ asset('storage/' . $row->file_path) }}"
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
                                                            onclick="deleteConstructionFile('construction_form_{{ $row->id }}', '{{ route('projects.deleteConstructionFile') }}' ); return false;">
                                                        <i class="ri-delete-bin-line"></i>
                                                    </button>
                                    
                                                </div>
                                        @endif
                                    </div>
                                </div>
                                <!-- End: Uploaded File Info -->
                                
                            
                            </div>
                            <!-- Hidden Fields -->
                            <input type="hidden" value="{{ $row->id }}" name="indicator_id">
                            <input type="hidden" value="{{ $project->id }}" name="updatedProjectId">
                        </form>
                        @endforeach
                    </div>
                </div>
                <div class="d-flex align-items-start gap-3 mt-0 py-3">
                    <button type="button" class="btn btn-light btn-sm btn-label prev-step"
                    data-prev="#step1" onclick="window.location.href='{{ route('projects.designreview', $project->id) }}'"><i
                        class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Back to Design Review</button>
                    
                        <button type="button" class="btn btn-primary btn-sm btn-label right ms-auto next-step"
                        data-next="#step2" onclick="window.location.href='{{ route('projects.consreview', $project->id) }}'" ><i
                                class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Go to Review</button>
                </div>


            </div><!-- end card-body -->
        </div><!-- end card -->
    </div><!-- end col -->
    
</x-tab-layout>
                    