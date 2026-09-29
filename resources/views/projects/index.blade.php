@extends('layouts.master')
@section('title') @lang('translation.list-js') @endsection
@section('css')
<link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
@component('components.breadcrumb')
@slot('li_1') PGAP @endslot
@slot('title') All Projects @endslot
@endcomponent
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h4 class="text-green-heading">Project's Green Building Assurance Performances</h4>
            </div><!-- end card header -->

            <div class="card-body">
                <div class="listjs-table" id="customerList">
                    <div class="row g-4 mb-3">
                        <div class="col-sm-auto">
                            <div>
                                <a href="{{ route('projects.create') }}" class="btn btn-success add-btn"><i class="ri-add-line align-bottom me-1" ></i>Create Project</a>
                            </div>
                        </div>
                        <div class="col-sm">
                            <div class="d-flex justify-content-sm-end">
                                <div class="search-box ms-2">
                                    <input type="text" class="form-control search" placeholder="Search...">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive table-card mt-3 mb-1">
                        <table class="table align-middle table-nowrap" id="customerTable">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" style="width: 50px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                                        </div>
                                    </th>
                                    <th class="sort" data-sort="customer_name">Name</th>
                                    <th class="sort" data-sort="email">Phase</th>
                                    <th class="sort" data-sort="phone">Organization</th>
                                    <th class="sort" data-sort="date">Date of GBA*</th>
                                    <th class="sort" data-sort="status">Start Date</th>
                                    <th class="sort" data-sort="status">End Date</th>
                                    <th class="sort" data-sort="status">Building Type</th>
                                    <th class="sort" data-sort="action">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @foreach ($data as $row)
                                <tr>
                                    <th scope="row">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="chk_child" value="option1">
                                        </div>
                                    </th>
                                    <td class="id" ><a href="{{ route('projects.edit', $row->id) }}" class="fw-medium link-primary">{{ $row->project_name }}</a></td>
                                    <td class="status">
                                        {{ $row->current_phase->phase_name }}
                                    </td>
                                    <td class="customer_name">{{ $row->organization->organization_name }}</td>
                                    <td class="email">{{ Carbon\Carbon::parse($row->date_gpa)->format('F j, Y') }}</td>
                                    <td class="phone">{{ Carbon\Carbon::parse($row->start_date)->format('F j, Y') }}</td>
                                    <td class="date">{{ Carbon\Carbon::parse($row->end_date)->format('F j, Y') }}</td>
                                    <td class="status">{{ $row->building_type->type_name }}</td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <div class="edit">
                                                
                                                <a href="{{ route('projects.edit', $row->id) }}" class="btn btn-sm btn-success edit-item-btn">EDIT</a>
                                            </div>
                                            <div class="remove">
                                                <form id="action_delete_{{ $row->id }}" action="" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-danger remove-item-btn" data-bs-toggle="modal" data-bs-target="#deleteRecordModal"
                                                    onclick="javascript: deleteRecordxx({{ $row->id }}, 'action_delete', '{{ route("countries.destroy", $row->id) }}' );return false;">DELETE</button>
                                                </form> 
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="noresult" style="display: none">
                            <div class="text-center">
                                <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px">
                                </lord-icon>
                                <h5 class="mt-2">Sorry! No Result Found</h5>
                                <p class="text-muted mb-0">We've searched more than 150+ Projects We did not find any
                                    orders for you search.</p>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <div class="pagination-wrap hstack gap-2">
                            <a class="page-item pagination-prev disabled" href="javascript:void(0);">
                                Previous
                            </a>
                            <ul class="pagination listjs-pagination mb-0"></ul>
                            <a class="page-item pagination-next" href="javascript:void(0);">
                                Next
                            </a>
                        </div>
                    </div>
                </div>
            </div><!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!-- end col -->
</div>
<!-- end row -->

@endsection
@section('script')
<script src="{{ URL::asset('build/libs/prismjs/prism.js') }}"></script>
<script src="{{ URL::asset('build/libs/list.js/list.min.js') }}"></script>
<script src="{{ URL::asset('build/libs/list.pagination.js/list.pagination.min.js') }}"></script>

<!-- listjs init -->
<script src="{{ URL::asset('build/js/pages/listjs.init.js') }}"></script>

<script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
