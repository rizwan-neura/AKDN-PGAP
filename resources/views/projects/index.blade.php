@extends('layouts.master')
@section('title') @lang('translation.list-js') @endsection
@section('css')
<link href="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            

            <div class="card-body">
                <div class="listjs-table" id="customerList">
                    <div class="row g-4 mb-3">
                        
                        <div class="col-sm-auto">
                            <div>
                                <a href="{{ route('projects.create') }}" class="btn btn-green-heading btn-sm add-btn"><i class="ri-add-line align-bottom me-1" ></i>Create Project</a>
                            </div>
                        </div>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}

                            <button type="button"
                                    class="btn-close"
                                    data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="table-responsive table-card mt-3 mb-1">
                        <table class="table table-sm align-middle table-nowrap" id="allProjectsTable">
                            <thead class="table-light">
                                <tr>
                                    
                                    <th  data-sort="customer_name">Name</th>
                                    <th  data-sort="email">Phase</th>
                                    <th  data-sort="phone">Organization</th>
                                    <th  data-sort="phone">Country</th>
                                    <th data-sort="date">Date of GBA*</th>
                                    <th  data-sort="status">Start Date</th>
                                    <th  data-sort="status">End Date</th>
                                    <th  data-sort="status">Building Type</th>
                                    <th>Created By</th>
                                    <th  data-sort="action">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @foreach ($data as $row)
                                <tr>
                                    
                                    <td class="id" ><a href="{{ route('projects.edit', $row->id) }}" class="fw-medium link-primary">{{ $row->project_name }}</a></td>
                                    <td class="status">
                                        {{ $row->current_phase->phase_name }}
                                    </td>
                                    <td class="customer_name">{{ $row->organization->organization_name }}</td>
                                    <td>
                                        {{ trim(($row->country_name )) }}
                                    </td>
                                    <td class="email">{{ Carbon\Carbon::parse($row->date_gpa)->format('F j, Y') }}</td>
                                    <td class="phone">{{ Carbon\Carbon::parse($row->start_date)->format('F j, Y') }}</td>
                                    <td class="date">{{ Carbon\Carbon::parse($row->end_date)->format('F j, Y') }}</td>
                                    <td class="status">
                                        {{ trim(($row->building_type->type_name ?? '')) ?: 'N/A' }}

                                    </td>
                                    <td>
                                        {{ trim(($row->creator_first_name ?? '') . ' ' . ($row->creator_last_name ?? '')) ?: 'N/A' }}
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">

                                            {{-- Edit --}}
                                            <div>
                                                <a href="{{ route('projects.edit', $row->id) }}"
                                                   class="btn btn-sm btn-soft-success"
                                                   title="Edit Project">
                                                    <i class="ri-pencil-fill"></i>
                                                </a>
                                            </div>
                                    
                                            {{-- Delete: Super Admin only --}}
                                            @if ((int) auth()->user()->role_id === 1)
                                                <div>
                                                    <form action="{{ route('projects.destroy', $row->id) }}"
                                                        method="POST"
                                                        class="delete-project-form">
                                                      @csrf
                                                      @method('DELETE')
                                                  
                                                      <button type="submit"
                                                              class="btn btn-sm btn-soft-danger"
                                                              title="Delete Project">
                                                          <i class="ri-delete-bin-line"></i>
                                                      </button>
                                                  </form>
                                                </div>
                                            @endif
                                    
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
                        {{ $data->links() }}
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
<script src="{{ URL::asset('build/libs/list.pagination.js/list.pagination.min.js') }}"></script>

<script src="{{ URL::asset('build/libs/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ URL::asset('build/js/app.js') }}"></script>

<script>
    document.querySelectorAll('.delete-project-form').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: 'Are you sure, you want to delete this project?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it',
                cancelButtonText: 'Cancel'
            }).then(function (result) {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>

@endsection
