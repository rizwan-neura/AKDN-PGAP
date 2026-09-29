<x-tab-layout :project="$project">
    <div class="col-xl-12">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Design Review</h4>
                
            </div><!-- end card header -->

            <div class="card-body">
                <div class="live-preview">
                    <div class="table-responsive">
                            <div class="body table-responsive">
                                <table class="table table-bordered text-center fw-bold bg-blue-grey align-middle">
                                    <thead>
                                        <tr class="table-primary">
                                            <th class="col-md-1">GBG's Ref</th>
                                            <th class="col-md-3">Assessment Description</th>
                                            <th class="col-md-1">Degree of Compliance</th>
                                            <th class="col-md-6">Assessment</th>
                                            
                                        </tr>
                                    </thead>
                                </table>
                                <!-- Header Row 2 (Sub-columns under Assessment) -->
                                <table class="table table-bordered text-center fw-bold bg-blue-grey align-middle">
                                    <thead>
                                        <tr class="table-info">
                                            <th class="col-md-1">&nbsp;</th>
                                            <th class="col-md-3">&nbsp;</th>
                                            <td class="col-md-1">&nbsp;</td>
                                            <th class="col-md-1 ">Score</th>
                                            <th class="col-md-1">Weightage</th>
                                            <th class="col-md-4">
                                                <h5>Design Rating:  
                                                    @if ($designFinalScoreRating)
                                                        {{ $designFinalScoreRating->rating }}
                                                    @endif
                                                </h5>
                                            </th>
                                            
                                        </tr>
                                    </thead>
                                </table>
                                <!-- Summary Score Row -->
                                <table class="table table-bordered text-center fw-bold bg-grey align-middle">
                                    <tr class="table-info">
                                        <td class="col-md-1">&nbsp;</td>
                                        <td class="col-md-3">&nbsp;</td>
                                        <td class="col-md-1">&nbsp;</td>
                                        <td class="col-md-1 td-finalscore" data-indicator-id="planningFinalScore">
                                            @if ($designFinalScoreRating)
                                            {{ number_format($designFinalScoreRating->score, 1) }}
                                            @endif
                                        </td>
                                        <td class="col-md-1">45%</td>
                                        
                                        <td class="col-md-4">Comments</td>
                                        
                                    </tr>
                                </table>
                                <!-- Dynamic Score Rows -->
                                @foreach ($designAssessmentInfo as $row)
                                    
                                <table class="table table-bordered table-sm align-middle">
                                            <tr data-indexPlanningIndcaotrId="{{ $row->id }}">
                                                <td class="col-md-1  text-center">
                                                    {{ $row->ref_no }}
                                                </td>
                                                <td class="col-md-3 text-start">
                                                    {{ $row->indicator_name }}
                                                    @if($row->is_mandatory === 1)
                                                    <span class="required-star">*</span>
                                                    @endif
                                                </td>
                                                <td class="col-md-1 text-center td-comp-name" data-indicator-id="{{ $row->id }}">
                                                    @if($row->id != 4)
                                                        {{ $row->comp_name }}
                                                     @else
                                                        {{ $row->compliance_31_value }}
                                                    @endif
                                                </td>
                                                <td class="col-md-1 text-center td-comp-score" data-indicator-id="{{ $row->id }}">
                                                    @if($row->id != 4)
                                                         {{ $row->complianceScore }}
                                                     @else
                                                            {{ $row->score * 10 }}
                                                    @endif
                                                   
                                                </td>
                                                <td class="col-md-1 text-center td-weightage" data-indicator-id="{{ $row->id }}">
                                                    {{ number_format($row->indicatorWeightage, 0) }}%
                                                </td>
                                                
                                                <td class="col-md-3 text-start td-weightage" data-indicator-id="{{ $row->id }}">
                                            
                                                    <div class="comments-container">
                                                        <div class="text-muted">
                                                            @if($row->comments->isEmpty())
                                                                <em>No comments yet.</em>
                                                            @else
                                                                
                                                                @foreach ($row->comments as $comment)
                                                                    <form id="comment_form_{{ $comment->id }}" method="POST" class="mb-0">
                                                                        @csrf    
                                                                        
                                                                        <div class="mb-2">
                                                                            <strong>{{ $comment->user->first_name ?? 'Unknown User' }}</strong>
                                                                            <br>
                                                                            <span class="small text-muted">{{ $comment->created_at->diffForHumans() }}</span>
                                                                            <p class="mb-0">
                                                                                {{ $comment->comments }}
                                                                            
                                                                                <button type="button"
                                                                                        class="btn btn-link p-0 ms-2 edit-comment"
                                                                                        data-bs-toggle="modal"
                                                                                        data-bs-target="#varyingcontentModal_{{ $comment->id }}"
                                                                                        data-bs-whatever="Comment">
                                                                                    Edit
                                                                                </button>
                                                                            </p>
                                                                        </div>
                                                                        
                                                                        <!-- Edit comment modal content -->
                                                                        <div class="modal fade" id="varyingcontentModal_{{ $comment->id }}" tabindex="-1" aria-labelledby="varyingcontentModalLabel_{{ $comment->id }}" aria-hidden="true">
                                                                            <div class="modal-dialog">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <h5 class="modal-title" id="varyingcontentModalLabel_{{ $comment->id }}">Comment</h5>
                                                                                        
                                                                                    </div>
                                                                                    <div class="status-message text-success mt-2" style="margin-left: 20px;"></div>
                                                                                    <div class="modal-body">
                                                                                        <form id="comment_form_{{ $comment->id }}">
                                                                                            <div class="mb-3">
                                                                                                <textarea class="form-control" name="comments" id="comments_{{ $comment->id }}" rows="4">{{ $comment->comments }}</textarea>
                                                                                            </div>
                                                                                        </form>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button"
                                                                                                class="btn btn-light"
                                                                                                data-bs-dismiss="modal">
                                                                                            Close
                                                                                        </button>
                                                                                        <button class="btn btn-success"
                                                                                                    type="button"
                                                                                                    onclick="saveComments(
                                                                                                        'comment_form_{{ $comment->id }}',
                                                                                                        '{{ route('projects.saveComments') }}',
                                                                                                        {{ $comment->id }},
                                                                                                        'update'
                                                                                                    ); return false;">
                                                                                                SAVE
                                                                                        </button>
                                                                                       
                                                                                        <!-- Start: Below variables must be inside model -->
                                                                                        <input type="hidden" value="Design" name="comments_for">
                                                                                        <input type="hidden" value="{{ $row->id }}" name="indicator_id">
                                                                                        <input type="hidden" value="{{ $project->id }}" name="updatedProjectId">
                                                                                        <input type="hidden" value="{{ auth()->id() }}" name="user_id">
                                                                                        <input type="hidden" value="{{ $comment->id }}" name="comment_id">
                                                                                        <!-- End: variables must be inside model -->
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            
                                                                        </div>
                                                                        <!-- end edit comment modal content -->
                                                                    </form>
                                                                 @endforeach
                                                                
                                                            
                                                            @endif
                                                        </div>
                                                    </div>
                    
                                                </td>
                                                
                                                <td class="col-md-1 text-start">
                                                    
                                                        <div class="hstack gap-2 flex-wrap">
                                                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#createCommentModal_{{ $row->id }}" data-bs-whatever="Comment">Commnet</button>
                                                        </div>
                                                       
                                                        <!-- Create commnet modal content -->
                                                        <div class="modal fade"
                                                            id="createCommentModal_{{ $row->id }}"
                                                            tabindex="-1"
                                                            aria-labelledby="varyingcontentModalLabel_{{ $row->id }}"
                                                            aria-hidden="true">

                                                            <div class="modal-dialog">
                                                                <div class="modal-content">

                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title"
                                                                            id="varyingcontentModalLabel_{{ $row->id }}">
                                                                            Comment
                                                                        </h5>
                                                                    </div>

                                                                    <div class="status-message text-success mt-2"
                                                                        style="margin-left: 20px;">
                                                                    </div>

                                                                    <div class="modal-body">

                                                                        <form id="create_comment_form_{{ $row->id }}"
                                                                            method="POST">

                                                                            @csrf

                                                                            <div class="mb-3">
                                                                                <textarea
                                                                                    class="form-control"
                                                                                    name="comments"
                                                                                    id="comments_{{ $row->id }}"
                                                                                    rows="4"></textarea>
                                                                            </div>

                                                                            <!-- Hidden variables -->
                                                                            <input type="hidden"
                                                                                value="Design"
                                                                                name="comments_for">

                                                                            <input type="hidden"
                                                                                value="{{ $row->id }}"
                                                                                name="indicator_id">

                                                                            <input type="hidden"
                                                                                value="{{ $project->id }}"
                                                                                name="updatedProjectId">

                                                                            <input type="hidden"
                                                                                value="{{ auth()->id() }}"
                                                                                name="user_id">

                                                                        </form>

                                                                    </div>

                                                                    <div class="modal-footer">

                                                                        <button type="button"
                                                                                class="btn btn-light"
                                                                                data-bs-dismiss="modal">
                                                                            Close
                                                                        </button>

                                                                        <button class="btn btn-success"
                                                                                type="button"
                                                                                onclick="saveComments(
                                                                                    'create_comment_form_{{ $row->id }}',
                                                                                    '{{ route('projects.saveComments') }}',
                                                                                    {{ $row->id }},
                                                                                    'create'
                                                                                ); return false;">
                                                                            SAVE
                                                                        </button>

                                                                    </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- end create comment modal content -->
                                                    
                                                </td>
                                                
                                            </tr>
                                        </table>
                                    
                                @endforeach

                                <!-- Footer Button Row -->
                                <div class="row border border-dark py-3 text-center">
                                    <div class="col-12">
                                        <button type="button" class="btn btn-primary waves-effect">REVIEWED</button>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div><!-- end col -->
    
    <div class="d-flex align-items-start gap-3 mt-4">
        <button type="button" class="btn btn-light btn-label prev-step"
        data-prev="#step1" onclick="window.location.href='{{ route('projects.design', $project->id) }}'"><i
            class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>Back to Design</button>
        
            <button type="button" class="btn btn-primary btn-label right ms-auto next-step"
            data-next="#step2" onclick="window.location.href='{{ route('projects.construction', $project->id) }}'" ><i
                    class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>Go to Construction</button>
    </div>
</x-tab-layout>
                            