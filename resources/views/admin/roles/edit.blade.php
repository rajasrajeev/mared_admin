@extends('layouts.admin')

@push('title', get_phrase('Edit Role'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
<div class="ol-card p-4">
    <div class="ol-card-body">
        <h4 class="title fs-16px">{{ get_phrase('Edit Role') }}</h4>
        <form action="{{ route('admin.roles.update', $role->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">{{ get_phrase('Role Name') }}</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $role->name }}" required>
            </div>
            <button type="submit" class="btn ol-btn-primary mt-3">{{ get_phrase('Update Role') }}</button>
        </form>
    </div>
</div>
@endsection
