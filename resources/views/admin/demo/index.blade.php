@extends('layouts.admin')
@push('title', get_phrase('Demo Videos'))
@push('meta')@endpush
@push('css')@endpush

@section('content')
    <!-- Main section header and breadcrumb -->
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-12px px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-play-alt me-2"></i>
                    <span>{{ get_phrase('Demo Videos') }}</span>
                </h4>
                <a href="{{ route('admin.demo_videos.create') }}" class="btn ol-btn-primary d-flex align-items-center cg-10px">
                    <span class="fi-rr-plus"></span>
                    <span>{{ get_phrase('Add New Demo Video') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="ol-card p-4">
                <div class="ol-card-body">
                    <h5 class="mb-3">{{ get_phrase('Demo Video List') }}</h5>

                    @if(count($videos) > 0)
                        <div class="table-responsive">
                            <table class="table eTable eTable-2">
                                <thead>
                                    <tr>
                                        <th scope="col" width="5%">#</th>
                                        <th scope="col" width="15%">{{ get_phrase('Thumbnail') }}</th>
                                        <th scope="col">{{ get_phrase('Title') }}</th>
                                        <th scope="col">{{ get_phrase('Instructor') }}</th>
                                        <th scope="col">{{ get_phrase('Duration') }}</th>
                                        <th scope="col" width="15%">{{ get_phrase('Options') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($videos as $key => $video)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>
                                                <img src="{{ asset($video->thumbnail) }}" alt="{{ $video->title }}" class="img-fluid" style="max-height: 60px;">
                                            </td>
                                            <td>{{ $video->title }}</td>
                                            <td>{{ $video->instructor }}</td>
                                            <td>{{ $video->duration }}</td>
                                            <td>
                                                <div class="dropdown ol-icon-dropdown ol-icon-dropdown-transparent">
                                                    <button class="btn ol-btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <span class="fi-rr-menu-dots-vertical"></span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('admin.demo_videos.edit', $video->id) }}">
                                                                <i class="fi-rr-edit me-1"></i> {{ get_phrase('Edit') }}
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="#" onclick="confirmModal('{{ route('admin.demo_videos.delete', $video->id) }}')">
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
