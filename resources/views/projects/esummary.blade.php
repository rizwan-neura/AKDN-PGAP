<x-tab-layout :project="$project">
        <form name="s_summary" id="s_summary" method="POST" action="{{ route('projects.savesummary', $project->id) }}" >  
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        
                        <div class="card-body py-0">
                            <div class="live-preview">
                                <div class="row gy-4">
                                    <div class="col-xxl-8 col-md-6">
                                        <div>
                                            <textarea class="form-control" name="executive_summary" placeholder="Enter Description" id="des-info-description-input" rows="5"
                                            required>{{ $project->executive_summary }}</textarea>
                                            <div class="invalid-feedback">Please enter a summary</div>
                                            @error('executive_summary')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <!--end col-->
                                </div>
                            </div>
                            <input type="hidden" value="{{ $project->id }}" name="updatedProjectId">
                            <div class="d-flex align-items-start gap-3 mt-0 py-3">
                                <button type="button" class="btn btn-light btn-sm btn-label prev-step"
                                data-prev="#step1" onclick="window.location.href='{{ route('projects.edit', $project->id) }}'"><i
                                    class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Back to Project</button>
                                <button type="submit" class="btn btn-sm btn-green-heading">Save Summary</button>
                                <button type="button" class="btn btn-primary btn-sm btn-label right ms-auto next-step"
                                data-next="#step3" 
                                onclick="window.location.href='{{ route('projects.checklist', $project->id) }}'"><i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Go to Checklist</button>
                            </div>  
                        </div>
                    </div>
                    <!-- end card -->
                </div>
                <!--end col-->
            </div>
            
        </form>
</x-tab-layout>
