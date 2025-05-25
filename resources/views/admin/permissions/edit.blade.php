@extends('layouts.admin')
@push('title', get_phrase('Edit Permission'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
<div class="ol-card p-4">
    <div class="ol-card-body">
        <h4 class="title fs-16px">{{ get_phrase('Edit Permission') }}</h4>
        <form action="{{ route('admin.permissions.update', $permission->id) }}" method="POST">
            @csrf
            @method('POST')
            <div class="form-group">
                <label for="name">{{ get_phrase('Permission Name') }}</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $permission->name }}" required>
            </div>
            <button type="submit" class="btn ol-btn-success mt-3">{{ get_phrase('Update Permission') }}</button>
        </form>
    </div>
</div>
@endsection

@push('js')
@endpush
