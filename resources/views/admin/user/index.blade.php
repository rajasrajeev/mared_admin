@extends('layouts.admin')
@push('title', get_phrase('Manage Users'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
<div class="ol-card radius-8px">
    <div class="ol-card-body my-3 py-12px px-20px">
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
            <h4 class="title fs-16px">
                <i class="fi-rr-users me-2"></i>
                {{ get_phrase('User Management') }}
            </h4>

            <a href="{{ route('admin.users.create') }}" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                <span class="fi-rr-plus"></span>
                <span>Create User</span>
            </a>
        </div>
    </div>
</div>

<div class="ol-card p-4">
    <div class="ol-card-body">
        <div class="row print-d-none mb-3 mt-3 row-gap-3">
            <div class="col-md-6 pt-2 pt-md-0">
                <div class="custom-dropdown">
                    <button class="dropdown-header btn ol-btn-light">
                        {{ get_phrase('Export') }}
                        <i class="fi-rr-file-export ms-2"></i>
                    </button>
                    <ul class="dropdown-list">
                        <li>
                            <a class="dropdown-item" href="#" onclick="downloadPDF('.print-table', 'user-list')"><i class="fi-rr-file-pdf"></i> {{ get_phrase('PDF') }}</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" onclick="window.print();"><i class="fi-rr-print"></i> {{ get_phrase('Print') }}</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="col-md-6">
                <form class="form-inline" action="{{ route('admin.users.manage') }}" method="get">
                    <div class="row row-gap-3">
                        <div class="col-md-9">
                            <input type="text" class="form-control ol-form-control" name="search" value="{{ request('search') }}" placeholder="{{ get_phrase('Search user') }}" />
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn ol-btn-primary w-100" id="submit-button">{{ get_phrase('Search') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-md-12">
                @if ($users->count() > 0)
                    <div class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                        <p class="admin-tInfo">
                            {{ get_phrase('Showing') . ' ' . count($users) . ' ' . get_phrase('of') . ' ' . $users->total() . ' ' . get_phrase('data') }}
                        </p>
                    </div>
                    <div class="table-responsive course_list" id="course_list">
                        <table class="table eTable eTable-2 print-table">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">{{ get_phrase('User Name') }}</th>
                                    <th scope="col">{{ get_phrase('Email') }}</th>
                                    <th class="print-d-none" scope="col">{{ get_phrase('Role') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $key => $user)
                                    <tr>
                                        <th scope="row">
                                            <p class="row-number">{{ $key + 1 }}</p> <!-- Adjusted for pagination -->
                                        </th>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->role_name }}</td>
                                        <td class="">
                                            <div class="d-flex gap-2">
                                                <!-- Edit Icon -->
                                                <a href="{{ route('admin.users.edit', ['id' => $user->id]) }}" class="text-primary" title="{{ get_phrase('Edit') }}">
                                                    <i class="fi-rr-edit"></i>
                                                </a>

                                                <!-- Delete Icon -->
                                                <a href="javascript:void(0)" onclick="confirmModal('{{ route('admin.users.delete', ['id' => $user->id]) }}')" class="text-danger" title="{{ get_phrase('Delete') }}">
                                                    <i class="fi-rr-trash"></i>
                                                </a>

                                                <!-- Assign Roles Icon -->
                                                <a href="{{ route('admin.users.roles', ['userId' => $user->id]) }}" class="text-warning" title="{{ get_phrase('Assign Roles') }}">
                                                    <i class="fi-rr-user"></i>
                                                </a>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    @include('admin.no_data')
                @endif

                @if ($users->count() > 0)
                    <div class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                        <p class="admin-tInfo">
                            {{ get_phrase('Showing') . ' ' . $users->count() . ' ' . get_phrase('of') . ' ' . $users->total() . ' ' . get_phrase('data') }}
                        </p>
                        {{ $users->links() }} <!-- Pagination links -->
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>




@endsection

@push('js')
@endpush
