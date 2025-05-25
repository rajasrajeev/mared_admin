@extends('layouts.admin')

@push('title', get_phrase('Edit Course Type'))

@push('meta')
@endpush

@push('css')
@endpush

@section('content')
    <div class="ol-card radius-8px mb-3">
        <div class="ol-card-body my-3 py-12px px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Edit Course Type') }}
                </h4>
                <a href="{{ route('admin.coursetype.price.index') }}" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                    <i class="fi-rr-arrow-left"></i>
                    <span>{{ get_phrase('Back to Course Types') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="ol-card p-4">
        <div class="ol-card-body">
            <form action="{{ route('admin.coursetype.price.update') }}" method="post" class="row">
                @csrf
                <input type="hidden" name="id" value="{{ $courseType->id }}">

                <div class="col-md-12 mb-3">
                    <label for="name" class="ol-form-label">{{ get_phrase('Name') }} <span class="required">*</span></label>
                    <input type="text" class="form-control ol-form-control @error('name') is-invalid @enderror" id="name" name="name"
                        placeholder="{{ get_phrase('Enter course type name') }}" value="{{ old('name', $courseType->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-12 mb-3">
                    <label for="class_id" class="form-label ol-form-label col-sm-2 col-form-label">{{ get_phrase('Category') }}<span class="text-danger ms-1">*</span></label>
                    <!-- <div class="col-sm-10"> -->
                        <select class="form-control ol-form-control ol-select2" name="class_id" id="class_id" required>
                            <option value="">{{ get_phrase('Select a category') }}</option>
                            @foreach (App\Models\Category::where('parent_id', 0)->orderBy('title', 'desc')->get() as $category)
                                <option value="{{ $category->id }}" {{ old('class_id', $courseType->class_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->title }}
                                </option>

                                @foreach ($category->childs as $sub_category)
                                    <option value="{{ $sub_category->id }}" {{ old('class_id', $courseType->class_id) == $sub_category->id ? 'selected' : '' }}>
                                        -- {{ $sub_category->title }}
                                    </option>
                                @endforeach
                            @endforeach
                        </select>
                    <!-- </div> -->
                </div>

                <div class="col-md-12 mb-3">
                    <label for="price" class="ol-form-label">{{ get_phrase('Price') }} <span class="required">*</span></label>
                    <div class="input-group">
                        <input type="number" step="0.01" min="0" class="form-control ol-form-control @error('price') is-invalid @enderror" id="price" name="price"
                            placeholder="{{ get_phrase('Enter price') }}" value="{{ old('price', $courseType->price) }}" required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-12 mt-3">
                    <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Update Course Type') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
@endpush
