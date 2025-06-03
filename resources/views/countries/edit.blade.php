@extends('_layouts.master')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Update Country</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('countries.index') }}">Manage Countries</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Country</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-body">
                <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                   @include('_includes.errors')
                    <form name="add_form" id="edit_form" method="post" action="{{ route('countries.update',$countryData->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-12 p-2">
                                        <label for="name">Name <span class="text-danger">*</span></label>
                                        <input type="text" name="country_name" class="form-control"
                                            value="{{old('country_name', $countryData->country_name)}}">
                                    </div>
                                 
                                    <div class="col-md-12 p-2">
                                        <button type="submit" id="submit" name="submit"
                                            class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
            <div class="card-footer"></div>
        </div>
    </section>
@endsection
