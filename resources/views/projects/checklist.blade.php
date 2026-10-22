<x-tab-layout :project="$project">
            <div class="col-xl-12">
                <div class="card">
                    
                    <!-- end card header -->

                    <div class="card-body py-0">
                        
                        <div class="live-preview">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle table-nowrap mb-0">
                                    <thead>
                                        <tr class="assessment-header">
                                            <th width="3%" class="text-center py-1">#</th>
                                            <th width="58%" class="py-1">Requirements</th>
                                            <th width="11%" class="text-center py-1">Status</th>
                                            <th width="16%" class="text-center py-1">Upload</th>
                                            <th width="12%" class="text-center py-1">Actions</th>
                                        </tr>
                                    </thead>
                                </table>
                                    
                                @foreach ($projectCheckLists as $row)
                                <form id="checklist_form_{{ $row->id }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="status-message text-success text-end"></div>
                                    <div class="d-flex align-items-center flex-wrap">

                                        <!-- ID -->
                                        <div class="flex-shrink-0 text-center" style="width: 3%;">
                                            {{ $row->id }}
                                        </div>
                                    
                                        <!-- Checklist Name -->
                                        <div class="flex-grow-1 px-2" style="width: 58%; word-wrap: break-word; white-space: normal;" title="{{ $row->checklist_name }}">
                                            {{ $row->checklist_name }}
                                            @if($row->is_mandatory === 1)
                                            <span class="required-star">*</span>
                                            @endif
                                        </div>
                                    
                                        <!-- Status Select -->
                                        <div class="px-2" style="width: 11%;">
                                            <select class="form-select" name="checklistStatus">
                                                <option value="">Choose</option>
                                                <option value="YES" @selected(old('checklistStatus', $row->status) == 'YES')>YES</option>
                                                <option value="NO" @selected(old('checklistStatus', $row->status) == 'NO')>NO</option>
                                            </select>
                                        </div>
                                    
                                        <!-- File Input -->
                                        <div class="px-2" style="width: 16%;">
                                            <input type="file" class="form-control file-input w-100" name="checklist_uploads">
                                        </div>
                                    
                                        <!-- Start: Uploaded File Info -->
                                        <div class="px-2 d-flex align-items-center justify-content-start gap-2" style="width: 12%;">

                                            <!-- Save Button: Left Side -->
                                            <div>
                                                <button class="btn btn-green-heading btn-sm"
                                                        type="button"
                                                        onclick="saveIndicatorValues('checklist_form_{{ $row->id }}', '{{ route('projects.saveCheckList') }}', {{ $row->id }}, '{{ route('projects.deleteCheckListFile') }}'); return false;">
                                                    Save
                                                </button>
                                            </div>
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
                                                                    onclick="deleteChecklistFile('checklist_form_{{ $row->id }}', '{{ route('projects.deleteCheckListFile') }}', {{ $row->id }}); return false;">
                                                                <i class="ri-delete-bin-line"></i>
                                                            </button>
                                            
                                                        </div>
                                                @endif
                                            </div>
                                        </div>
                                        <!-- End: Uploaded File Info -->
                                        
                                    
                                    </div>
                                    
                        
                                    <input type="hidden" value="{{ $row->id }}" name="checklist_id">
                                    <input type="hidden" value="{{ $project->id }}" name="updatedProjectId">
                                </form>
                                @endforeach
                            </div>
                        </div>
                        <div class="d-flex align-items-start gap-3 mt-0 py-3">
                            <button type="button" class="btn btn-light btn-sm btn-label prev-step"
                            data-prev="#step1" onclick="window.location.href='{{ route('projects.esummary', $project->id) }}'"><i
                                class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Back to Summary</button>
                            
                                <button type="button" class="btn btn-primary btn-sm btn-label right ms-auto next-step"
                                data-next="#step2" onclick="window.location.href='{{ route('projects.planning', $project->id) }}'" ><i
                                        class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Go to Planning</button>
                        </div>


                    </div><!-- end card-body -->
                </div><!-- end card -->
            </div><!-- end col -->
            
</x-tab-layout>
                            