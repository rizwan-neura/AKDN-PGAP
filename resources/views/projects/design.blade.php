<x-tab-layout :project="$project">
    <div class="col-xl-12">
        <div class="card">
            
            <div class="card-body py-0">
                
                <div class="live-preview">
                    
                    <div class="table-responsive design-scroll-wrapper">

                        <!-- Both top sections stay frozen together -->
                        <div class="design-sticky-header">
                    
                            <!-- FIRST TABLE: Construction cost -->
                            <form id="design_cost_form" method="POST" class="mb-0 py-0">
                                @csrf
                    
                                <table class="table table-nowrap mb-0 design-cost-table">
                                   <thead>
                                                        <tr >
                                                            <td width="20%" class="align-middle">Is the construction cost (USD) changed at design phase:
                                                                <span class="required-star">*</span>
                                                            </td>
                                                            <td width="12%">
                                                                <input type="number" required name="cost_at_design" id="cost_at_design" class="form-control" value="{{ old('cost_at_design', $project->cost_at_design) }}">
                                                            </td>
                                                            <td width="6%" class="align-middle">
                                                                <button class="btn btn-green-heading btn-sm" type="button"
                                                                onclick="updateCost('design_cost_form', '{{ route('projects.updateCost') }}' ); return false;">
                                                                    UPDATE
                                                                </button>
                                                            </td>
                                                            <td  class="status-message text-success mt-2 align-middle"></td>
                                                        </tr>
                                                    </thead>
                                </table>
                    
                                <input type="hidden" value="cost_at_design" name="cost_phase">
                                <input type="hidden" value="{{ $project->id }}" name="updatedProjectId">
                            </form>
                    
                            <!-- SECOND TABLE: Assessment headings -->
                            <table class="table table-bordered align-middle table-nowrap mb-0 design-heading-table">
                                <colgroup>
                                    <col style="width: 6%;">
                                    <col style="width: 52%;">
                                    <col style="width: 12%;">
                                    <col style="width: 18%;">
                                    <col style="width: 12%;">
                                </colgroup>
                                <thead>
                                    <tr>
                                        <th class="text-center py-1">Ref.</th>
                                        <th class="py-1">Assessment Description</th>
                                        <th class="text-center py-1">Compliance</th>
                                        <th class="text-center py-1">Upload</th>
                                        <th class="text-center py-1">Action</th>
                                    </tr>
                                </thead>
                            </table>
                    
                        </div>
                    
                        <!-- Assessment rows scroll underneath the frozen header -->
                        @foreach ($designAssessmentInfo as $row)
                    
                            <form id="design_form_{{ $row->id }}"
                                  method="POST"
                                  enctype="multipart/form-data"
                                  class="mb-0">
                                @csrf
                    
                                {{-- Right side: Status message --}}
                                <div class="status-message text-success m-0 text-end"></div>
                                            
                                <table class="table table-bordered align-middle design-row-table">
                                    <colgroup>
                                        <col style="width: 6%;">
                                        <col style="width: 52%;">
                                        <col style="width: 12%;">
                                        <col style="width: 18%;">
                                        <col style="width: 12%;">
                                    </colgroup>
                                
                                        <tr>
                                                        <!-- Ref No -->
                                                        <td class="text-center">
                                                            {{ $row->ref_no }}
                                                        </td>
                                            
                                                        <!-- Indicator Name -->
                                                        <td class="design-description">
                                                            {{ $row->indicator_name }}
                                                            @if($row->is_mandatory === 1)
                                                                <span class="required-star">*</span>
                                                            @endif
                                                        </td>
                                            
                                                        <!-- Compliance Dropdown -->
                                                        <td style="width: 12%;">
                                                            
                                                            @if ($row->id === 4)
                                                                <input type="number"
                                                                min="0"
                                                                max="1"
                                                                step="0.01"
                                                                oninput="if (this.value > 1) this.value = 1;"
                                                                name="compliance_31_value"
                                                                id="compliance_31_value"
                                                                class="form-control"
                                                                value="{{ old('compliance_31_value', $row->compliance_31_value) }}"
                                                                data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
                                                                title="The value cannot be more than 1. Example: Improved case / Base case = 124 / 150 = 0.82">
                                                            @else
                                                                <select class="form-select" name="compliance">
                                                                    <option value="">Choose</option>
                                                
                                                                    @if ($row->id === 5)
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
                                                                    @elseif ($row->id === 6)
                                                                        <option value="15" @selected(old('compliance', $row->compliances_id) == '15')>YES</option>
                                                                        <option value="14" @selected(old('compliance', $row->compliances_id) == '14')>NO</option>
                                                                    @else
                                                                        <option value="2" @selected(old('compliance', $row->compliances_id) == '2')>YES</option>
                                                                        <option value="1" @selected(old('compliance', $row->compliances_id) == '1')>NO</option>
                                                                        <option value="3" @selected(old('compliance', $row->compliances_id) == '3')>N/A</option>
                                                                    @endif
                                                                </select>
                                                            @endif
                                                        </td>
                                            
                                                        <!-- File Input -->
                                                        <td >
                                                            <input type="file" class="form-control file-input" name="design_uploads">
                                                        </td>
                                            
                                                       
                                                        <!-- Save Button -->
                                                        <td >
                                                            <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap">
                                                        
                                                                {{-- Left side: Save button and file actions --}}
                                                                <div class="d-flex align-items-center gap-1 flex-wrap">
                                                        
                                                                    <button class="btn btn-green-heading btn-sm"
                                                                            type="button"
                                                                            onclick="saveDesignValues('design_form_{{ $row->id }}', '{{ route('projects.saveDesignAssessment') }}', '{{ route('projects.deleteDesignFile') }}'); return false;">
                                                                        Save
                                                                    </button>
                                                        
                                                                    <div id="fileAfterServer">
                                                                        @if(!empty($row->file_path))
                                                                            <div class="d-flex align-items-center gap-1 uploaded-file">
                                                        
                                                                                <a href="{{ asset('storage/' . $row->file_path) }}"
                                                                                   target="_blank"
                                                                                   class="btn btn-sm btn-soft-primary"
                                                                                   data-bs-toggle="tooltip"
                                                                                   title="View File"
                                                                                   aria-label="View File">
                                                                                    <i class="ri-eye-line"></i>
                                                                                </a>
                                                        
                                                                                <button type="button"
                                                                                        class="btn btn-sm btn-soft-danger"
                                                                                        data-bs-toggle="tooltip"
                                                                                        title="Delete File"
                                                                                        aria-label="Delete File"
                                                                                        onclick="deleteDesignFile('design_form_{{ $row->id }}', '{{ route('projects.deleteDesignFile') }}'); return false;">
                                                                                    <i class="ri-delete-bin-line"></i>
                                                                                </button>
                                                        
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                        
                                                                </div>
                                                        
                                                                
                                                        
                                                            </div>
                                                    </tr>
                                                </table>
                                            
                                                <!-- Hidden Fields -->
                                                <input type="hidden" value="{{ $row->id }}" name="indicator_id">
                                                <input type="hidden" value="{{ $project->id }}" name="updatedProjectId">
                    
                            </form>
                    
                        @endforeach
                    
                    </div>
                </div>

                <div class="d-flex align-items-start gap-3 mt-0 py-3">
                    <button type="button" class="btn btn-light btn-sm btn-label prev-step"
                    data-prev="#step1" onclick="window.location.href='{{ route('projects.planningreview', $project->id) }}'"><i
                        class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Back to Planning Review</button>
                    
                        <button type="button" class="btn btn-primary btn-sm btn-label right ms-auto next-step"
                        data-next="#step2" onclick="window.location.href='{{ route('projects.designreview', $project->id) }}'" ><i
                                class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Go to Review</button>
                </div>
                
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div><!-- end col -->
     
</x-tab-layout>
                            
