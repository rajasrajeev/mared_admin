@extends('layouts.admin')
@push('title', get_phrase('Student Tree View'))
@push('meta')@endpush
@push('css')
<style>
    .tree-view {
        padding: 20px;
        font-family: Arial, sans-serif;
    }
    .tree-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }
    .tree-card {
        width: 100%;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        margin-bottom: 20px;
    }
    .tree-card-header {
        background-color: #f8f9fa;
        padding: 15px;
        border-bottom: 1px solid #dee2e6;
        border-radius: 8px 8px 0 0;
    }
    .tree-card-body {
        padding: 0;
    }
    .tree-nodes {
        list-style-type: none;
        padding: 0;
        margin: 0;
    }
    .tree-node {
        position: relative;
        padding: 12px 15px 12px 45px;
        border-bottom: 1px solid #f0f0f0;
    }
    .tree-node:last-child {
        border-bottom: none;
    }
    .tree-node:before {
        content: "";
        position: absolute;
        left: 25px;
        top: 50%;
        height: 100%;
        width: 1px;
        background-color: #ddd;
        transform: translateX(-50%);
    }
    .tree-node:first-child:before {
        height: 50%;
        top: 50%;
    }
    .tree-node:last-child:before {
        height: 50%;
        top: 0;
    }
    .tree-node:only-child:before {
        display: none;
    }
    .tree-node:after {
        content: "";
        position: absolute;
        left: 25px;
        top: 50%;
        width: 20px;
        height: 1px;
        background-color: #ddd;
    }
    .role-icon {
        margin-right: 10px;
    }
    .user-badge {
        font-size: 11px;
        padding: 3px 8px;
        margin-left: 10px;
    }
    .student-info {
        background-color: #f1f7ff;
        padding: 15px;
        border-radius: 8px 8px 0 0;
    }
    .filter-controls {
        margin-bottom: 20px;
    }
    .filter-btn {
        margin-right: 10px;
    }
    .filter-btn.active {
        background-color: #0c63e4;
        color: white;
    }
</style>
@endpush

@section('content')
    <!-- Main section header and breadcrumb -->
    <div class="ol-card radius-8px print-d-none">
        <div class="ol-card-body my-3 py-4 px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-sitemap me-2"></i>
                    <span>{{ get_phrase('Student Tree View') }}</span>
                </h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="ol-card">
                <div class="ol-card-body p-3">
                    <div class="row print-d-none mb-3 mt-3 row-gap-3">
                        <div class="col-md-6">
                            <form action="{{ route('admin.contacts.students') }}" method="get">
                                <div class="row row-gap-3">
                                    <div class="col-md-9">
                                        <div class="search-input">
                                            <input type="text" name="search" value="{{ request('search') }}"
                                                placeholder="{{ get_phrase('Search Student') }}" class="ol-form-control form-control" />
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

                        <div class="col-md-6">
                            <div class="filter-controls text-md-end">
                                <button class="btn ol-btn-light filter-btn active" data-filter="all">
                                    {{ get_phrase('All') }}
                                </button>
                                <button class="btn ol-btn-light filter-btn" data-filter="active">
                                    {{ get_phrase('Active') }}
                                </button>
                                <button class="btn ol-btn-light filter-btn" data-filter="inactive">
                                    {{ get_phrase('Inactive') }}
                                </button>
                            </div>
                        </div>
                    </div>

                    @php
                        // Get students based on search or get all
                        $query = App\Models\User::where('role', 'student');

                        if(request('search')) {
                            $search = request('search');
                            $query->where(function($q) use ($search) {
                                $q->where('name', 'like', '%'.$search.'%')
                                  ->orWhere('email', 'like', '%'.$search.'%');
                            });
                        }

                        $students = $query->paginate(10);
                        $total_students = $students->total();
                    @endphp

                    <div class="tree-view">
                        <!-- Search result count -->
                        @if(request('search'))
                            <div class="alert alert-info">
                                {{ get_phrase('Found') }} {{ $total_students }} {{ get_phrase('students matching') }} "{{ request('search') }}"
                            </div>
                        @endif

                        <div class="tree-container">
                            @if($total_students > 0)
                                @foreach($students as $student)
                                    @php
                                        // Get agent
                                        $agent = App\Models\User::where('id', $student->created_by)->where('role', 'agent')->first();

                                        // Get team leader
                                        $team_leader = $agent ? App\Models\User::where('id', $agent->created_by)->where('role', 'teamleader')->first() : null;

                                        // Get supervisor
                                        $supervisor = $team_leader ? App\Models\User::where('id', $team_leader->created_by)->where('role', 'supervisor')->first() : null;
                                    @endphp

                                    <div class="tree-card student-status-{{ $student->status }}">
                                        <div class="student-info">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h5>
                                                        <i class="fi-rr-user role-icon"></i>
                                                        {{ $student->name }}
                                                        <span class="badge bg-primary user-badge">{{ get_phrase('Student') }}</span>
                                                    </h5>
                                                    <p class="mb-0">{{ $student->email }}</p>
                                                </div>
                                                <div>
                                                    @if($student->status == 1)
                                                        <span class="badge bg-success">{{ get_phrase('Active') }}</span>
                                                    @else
                                                        <span class="badge bg-danger">{{ get_phrase('Inactive') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tree-card-body">
                                            <ul class="tree-nodes">
                                                @if($agent)
                                                <li class="tree-node">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <i class="fi-rr-user-tie role-icon"></i>
                                                            {{ $agent->name }}
                                                            <span class="badge bg-warning user-badge">{{ get_phrase('Agent') }}</span>
                                                        </div>
                                                        <div>
                                                            <small class="text-muted">{{ $agent->email }}</small>
                                                        </div>
                                                    </div>
                                                </li>
                                                @endif

                                                @if($team_leader)
                                                <li class="tree-node">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <i class="fi-rr-user-pen role-icon"></i>
                                                            {{ $team_leader->name }}
                                                            <span class="badge bg-success user-badge">{{ get_phrase('Team Leader') }}</span>
                                                        </div>
                                                        <div>
                                                            <small class="text-muted">{{ $team_leader->email }}</small>
                                                        </div>
                                                    </div>
                                                </li>
                                                @endif

                                                @if($supervisor)
                                                <li class="tree-node">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <i class="fi-rr-user-shield role-icon"></i>
                                                            {{ $supervisor->name }}
                                                            <span class="badge bg-info user-badge">{{ get_phrase('Supervisor') }}</span>
                                                        </div>
                                                        <div>
                                                            <small class="text-muted">{{ $supervisor->email }}</small>
                                                        </div>
                                                    </div>
                                                </li>
                                                @endif

                                                @if(!$agent && !$team_leader && !$supervisor)
                                                <li class="tree-node text-center text-muted">
                                                    {{ get_phrase('No management chain assigned') }}
                                                </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                @endforeach

                                <!-- Pagination -->
                                <div class="d-flex justify-content-center w-100 mt-4">
                                    {{ $students->links() }}
                                </div>
                            @else
                                <div class="alert alert-info w-100">
                                    {{ get_phrase('No students found') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        // Filter functionality
        $('.filter-btn').click(function() {
            $('.filter-btn').removeClass('active');
            $(this).addClass('active');

            var filter = $(this).data('filter');

            if (filter === 'all') {
                $('.tree-card').show();
            } else if (filter === 'active') {
                $('.tree-card').hide();
                $('.tree-card.student-status-1').show();
            } else if (filter === 'inactive') {
                $('.tree-card').hide();
                $('.tree-card.student-status-0').show();
            }
        });
    });
</script>
@endpush
