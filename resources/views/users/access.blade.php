@extends('layouts.master')

@section('title')
    Access Overview
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            User Management
        @endslot
        @slot('title')
            Access Overview
        @endslot
    @endcomponent

    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-uppercase fw-medium text-muted mb-0">Total Users</p>
                        </div>
                        <div class="flex-shrink-0">
                            <i class="ri-group-line fs-3 text-primary"></i>
                        </div>
                    </div>
                    <h4 class="fs-22 fw-semibold mt-3 mb-0">{{ $totalUsers }}</h4>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <p class="text-uppercase fw-medium text-muted mb-0">Active Users</p>
                    <h4 class="fs-22 fw-semibold mt-3 mb-0 text-success">{{ $activeUsers }}</h4>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <p class="text-uppercase fw-medium text-muted mb-0">Inactive Users</p>
                    <h4 class="fs-22 fw-semibold mt-3 mb-0 text-danger">{{ $inactiveUsers }}</h4>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card card-animate">
                <div class="card-body">
                    <p class="text-uppercase fw-medium text-muted mb-0">Administrators</p>
                    <h4 class="fs-22 fw-semibold mt-3 mb-0 text-primary">{{ $adminUsers }}</h4>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
            <div>
                <h4 class="card-title mb-1">Role Access</h4>
                <p class="text-muted mb-0">
                    Current PGAP user-management authorization rules.
                </p>
            </div>

            <a href="{{ route('users.index') }}" class="btn btn-light">
                <i class="ri-arrow-left-line me-1"></i>
                Back to Users
            </a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Role</th>
                            <th class="text-center">Workflow Level</th>
                            <th>Description</th>
                            <th class="text-center">Users</th>
                            <th class="text-center">Manage Users</th>
                            <th class="text-center">Assign Super Admin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roleStats as $role)
                            <tr>
                                <td class="fw-semibold">{{ $role['name'] }}</td>
                                <td class="text-center">
                                    @if($role['level'])
                                        <span class="badge bg-info-subtle text-info">
                                            Level-{{ str_pad($role['level'], 2, '0', STR_PAD_LEFT) }}
                                        </span>
                                    @else
                                        <span class="text-muted">System</span>
                                    @endif
                                </td>
                                <td class="text-muted">{{ $role['description'] }}</td>
                                <td class="text-center">{{ $role['users'] }}</td>
                                <td class="text-center">
                                    @if($role['can_manage_users'])
                                        <span class="badge bg-success-subtle text-success">
                                            <i class="ri-check-line"></i> Yes
                                        </span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary">
                                            <i class="ri-close-line"></i> No
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($role['can_assign_super_admin'])
                                        <span class="badge bg-success-subtle text-success">
                                            <i class="ri-check-line"></i> Yes
                                        </span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary">
                                            <i class="ri-close-line"></i> No
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer">
            <div class="alert alert-info mb-0">
                <i class="ri-information-line me-1"></i>
                PGAP workflow follows Level-01 ACFP data entry → Level-02 Global AFP review → Level-03 designated CSA review → Level-04 CSA review.
                Admin and Super Admin remain system-management roles and are not workflow approval levels.
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
@endsection
