@extends('layouts.admin')

@push('title', get_phrase('Add Permission'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
<div class="ol-card p-4">
    <div class="ol-card-body">
        <h4 class="title fs-16px">{{ get_phrase('Add New Permission') }}</h4>
        <form action="{{ route('admin.permissions.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">{{ get_phrase('Permission Name') }}</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="slug">{{ get_phrase('Slug') }}</label>
                <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug') }}" required>
                @error('slug')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="route">{{ get_phrase('Route will automatically come when you choose the menu and submenu') }}</label>
                <input type="text" class="form-control" id="route" name="route" value="{{ old('route') }}" required readonly>
                @error('route')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="menu_id">{{ get_phrase('Select Menu') }}</label>
                <select class="form-control" id="menu_id" name="menu_id" required>
                    <option value="">{{ get_phrase('Select a Menu') }}</option>
                    @foreach($menus as $menu)
                        <option value="{{ $menu->id }}" data-route="{{ $menu->route }}" {{ old('menu_id') == $menu->id ? 'selected' : '' }}>
                            {{ $menu->name }}
                        </option>
                    @endforeach
                </select>
                @error('menu_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="submenu_id">{{ get_phrase('Select Submenu') }}</label>
                <select class="form-control" id="submenu_id" name="submenu_id" required>
                    <option value="">{{ get_phrase('Select a Submenu') }}</option>
                    @foreach($submenus as $submenu)
                        <option value="{{ $submenu->id }}" data-route="{{ $submenu->route }}" {{ old('submenu_id') == $submenu->id ? 'selected' : '' }}>
                            {{ $submenu->name }}
                        </option>
                    @endforeach
                </select>
                @error('submenu_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn ol-btn-primary mt-3">{{ get_phrase('Create Permission') }}</button>
        </form>
    </div>
</div>
@endsection

@push('js')
<script>
    // Function to update route field based on selected menu or submenu
    function updateRoute() {
        let menuId = document.getElementById('menu_id').value;
        let submenuId = document.getElementById('submenu_id').value;

        // If menu is selected, update route with menu route
        if (menuId) {
            let selectedMenu = document.querySelector(`#menu_id option[value="${menuId}"]`);
            document.getElementById('route').value = selectedMenu ? selectedMenu.getAttribute('data-route') : '';
        }
        // If submenu is selected, update route with submenu route
        else if (submenuId) {
            let selectedSubmenu = document.querySelector(`#submenu_id option[value="${submenuId}"]`);
            document.getElementById('route').value = selectedSubmenu ? selectedSubmenu.getAttribute('data-route') : '';
        }
    }

    // Add event listeners to menu and submenu change events
    document.getElementById('menu_id').addEventListener('change', updateRoute);
    document.getElementById('submenu_id').addEventListener('change', updateRoute);
</script>
@endpush
