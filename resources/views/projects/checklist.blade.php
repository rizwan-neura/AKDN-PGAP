<x-tab-layout :project="$project">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1">Enviromental Requirements Checklist</h4>
                        
                    </div><!-- end card header -->

                    <div class="card-body">
                        
                        <div class="live-preview">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle table-nowrap mb-0">
                                    <thead>
                                        <tr class="table-primary">
                                            <th width="5%">#</th>
                                            <th width="55%">Requirements</th>
                                            <th width="10%">Status</th>
                                            <th width="15%">Upload</th>
                                            <th width="10%">File</th>
                                            <th width="5%">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                                    
                                @foreach ($projectCheckLists as $row)
                                <form id="checklist_form_{{ $row->id }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="status-message text-success mt-2" style="margin-left: 800px;"></div>
                                    <div class="d-flex border p-2 align-items-center flex-wrap mb-2" style="border-radius: 5px;">

                                        <!-- ID -->
                                        <div class="flex-shrink-0 text-center" style="width: 5%;">
                                            {{ $row->id }}
                                        </div>
                                    
                                        <!-- Checklist Name -->
                                        <div class="flex-grow-1 px-2" style="width: 55%; word-wrap: break-word; white-space: normal;" title="{{ $row->checklist_name }}">
                                            {{ $row->checklist_name }}
                                            @if($row->is_mandatory === 1)
                                                <i style="color: red;"><b>( * )</b></i>
                                            @endif
                                        </div>
                                    
                                        <!-- Status Select -->
                                        <div class="px-2" style="width: 10%;">
                                            <select class="form-select" name="checklistStatus">
                                                <option value="">Choose</option>
                                                <option value="YES" @selected(old('checklistStatus', $row->status) == 'YES')>YES</option>
                                                <option value="NO" @selected(old('checklistStatus', $row->status) == 'NO')>NO</option>
                                            </select>
                                        </div>
                                    
                                        <!-- File Input -->
                                        <div class="px-2" style="width: 15%;">
                                            <input type="file" class="form-control file-input w-100" name="checklist_uploads">
                                        </div>
                                    
                                        <!-- Uploaded File Info -->
                                        <div class="px-2" style="width: 10%;" id="fileAfterServer">
                                            @if(!empty($row->file_path))
                                            <div class="d-flex flex-column uploaded-file mt-2">
                                                <a href="{{ asset('storage/' . $row->file_path) }}" target="_blank" class="text-primary d-inline-flex align-items-center">
                                                    <i class="mdi mdi-file-document-outline me-1"></i> View File
                                                </a>
                                                <div style="height: 8px;"></div>
                                                <button type="button" class="btn btn-link text-danger p-0 d-inline-flex align-items-center"
                                                    onclick="deleteChecklistFile('checklist_form_{{ $row->id }}', '{{ route('projects.deleteCheckListFile') }}', {{ $row->id }}); return false;">
                                                    <i class="mdi mdi-delete-outline me-1"></i> Delete
                                                </button>
                                            </div>                                                                    
                                            @endif
                                        </div>
                                    
                                        <!-- Save Button -->
                                        <div class="px-2" style="width: 5%;">
                                            <button class="btn btn-success btn-sm" type="button"
                                                onclick="saveIndicatorValues('checklist_form_{{ $row->id }}', '{{ route('projects.saveCheckList') }}', {{ $row->id }}, '{{ route('projects.deleteCheckListFile') }}'); return false;">
                                                SAVE
                                            </button>
                                        </div>
                                    
                                    </div>
                                    
                        
                                    <input type="hidden" value="{{ $row->id }}" name="checklist_id">
                                    <input type="hidden" value="{{ $project->id }}" name="updatedProjectId">
                                </form>
                                @endforeach
                            </div>
                        </div>
                    </div><!-- end card-body -->
                </div><!-- end card -->
            </div><!-- end col -->
            <div class="d-flex align-items-start gap-3 mt-4">
                <button type="button" class="btn btn-light btn-label prev-step"
                data-prev="#step1" onclick="window.location.href='{{ route('projects.esummary', $project->id) }}'"><i
                    class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Back to Summary</button>
                
                    <button type="button" class="btn btn-primary btn-label right ms-auto next-step"
                    data-next="#step2" onclick="window.location.href='{{ route('projects.planning', $project->id) }}'" ><i
                            class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Go to Planning</button>
            </div>
</x-tab-layout>
                            