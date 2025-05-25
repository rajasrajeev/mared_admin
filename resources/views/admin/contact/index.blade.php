@extends('layouts.admin')
@push('title', get_phrase('User Groups'))
@push('meta')@endpush
@push('css')
<style>
    .accordion-button:not(.collapsed) {
        background-color: #f8f9fa;
        color: #0c63e4;
    }
    .level-2 .accordion-button {
        padding-left: 2rem;
        background-color: #f8f9fa;
    }
    .level-3 .accordion-button {
        padding-left: 3rem;
        background-color: #f1f3f5;
    }
    .level-4 {
        padding-left: 4rem;
        background-color: #e9ecef;
    }
    .user-count {
        font-size: 12px;
        color: #6c757d;
        margin-left: 8px;
    }
    .user-badge {
        font-size: 11px;
        padding: 3px 8px;
        margin-left: 10px;
    }
</style>
@endpush

@section('content')
    <!-- Main section header and breadcrumb -->
    <div class="ol-card radius-8px print-d-none">
        <div class="ol-card-body my-3 py-4 px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-users me-2"></i>
                    <span>{{ get_phrase('User Groups Hierarchy') }}</span>
                </h4>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="ol-card">
                <div class="ol-card-body p-3">
                    <div class="row print-d-none mb-3 mt-3 row-gap-3">
                        <div class="col-md-6 pt-2 pt-md-0">
                            <div class="custom-dropdown">
                                <!-- <button class="dropdown-header btn ol-btn-light">
                                    {{ get_phrase('Export') }}
                                    <i class="fi-rr-file-export ms-2"></i>
                                </button> -->
                                <ul class="dropdown-list">
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="downloadPDF('.print-table', 'user-hierarchy')">
                                            <i class="fi-rr-file-pdf"></i> {{ get_phrase('PDF') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="window.print();">
                                            <i class="fi-rr-print"></i> {{ get_phrase('Print') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <form action="{{ route('admin.contacts') }}" method="get">
                                <div class="row row-gap-3">
                                    <div class="col-md-9">
                                        <div class="search-input">
                                            <input type="text" name="search" value="{{ request('search') }}"
                                                placeholder="{{ get_phrase('Search User') }}" class="ol-form-control form-control" />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <button type="submit" class="btn ol-btn-primary w-100" id="submit-button">
                                            {{ get_phrase('Search') }}
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- User Hierarchy Accordion -->
                    <div class="accordion" id="userHierarchyAccordion">
                        @php
                            // Get all supervisors (created by admin)
                            $supervisors = App\Models\User::where('role', 'supervisor')->where('created_by', 1)->get();
                            $total_supervisors = $supervisors->count();
                        @endphp

                        @if($total_supervisors > 0)
                            @foreach($supervisors as $supervisor_key => $supervisor)
                                @php
                                    // Get team leaders under this supervisor
                                    $team_leaders = App\Models\User::where('role', 'teamleader')->where('created_by', $supervisor->id)->get();
                                    $team_leader_count = $team_leaders->count();
                                @endphp

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading-supervisor-{{ $supervisor->id }}">
                                        <button class="accordion-button @if($supervisor_key != 0) collapsed @endif" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse-supervisor-{{ $supervisor->id }}"
                                                aria-expanded="@if($supervisor_key == 0) true @else false @endif"
                                                aria-controls="collapse-supervisor-{{ $supervisor->id }}">
                                            <i class="fi-rr-user-shield me-2"></i>
                                            {{ $supervisor->name }}
                                            <span class="badge bg-info user-badge">{{ get_phrase('Supervisor') }}</span>
                                            <span class="ms-auto user-count">{{ get_phrase('Team Leaders') }}: {{ $team_leader_count }}</span>
                                        </button>
                                    </h2>

                                    <div id="collapse-supervisor-{{ $supervisor->id }}"
                                          class="accordion-collapse collapse @if($supervisor_key == 0) show @endif"
                                          aria-labelledby="heading-supervisor-{{ $supervisor->id }}"
                                          data-bs-parent="#userHierarchyAccordion">
                                        <div class="accordion-body p-0">
                                            <div class="accordion level-2" id="teamLeadersAccordion-{{ $supervisor->id }}">
                                                @if($team_leader_count > 0)
                                                    @foreach($team_leaders as $tl_key => $team_leader)
                                                        @php
                                                            // Get agents under this team leader
                                                            $agents = App\Models\User::where('role', 'agent')->where('created_by', $team_leader->id)->get();
                                                            $agent_count = $agents->count();
                                                        @endphp

                                                        <div class="accordion-item">
                                                            <h2 class="accordion-header" id="heading-tl-{{ $team_leader->id }}">
                                                                <button class="accordion-button collapsed" type="button"
                                                                        data-bs-toggle="collapse" data-bs-target="#collapse-tl-{{ $team_leader->id }}"
                                                                        aria-expanded="false" aria-controls="collapse-tl-{{ $team_leader->id }}">
                                                                    <i class="fi-rr-user-pen me-2"></i>
                                                                    {{ $team_leader->name }}
                                                                    <span class="badge bg-success user-badge">{{ get_phrase('Team Leader') }}</span>
                                                                    <span class="ms-auto user-count">{{ get_phrase('Agents') }}: {{ $agent_count }}</span>
                                                                </button>
                                                            </h2>

                                                            <div id="collapse-tl-{{ $team_leader->id }}"
                                                                  class="accordion-collapse collapse"
                                                                  aria-labelledby="heading-tl-{{ $team_leader->id }}"
                                                                  data-bs-parent="#teamLeadersAccordion-{{ $supervisor->id }}">
                                                                <div class="accordion-body p-0">
                                                                    <div class="accordion level-3" id="agentsAccordion-{{ $team_leader->id }}">
                                                                        @if($agent_count > 0)
                                                                            @foreach($agents as $agent_key => $agent)
                                                                                @php
                                                                                    // Get students under this agent
                                                                                    $students = App\Models\User::where('role', 'student')->where('created_by', $agent->id)->get();
                                                                                    $student_count = $students->count();
                                                                                @endphp

                                                                                <div class="accordion-item">
                                                                                    <h2 class="accordion-header" id="heading-agent-{{ $agent->id }}">
                                                                                        <button class="accordion-button collapsed" type="button"
                                                                                                data-bs-toggle="collapse" data-bs-target="#collapse-agent-{{ $agent->id }}"
                                                                                                aria-expanded="false" aria-controls="collapse-agent-{{ $agent->id }}">
                                                                                            <i class="fi-rr-user-tie me-2"></i>
                                                                                            {{ $agent->name }}
                                                                                            <span class="badge bg-warning user-badge">{{ get_phrase('Agent') }}</span>
                                                                                            <span class="ms-auto user-count">{{ get_phrase('Students') }}: {{ $student_count }}</span>
                                                                                        </button>
                                                                                    </h2>

                                                                                    <div id="collapse-agent-{{ $agent->id }}"
                                                                                          class="accordion-collapse collapse"
                                                                                          aria-labelledby="heading-agent-{{ $agent->id }}"
                                                                                          data-bs-parent="#agentsAccordion-{{ $team_leader->id }}">
                                                                                        <div class="accordion-body">
                                                                                            @if($student_count > 0)
                                                                                                <ul class="list-group level-4">
                                                                                                    @foreach($students as $student)
                                                                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                                                            <div>
                                                                                                                <i class="fi-rr-user me-2"></i>
                                                                                                                {{ $student->name }}
                                                                                                                <span class="badge bg-primary user-badge">{{ get_phrase('Student') }}</span>
                                                                                                            </div>
                                                                                                            <div class="text-muted small">
                                                                                                                {{ $student->email }}
                                                                                                            </div>
                                                                                                        </li>
                                                                                                    @endforeach
                                                                                                </ul>
                                                                                            @else
                                                                                                <div class="alert alert-light m-3">
                                                                                                    {{ get_phrase('No students found under this agent') }}
                                                                                                </div>
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        @else
                                                                            <div class="alert alert-light m-3">
                                                                                {{ get_phrase('No agents found under this team leader') }}
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="alert alert-light m-3">
                                                        {{ get_phrase('No team leaders found under this supervisor') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="alert alert-info">
                                {{ get_phrase('No supervisors found in the system') }}
                            </div>
                        @endif
                    </div>
                    <!-- End User Hierarchy Accordion -->

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    // Optional JavaScript for any additional functionality
    $(document).ready(function() {
        // Count total users
        let supervisorCount = {{ $total_supervisors ?? 0 }};
        $('#supervisorCount').text(supervisorCount);

        // You can add more JavaScript functionality here if needed
    });
</script>
@endpush
