@extends('layouts.admin')
@push('title', get_phrase('Add Demo Video'))
@push('meta')@endpush
@push('css')
<link rel="stylesheet" href="{{ asset('assets/backend/css/dropzone.min.css') }}">
@endpush

@section('content')
    <!-- Main section header and breadcrumb -->
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-12px px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-plus me-2"></i>
                    <span>{{ get_phrase('Add Demo Video') }}</span>
                </h4>
                <a href="{{ route('admin.demo_videos.index') }}" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                    <span class="fi-rr-arrow-left"></span>
                    <span>{{ get_phrase('Back to Demo Videos') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="ol-card p-4">
                <div class="ol-card-body">
                    <form action="{{ route('admin.demo_videos.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="fpb-7 mb-3">
                                    <label class="form-label ol-form-label" for="title">{{ get_phrase('Title') }} <span class="required">*</span></label>
                                    <input type="text" class="form-control ol-form-control" name="title" id="title"
                                        placeholder="{{ get_phrase('Enter video title') }}"
                                        value="{{ old('title') }}" required>
                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="fpb-7 mb-3">
                                    <label class="form-label ol-form-label" for="subject_id">{{ get_phrase('Subject') }}</label>
                                    <select class="form-select ol-form-select" name="subject_id" id="subject_id">
                                        <option value="">{{ get_phrase('Select a subject') }}</option>
                                        @foreach($subjects as $subject)
                                            <option value="{{ $subject->id }}" {{ old(key: 'subject_id') == $subject->id ? 'selected' : '' }}>
                                                {{ $subject->title }} {{ $subject->category ? '('.$subject->category->title.')' : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('subject_id')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="fpb-7 mb-3">
                                    <label class="form-label ol-form-label" for="instructor">{{ get_phrase('Instructor') }} <span class="required">*</span></label>
                                    <input type="text" class="form-control ol-form-control" name="instructor" id="instructor"
                                        placeholder="{{ get_phrase('Enter instructor name') }}"
                                        value="{{ old('instructor') }}" required>
                                    @error('instructor')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="fpb-7 mb-3">
                                    <label class="form-label ol-form-label" for="duration">{{ get_phrase('Duration') }} <span class="required">*</span></label>
                                    <input type="text" class="form-control ol-form-control" name="duration" id="duration"
                                        placeholder="{{ get_phrase('e.g. 10:30') }}"
                                        value="{{ old('duration') }}" required>
                                    @error('duration')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="fpb-7 mb-3">
                                    <label class="form-label ol-form-label">{{ get_phrase('Thumbnail') }} <span class="required">*</span></label>
                                    <div class="thumbnail-upload-box">
                                        <input type="hidden" name="thumbnail" id="thumbnail" value="{{ old('thumbnail') }}" required>
                                        <div id="thumbnail_dropzone" class="dropzone">
                                            <div class="dz-message needsclick">
                                                <i class="fi-rr-upload mb-2"></i>
                                                <h5>{{ get_phrase('Drop files here or click to upload') }}</h5>
                                                <span class="note needsclick">{{ get_phrase('Upload thumbnail image (JPG, PNG)') }}</span>
                                            </div>
                                        </div>
                                        <div id="thumbnail_preview" class="mt-2" style="{{ old('thumbnail') ? '' : 'display: none;' }}">
                                            @if(old('thumbnail'))
                                                <img src="{{ asset(old('thumbnail')) }}" alt="Thumbnail" class="img-fluid" style="max-height: 150px;">
                                            @endif
                                        </div>
                                        @error('thumbnail')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="fpb-7 mb-3">
                                    <label class="form-label ol-form-label">{{ get_phrase('Video File') }} <span class="required">*</span></label>
                                    <div class="video-upload-box">
                                        <input type="hidden" name="video_url" id="video_url" value="{{ old('video_url') }}" required>
                                        <div id="video_dropzone" class="dropzone">
                                            <div class="dz-message needsclick">
                                                <i class="fi-rr-upload mb-2"></i>
                                                <h5>{{ get_phrase('Drop files here or click to upload') }}</h5>
                                                <span class="note needsclick">{{ get_phrase('Upload video file (MP4, WebM)') }}</span>
                                            </div>
                                        </div>
                                        <div class="progress mt-2" style="display: none;">
                                            <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div id="video_preview" class="mt-2" style="{{ old('video_url') ? '' : 'display: none;' }}">
                                            @if(old('video_url'))
                                                <div class="alert alert-success">
                                                    <i class="fi-rr-check-circle me-1"></i>
                                                    {{ get_phrase('Video uploaded successfully') }}
                                                </div>
                                            @endif
                                        </div>
                                        @error('video_url')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="fpb-7 mt-2">
                                    <button type="submit" class="btn ol-btn-primary" id="submit_btn">
                                        {{ get_phrase('Add Demo Video') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script src="{{ asset('assets/backend/js/dropzone.min.js') }}"></script>
<script>
    "use strict";

    // Thumbnail upload
    Dropzone.autoDiscover = false;
    var thumbnailDropzone = new Dropzone("#thumbnail_dropzone", {
        url: "{{ route('admin.demo_videos.upload.thumbnail') }}",
        method: "post",
        paramName: "thumbnail_file",
        maxFiles: 1,
        maxFilesize: 5, // MB
        acceptedFiles: "image/*",
        headers: {
            'X-CSRF-TOKEN':  "{{ csrf_token() }}"
        },
        success: function(file, response) {
            $("#thumbnail").val(response.file_path);

            // Show preview
            $("#thumbnail_preview").html('<img src="' + window.location.origin + '/' + response.file_path + '" alt="Thumbnail" class="img-fluid" style="max-height: 150px;">');
            $("#thumbnail_preview").show();

            // Mark the file as accepted
            file.previewElement.classList.add("dz-success");
        },
        error: function(file, response) {
            file.previewElement.classList.add("dz-error");
            if (typeof response === "string") {
                file.previewElement.querySelector(".dz-error-message").textContent = response;
            } else {
                file.previewElement.querySelector(".dz-error-message").textContent = response.error || "Upload failed";
            }
        }
    });

    // Video upload with progress indicator
    var videoDropzone = new Dropzone("#video_dropzone", {
        url: "{{ route('admin.demo_videos.upload.video') }}",
        method: "post",
        paramName: "video_file",
        maxFiles: 1,
        maxFilesize: 500, // MB
        acceptedFiles: "video/*",
        headers: {
            'X-CSRF-TOKEN':  "{{ csrf_token() }}"
        },
        uploadprogress: function(file, progress, bytesSent) {
            // Show progress bar
            $('.progress').show();
            $('.progress-bar').css('width', progress + '%').attr('aria-valuenow', progress);
            $('.progress-bar').text(Math.round(progress) + '%');
        },
        success: function(file, response) {
            $("#video_url").val(response.file_path);

            // Show success message
            $("#video_preview").html('<div class="alert alert-success"><i class="fi-rr-check-circle me-1"></i>{{ get_phrase("Video uploaded successfully") }}</div>');
            $("#video_preview").show();

            // Hide progress bar after a moment
            setTimeout(function() {
                $('.progress').hide();
            }, 2000);

            // Mark the file as accepted
            file.previewElement.classList.add("dz-success");
        },
        error: function(file, response) {
            // Hide progress bar
            $('.progress').hide();

            file.previewElement.classList.add("dz-error");
            if (typeof response === "string") {
                file.previewElement.querySelector(".dz-error-message").textContent = response;
            } else {
                file.previewElement.querySelector(".dz-error-message").textContent = response.error || "Upload failed";
            }
        }
    });
</script>
@endpush
