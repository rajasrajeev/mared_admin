@extends('layouts.admin')
@push('title', get_phrase('Expense Categories'))
@push('meta')@endpush
@push('css')@endpush

@section('content')
    <!-- Main section header and breadcrumb -->
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-12px px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-list me-2"></i>
                    <span>{{ get_phrase('Expense Categories') }}</span>
                </h4>
                <a href="{{ route('admin.accounting.expense.index') }}" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                    <span class="fi-rr-arrow-left"></span>
                    <span>{{ get_phrase('Back to Expenses') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Form section for adding/editing categories -->
        <div class="col-md-4">
            <div class="ol-card p-4 mb-4">
                <div class="ol-card-body">
                    <h5 class="mb-3">
                        {{ isset($category) ? get_phrase('Edit Category') : get_phrase('Add New Category') }}
                    </h5>

                    @if(isset($category))
                        <form action="{{ route('admin.accounting.expense.category.update', $category->id) }}" method="post">
                    @else
                        <form action="{{ route('admin.accounting.expense.category.store') }}" method="post">
                    @endif
                        @csrf
                        <div class="fpb-7 mb-3">
                            <label class="form-label ol-form-label" for="title">{{ get_phrase('Category Title') }}</label>
                            <input type="text" class="form-control ol-form-control" name="title" id="title"
                                placeholder="{{ get_phrase('Enter category title') }}"
                                value="{{ isset($category) ? $category->title : old('title') }}" required>
                            @error('title')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="fpb-7">
                            <button type="submit" class="btn ol-btn-primary">
                                {{ isset($category) ? get_phrase('Update Category') : get_phrase('Add Category') }}
                            </button>

                            @if(isset($category))
                                <a href="{{ route('admin.accounting.expense.category') }}" class="btn ol-btn-outline-primary ms-2">
                                    {{ get_phrase('Cancel') }}
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- List section for showing categories -->
        <div class="col-md-8">
            <div class="ol-card p-4">
                <div class="ol-card-body">
                    <h5 class="mb-3">{{ get_phrase('Category List') }}</h5>

                    @if(count($categories) > 0)
                        <div class="table-responsive">
                            <table class="table eTable eTable-2">
                                <thead>
                                    <tr>
                                        <th scope="col" width="5%">#</th>
                                        <th scope="col">{{ get_phrase('Title') }}</th>
                                        <th scope="col" width="20%">{{ get_phrase('Options') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $key => $category_item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $category_item->title }}</td>
                                            <td>
                                                <div class="dropdown ol-icon-dropdown ol-icon-dropdown-transparent">
                                                    <button class="btn ol-btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <span class="fi-rr-menu-dots-vertical"></span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('admin.accounting.expense.category.edit', $category_item->id) }}">
                                                                <i class="fi-rr-edit me-1"></i> {{ get_phrase('Edit') }}
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="#" onclick="confirmModal('{{ route('admin.accounting.expense.category.delete', $category_item->id) }}')">
                                                                <i class="fi-rr-trash me-1"></i> {{ get_phrase('Delete') }}
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="empty_box text-center">
                            <img class="mb-3" width="150px" src="{{ asset('assets/backend/images/empty_box.png') }}" alt="">
                            <br>
                            <span class="">{{ get_phrase('No data found') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        "use strict";
        // Any additional JavaScript can go here
    </script>
@endpush
