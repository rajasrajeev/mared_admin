@extends('layouts.admin')
@push('title', get_phrase('Assign Permissions'))
@push('meta')
@endpush
@push('css')
<style>
    .permission-group {
        margin-bottom: 20px;
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 15px;
    }

    .permission-group-title {
        font-weight: 600;
        margin-bottom: 15px;
        padding-bottom: 8px;
        border-bottom: 1px solid #eee;
    }

    .permission-item {
        padding: 8px;
        border: 1px solid #eaeaea;
        border-radius: 4px;
        background-color: #f9f9f9;
        margin-bottom: 12px;
    }

    .form-check-label {
        margin-left: 8px;
        user-select: none;
    }
</style>
@endpush

@section('content')
<div class="ol-card radius-8px">
    <div class="ol-card-body my-3 py-12px px-20px">
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
            <h4 class="title fs-16px">
                <i class="fi-rr-lock me-2"></i>
                {{ get_phrase('Assign Permissions to Role: ' . $role->name) }}
            </h4>

            <a href="{{ route('admin.roles.index') }}" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                <span class="fi-rr-arrow-left"></span>
                <span>{{ get_phrase('Back to Roles') }}</span>
            </a>
        </div>
    </div>
</div>

<div class="ol-card p-4">
    <div class="ol-card-body">
        <!-- Assign Permissions Form -->
        <form action="{{ route('admin.roles.assign.permissions', $role->id) }}" method="POST">
            @csrf

            <!-- Group permissions by category -->
            @php
                // Group permissions by their module/prefix
                $groupedPermissions = $permissions->groupBy(function($permission) {
                    // Extract category from permission name (example: user.create -> user)
                    $parts = explode('.', $permission->name);
                    return $parts[0];
                })->sortKeys();
            @endphp

            <div class="row">
                @foreach ($groupedPermissions as $group => $items)
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="permission-group">
                            <h6 class="permission-group-title text-capitalize">{{ $group }}</h6>

                            @foreach ($items->sortBy('name') as $permission)
                                <div class="permission-item">
                                    <div class="form-check">
                                        <input
                                            class="form-check-input"
                                            type="checkbox"
                                            name="permissions[]"
                                            value="{{ $permission->id }}"
                                            id="permission-{{ $permission->id }}"
                                            @if ($role->permissions->contains($permission->id)) checked @endif
                                        >
                                        <label class="form-check-label" for="permission-{{ $permission->id }}">
                                            @php
                                                // Display only the action part (example: user.create -> Create)
                                                $parts = explode('.', $permission->name);
                                                $action = end($parts);
                                                echo ucfirst($action);
                                            @endphp
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Save Permissions') }}</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
@endpush
