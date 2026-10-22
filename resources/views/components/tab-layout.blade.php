@props(['project'])
{{-- This is the wrapper layout for all tabs --}}
@extends('layouts.master')

@section('title')
    @lang('translation.wizard')
@endsection

@section('content')
    
@php
    $workflowRoleId = (int) auth()->user()->role_id;
    $workflowIsManagement = in_array($workflowRoleId, [1, 2, 6], true);
    $workflowCanSeeDesign = $workflowIsManagement
        || ! in_array($workflowRoleId, [3, 4, 5], true)
        || (($project->planning_workflow_status ?? 'draft') === 'reviewed');
    $workflowCanSeeConstruction = $workflowIsManagement
        || ! in_array($workflowRoleId, [3, 4, 5], true)
        || (($project->design_workflow_status ?? 'draft') === 'reviewed');
@endphp

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                
                <div class="card-body py-1">
                    {{-- Tabs Navigation --}}
                    <div class="step-arrow-nav mb-1 project-tabs-wrapper">
                        <ul class="nav nav-pills flex-nowrap mb-2" id="wizardSteps">
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
                            
                            @if ($workflowCanSeeDesign)
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('projects.design') ? 'active' : '' }}" href="{{ route('projects.design', $project->id) }}">Design</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('projects.designreview') ? 'active' : '' }}" href="{{ route('projects.designreview', $project->id) }}">Design Review</a>
                                </li>
                            @endif
                            
                            @if ($workflowCanSeeConstruction)
                            
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('projects.construction') ? 'active' : '' }}" href="{{ route('projects.construction', $project->id) }}">Construction</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('projects.consreview') ? 'active' : '' }}" href="{{ route('projects.consreview', $project->id) }}">Construction Review</a>
                                </li>
                            @endif
                        
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
