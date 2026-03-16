@props(['project'])
{{-- This is the wrapper layout for all tabs --}}
@extends('layouts.master')

@section('title')
    @lang('translation.wizard')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1') Forms @endslot
        @slot('title') PGAP - Tool @endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="text-green-heading">Project's Green Building Assurance Performances</h4>
                </div>
                <div class="card-body">
                    {{-- Tabs Navigation --}}
                    <div class="step-arrow-nav mb-4">
                        <ul class="nav nav-pills mb-3" id="wizardSteps">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('projects.edit') ? 'active' : '' }}" href="{{ route('projects.edit', $project->id) }}">Create Project</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('projects.esummary') ? 'active' : '' }}" href="{{ route('projects.esummary', $project->id) }}">Executive Summary</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('projects.checklist') ? 'active' : '' }}" href="{{ route('projects.checklist', $project->id) }}">Enviromental Requirements checklist</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('projects.planning') ? 'active' : '' }}" href="{{ route('projects.planning', $project->id) }}">Planning</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('projects.planningreview') ? 'active' : '' }}" href="{{ route('projects.planningreview', $project->id) }}">Planning Review</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('projects.design') ? 'active' : '' }}" href="{{ route('projects.design', $project->id) }}">Design</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('projects.designreview') ? 'active' : '' }}" href="{{ route('projects.designreview', $project->id) }}">Design Review</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('projects.construction') ? 'active' : '' }}" href="{{ route('projects.construction', $project->id) }}">Construction</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('projects.consreview') ? 'active' : '' }}" href="{{ route('projects.consreview', $project->id) }}">Construction Review</a>
                            </li>
                        </ul>
                    </div>

                    {{-- Alerts --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    {{-- Main Content Slot --}}
                    <div class="tab-content">
                        {{ $slot }}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('build/js/pages/form-wizard.init.js') }}"></script>
    <script src="{{ URL::asset('build/js/app.js') }}"></script>
   
    <script> // This script is used on CREATE Project TAB while editing.....
        document.addEventListener('DOMContentLoaded', function () {
            const reviewedBefore = document.getElementById('reviewed_before');
            const reviewedPhase = document.getElementById('reviewed_phase');
            const nextPhase = document.getElementById('next_phase');
            const phaseRow = document.getElementById('phase_row');

            // Show/hide phase row
            reviewedBefore.addEventListener('change', function () {
                if (this.value === 'YES') {
                    phaseRow.style.display = '';
                } else {
                    phaseRow.style.display = 'none';
                    reviewedPhase.value = '';
                }
            });

            // Redirect based on logic
            nextPhase.addEventListener('change', function () {
                if (reviewedBefore.value === 'YES' && nextPhase.value === 'YES') {
                    if (reviewedPhase.value === 'Planning') {
                        // Redirect to Design tab
                        window.location.href = "{{ route('projects.design', $project->id) }}";
                    } else if (reviewedPhase.value === 'Design') {
                        // Redirect to Construction tab
                        window.location.href = "{{ route('projects.construction', $project->id) }}";
                    }
                    // No redirect if it's already Construction
                }
            });
        });
    </script>

@endsection
