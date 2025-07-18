@extends('layouts.admin')
@push('title', get_phrase('Student'))
@push('meta')
@endpush
@push('css')
@endpush
@section('content')
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-12px px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Student List') }}
                </h4>

                <a href="{{ route('admin.student.create') }}" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                    <span class="fi-rr-plus"></span>
                    <span>{{ get_phrase('Add new Student') }}</span>
                </a>
            </div>
        </div>
    </div>
    <div class="ol-card p-4">
        <div class="ol-card-body">

            <div class="row print-d-none mb-3 mt-3 row-gap-3">
                <div class="col-md-6  pt-2 pt-md-0">
                    <div class="custom-dropdown">
                        <button class="dropdown-header btn ol-btn-light">
                            {{ get_phrase('Export') }}
                            <i class="fi-rr-file-export ms-2"></i>
                        </button>
                        <ul class="dropdown-list">
                            <li>
                                <a class="dropdown-item" href="#" onclick="downloadPDF('.print-table', 'student-list')"><i class="fi-rr-file-pdf"></i> {{ get_phrase('PDF') }}</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#" onclick="window.print();"><i class="fi-rr-print"></i> {{ get_phrase('Print') }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6">
                    <form class="form-inline" action="{{ route('admin.student.index') }}" method="get">
                        <div class="row row-gap-3">
                            <div class="col-md-9">
                                <input type="text" class="form-control ol-form-control" name="search" value="{{ request('search') }}" placeholder="{{ get_phrase('Search user') }}" />
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn ol-btn-primary w-100" id="submit-button"> {{ get_phrase('Search') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    <!-- Table -->
                    @if (count($students) > 0)
                        <div class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                            <p class="admin-tInfo">
                                {{ get_phrase('Showing') . ' ' . count($students) . ' ' . get_phrase('of') . ' ' . $students->total() . ' ' . get_phrase('data') }}
                            </p>
                        </div>
                        <div class="table-responsive course_list" id="course_list">
                            <table class="table eTable eTable-2 print-table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ get_phrase('Name') }}</th>
                                        <th scope="col">{{ get_phrase('Phone') }}</th>
                                        <th scope="col">Class and Courses</th>
                                        <th scope="col">Enrolled By</th>
                                        <th scope="col">Paid or Not</th>
                                        <th scope="col">Coupon Code</th>
                                        <th scope="col">Amount</th>
                                        <th class="print-d-none" scope="col">{{ get_phrase('Options') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($students as $key => $row)
                                        <tr>
                                            <th scope="row">
                                                <p class="row-number">{{ ++$key }}</p>
                                            </th>
                                            <td>
                                                <div class="dAdmin_profile d-flex align-items-center min-w-200px">
                                                    <div class="dAdmin_profile_img">
                                                        <img class="img-fluid rounded-circle image-45" width="45" height="45" src="{{ get_image($row->photo) }}" />
                                                    </div>
                                                    <div class="ms-1">
                                                        <h4 class="title fs-14px">{{ $row->name }}</h4>
                                                        <p class="sub-title2 text-12px">{{ $row->email }}</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="dAdmin_info_name min-w-150px">
                                                    <p>{{ $row->phone }}</p>
                                                </div>
                                            </td>
                                            <td>
                                            @php
                                                $class = App\Models\StudentDetails::where('user_id', $row->id)->join('categories', 'student_details.class_id', '=', 'categories.id')->select('categories.title','student_details.entrolled_by')->get();
                                            @endphp
                                                {{ $class[0]->title }},
                                                {{ App\Models\Course::where('user_id', $row->id)->count() }}
                                                {{ get_phrase('Courses') }}
                                            </td>
                                            <td>
                                                {{ App\Models\User::where('id', $class[0]->entrolled_by)->first()->name }}
                                            </td>
                                            <td>
                                                @php
                                                    $paid = App\Models\StudentDetails::where('user_id', $row->id)->select('paid')->get();
                                                @endphp
                                                {{$paid[0]->paid == "0" ? "Not Paid" : "Paid"}}
                                            </td>
                                            <td>
                                                {{ App\Models\StudentDetails::where('user_id', $row->id)->select('coupon_code')->get()[0]->coupon_code }}
                                            </td>
                                            <td>
                                                {{ App\Models\StudentDetails::where('user_id', $row->id)->select('amount')->get()[0]->amount }}
                                            </td>
                                            <td class="print-d-none">
                                                <div class="dropdown ol-icon-dropdown ol-icon-dropdown-transparent">
                                                    <button class="btn ol-btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <span class="fi-rr-menu-dots-vertical"></span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('admin.student.edit', $row->id) }}">{{ get_phrase('Edit') }}</a>
                                                        </li>

                                                        <li>
                                                            <a class="dropdown-item" onclick="confirmModal('{{ route('admin.student.delete', $row->id) }}')" href="javascript:void(0)">{{ get_phrase('Delete') }}</a>
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
                        @include('admin.no_data')
                    @endif

                    <!-- Data info and Pagination -->
                    @if (count($students) > 0)
                        <div class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                            <p class="admin-tInfo">
                                {{ get_phrase('Showing') . ' ' . count($students) . ' ' . get_phrase('of') . ' ' . $students->total() . ' ' . get_phrase('data') }}
                            </p>
                            {{ $students->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection


@push('js')
@endpush
