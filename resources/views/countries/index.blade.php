

@extends('_layouts.master')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Manage Countries</h1>
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
                                        <button type="submit" id="submit" name="submit"
                                            class="btn btn-primary" >Create New</button>
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
                                    <th>Name
                                        
                                    </th>
                                   <th>ID
                                   </th>
                                    <th>Updated On
                                       
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $row)
                                    <tr>
                                        <td>{{ $row->country_name }}</td>
                                        <td>{{ $row->id }}</td>
                                       
                                        <td>{{ Carbon\Carbon::parse($row->updated_at)->format('F j, Y, g:i a') }}</td>
                                        <td>
                                        <!-- <a href="{{ URL::signedRoute('countries.edit', $row->id) }}">EDIT</a> -->
                                        <a href="{{ route('countries.edit', $row->id) }}">EDIT</a>
                                        </td>
                                         <td>
                                       
                                       <form id="action_delete_{{ $row->id }}" action="" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" type="button"
                                                onclick="javascript: deleteRecord({{ $row->id }}, 'action_delete', '{{ route("countries.destroy", $row->id) }}');return false;">Delete</button>
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

