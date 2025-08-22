

@extends('_layouts.master')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manage CSA Projects</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Manage Countries</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                 <form name="add_form" id="add_form" method="GET" action="{{ route('countries.create') }}">   
                                   
                                    <div class="col-md-12 p-2">
                                        <a href="{{ route('projects.create') }}" class="btn btn-primary">Create New Project</a>
                                       
                                    </div>
                                    </form>
                                </div>
                            </div>

                        </div>
        <div class="card">
            <div class="card-header" style="display: none;">
                <div class="d-flex justify-content-between">
                    <h2 class="card-title">Countries</h2>
                </div>
            </div>
            <div class="card-body">
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                 
                    @include('_includes.message')
                    @include('_includes.error')
                    @if (sizeof($data) > 0)
                        <table class="table table-striped mt-3">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                   <th>Phase</th>
                                   <th>Organization</th>
                                   <th>Date of GBA*</th>
                                   <th>Start Date</th>
                                   <th>End Date</th>
                                  <th>Building Type</th>
                                  <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $row)
                                    <tr>
                                        <td>{{ $row->project_name }}</td>
                                        <td>{{ $row->current_phase->phase_name }}</td>
                                        <td width="20%">{{ $row->organization->organization_name }}</td>
                                       <td>{{ Carbon\Carbon::parse($row->date_gpa)->format('F j, Y') }}</td>
                                       <td>{{ Carbon\Carbon::parse($row->start_date)->format('F j, Y') }}</td>
                                       <td>{{ Carbon\Carbon::parse($row->end_date)->format('F j, Y') }}</td>
                                       <td>{{ $row->building_type->type_name }}</td>
                                        <td>
                                        <a href="{{ route('projects.edit', $row->id) }}" class="btn btn-block btn-info btn-xs">EDIT</a>
                                        <form id="action_delete_{{ $row->id }}" action="" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-block btn-danger btn-xs" type="button"
                                                onclick="javascript: deleteRecordxx({{ $row->id }}, 'action_delete', '{{ route("countries.destroy", $row->id) }}');return false;">DELETE</button>
                                        </form> 
                                        
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @include('_includes.paging')
                    @else
                        @include('_includes.noinfo')
                    @endif
                </div>
            </div>
            <div class="card-footer"></div>
        </div>
    </section>
@endsection
@section('js-section')
@endsection

