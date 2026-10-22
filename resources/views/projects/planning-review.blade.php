<x-tab-layout :project="$project">
    <div class="col-xl-12">
        <div class="card">

            <div class="card-body py-0">

                <div class="live-preview">
                    <div class="table-responsive">
                        
                        <div class="planning-table-wrapper">
                            <table class="table table-bordered align-middle mb-0 planning-table">
                        
                                <colgroup>
                                    <col style="width: 4%;">
                                    <col style="width: 37%;">
                                    <col style="width: 8%;">
                                    <col style="width: 6%;">
                                    <col style="width: 8%;">
                                    <col style="width: 29%;">
                                    <col style="width: 8%;">
                                </colgroup>
                        
                                <thead>
                                    <!-- Main heading -->
                                    <tr class="table-primary">
                                        <th rowspan="3" class="py-1 text-center">Ref.</th>
                                        <th rowspan="3" class="py-1">Assessment Description</th>
                                        <th rowspan="3" class="py-1 text-center">Compliance</th>
                                        <th colspan="3" class="py-1 text-center">Assessment</th>
                                        <th rowspan="3" class="py-1 text-center">Actions</th>
                                    </tr>
                        
                                    <!-- Subheadings -->
                                    <tr>
                                        <th class="py-1 text-center">Score</th>
                                        <th class="py-1 text-center">Weightage</th>
                                        <th class="py-1 text-center">
                                            Planning Rating:
                                            @if ($planningFinalScoreRating)
                                                {{ $planningFinalScoreRating->rating }}
                                            @endif
                                        </th>
                                    </tr>
                        
                                    <!-- Assessment summary -->
                                    <tr>
                                        <th class="py-1 text-center td-finalscore"
                                            data-indicator-id="planningFinalScore">
                                            @if ($planningFinalScoreRating)
                                                {{ number_format($planningFinalScoreRating->score, 1) }}
                                            @endif
                                        </th>
                                        <th class="py-1 text-center">45%</th>
                                        <th class="py-1 text-center">Comments</th>
                                    </tr>
                                </thead>
                        
                                <tbody>
                                    
                        
                            
                                @foreach ($planningScoresRatings as $row)
                                
                                    <tr data-indexPlanningIndcaotrId="{{ $row->id }}">
                                        <td width="3%"class="text-center">
                                            {{ $row->ref_no }}
                                        </td>
                                        <td class="col-md-3 text-start">
                                            {{ $row->indicator_name }}
                                            @if ($row->is_mandatory === 1)
                                                <span class="required-star">*</span>
                                            @endif
                                        </td>
                                        <td class="col-md-1 text-center td-comp-name"
                                            data-indicator-id="{{ $row->id }}">
                                            {{ $row->comp_name }}
                                        </td>
                                        <td class="col-md-1 text-center td-comp-score"
                                            data-indicator-id="{{ $row->id }}">
                                            {{ $row->complianceScore }}
                                        </td>
                                        <td class="col-md-1 text-center td-weightage"
                                            data-indicator-id="{{ $row->id }}">
                                            {{ number_format($row->indicatorWeightage, 0) }}%
                                        </td>

                                        <td class="col-md-3 text-start td-weightage"
                                            data-indicator-id="{{ $row->id }}">

                                            <div class="comments-container">
                                                <div class="text-muted">
                                                    @if ($row->comments->isEmpty())
                                                        <em>No comments yet.</em>
                                                    @else
                                                        @foreach ($row->comments as $comment)
                                                            <form id="comment_form_{{ $comment->id }}" method="POST"
                                                                class="mb-0">
                                                                @csrf

                                                                <div class="mb-2">
                                                                    <strong>{{ $comment->user->first_name ?? 'Unknown User' }}</strong>
                                                                    <br>
                                                                    <span
                                                                        class="small text-muted">{{ $comment->created_at->diffForHumans() }}</span>
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
                                                                <div class="modal fade"
                                                                    id="varyingcontentModal_{{ $comment->id }}"
                                                                    tabindex="-1"
                                                                    aria-labelledby="varyingcontentModalLabel_{{ $comment->id }}"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title"
                                                                                    id="varyingcontentModalLabel_{{ $comment->id }}">
                                                                                    Comment</h5>

                                                                            </div>
                                                                            <div class="status-message text-success mt-2"
                                                                                style="margin-left: 20px;"></div>
                                                                            <div class="modal-body">
                                                                                <form
                                                                                    id="comment_form_{{ $comment->id }}">
                                                                                    <div class="mb-3">
                                                                                        <textarea class="form-control" name="comments" id="comments_{{ $comment->id }}" rows="4">{{ $comment->comments }}</textarea>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-light btn-sm"
                                                                                    data-bs-dismiss="modal">
                                                                                    Close
                                                                                </button>
                                                                                <button class="btn btn-green-heading btn-sm"
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
                                                                                <input type="hidden" value="Planning"
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
                                                                                <input type="hidden"
                                                                                    value="{{ $comment->id }}"
                                                                                    name="comment_id">
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
                                                <button type="button" class="btn btn-green-heading btn-sm"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#createCommentModal_{{ $row->id }}"
                                                    data-bs-whatever="Comment">Comment</button>
                                            </div>

                                            <!-- Create commnet modal content -->
                                            <div class="modal fade" id="createCommentModal_{{ $row->id }}"
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
                                                                    <textarea class="form-control" name="comments" id="comments_{{ $row->id }}" rows="4"></textarea>
                                                                </div>

                                                                <!-- Hidden variables -->
                                                                <input type="hidden" value="Planning"
                                                                    name="comments_for">

                                                                <input type="hidden" value="{{ $row->id }}"
                                                                    name="indicator_id">

                                                                <input type="hidden" value="{{ $project->id }}"
                                                                    name="updatedProjectId">

                                                                <input type="hidden" value="{{ auth()->id() }}"
                                                                    name="user_id">

                                                            </form>

                                                        </div>

                                                        <div class="modal-footer">

                                                            <button type="button" class="btn btn-light btn-sm"
                                                                data-bs-dismiss="modal">
                                                                Close
                                                            </button>

                                                            <button class="btn btn-green-heading btn-sm" type="button"
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
                                
                                @endforeach
                                </tbody>
                            </table>
                    </div>



                    </div>
                </div>
                <div class="d-grid align-items-center py-3"
                    style="grid-template-columns: 1fr auto 1fr; column-gap: 12px;">

                    <!-- Left button -->
                    <div class="text-start">
                        <button type="button"
                            class="btn btn-light btn-sm btn-label prev-step"
                            data-prev="#step1"
                            onclick="window.location.href='{{ route('projects.planning', $project->id) }}'">
                            <i class="ri-arrow-left-line label-icon align-middle fs-16 me-2"></i>
                            Back to Planning
                        </button>
                    </div>

                    <!-- Center workflow actions -->
                    <div class="d-flex justify-content-center align-items-center">
                        @include('projects.workflow.actions', [
                            'project' => $project,
                            'phase' => 'planning'
                        ])
                    </div>

                    <!-- Right button -->
                    <div class="text-end">
                        <button type="button"
                            class="btn btn-primary btn-sm btn-label right next-step"
                            data-next="#step2"
                            onclick="window.location.href='{{ route('projects.design', $project->id) }}'">
                            Go to Design
                            <i class="ri-arrow-right-line label-icon align-middle fs-16 ms-2"></i>
                        </button>
                    </div>

                </div>

            </div><!-- end card-body -->
        </div><!-- end card -->
    </div><!-- end col -->

    
</x-tab-layout>
