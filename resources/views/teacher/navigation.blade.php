@php 
$current_route = Route::currentRouteName(); 
$user_permissions = user_permissions(); // Fetch user permissions
@endphp

<div class="sidebar-nav-area">
    <nav class="sidebar-nav">
        <ul class="px-14px pb-24px">

            @if (has_permission('view_dashboard'))
            <li class="sidebar-first-li {{ $current_route == 'teacher.dashboard' ? 'active' : '' }}">
                <a href="{{ route('teacher.dashboard') }}">
                    <span class="icon fi-rr-house-blank"></span>
                    <div class="text">
                        <span>{{ get_phrase('Dashboard') }}</span>
                    </div>
                </a>
            </li>
            @endif

            @if (has_permission('manage_courses'))
            <li class="sidebar-first-li first-li-have-sub @if ($current_route == 'teacher.courses' || $current_route == 'teacher.course.create' || $current_route == 'teacher.course.edit') active showMenu @endif">
                <a href="javascript:void(0);">
                    <span class="icon fi fi-rr-e-learning"></span>
                    <div class="text">
                        <span>{{ get_phrase('Course') }}</span>
                    </div>
                </a>
                <ul class="first-sub-menu">
                    <li class="first-sub-menu-title fs-14px mb-18px">{{ get_phrase('Course') }}</li>
                    <li class="sidebar-second-li @if ($current_route == 'teacher.courses' || $current_route == 'teacher.course.edit') active @endif">
                        <a href="{{ route('teacher.courses') }}">{{ get_phrase('Manage Courses') }}</a>
                    </li>
                    <li class="sidebar-second-li @if ($current_route == 'teacher.course.create') active @endif">
                        <a href="{{ route('teacher.course.create') }}">{{ get_phrase('Add New Course') }}</a>
                    </li>
                </ul>
            </li>
            @endif

            @if (has_permission('view_sales'))
            <li class="sidebar-first-li {{ $current_route == 'teacher.sales.report' ? 'active' : '' }}">
                <a href="{{ route('teacher.sales.report') }}">
                    <span class="icon fi fi-sr-arrow-trend-up"></span>
                    <div class="text">
                        <span>{{ get_phrase('Sales') }}</span>
                    </div>
                </a>
            </li>
            @endif

            @if (has_permission('manage_profile'))
            <li class="sidebar-first-li {{ $current_route == 'teacher.manage.profile' ? 'active' : '' }}">
                <a href="{{ route('teacher.manage.profile') }}">
                    <span class="icon fi-rr-circle-user"></span>
                    <div class="text">
                        <span>{{ get_phrase('Manage Profile') }}</span>
                    </div>
                </a>
            </li>
            @endif

            <!-- Add more menu items based on permissions -->
        </ul>
    </nav>
</div>
