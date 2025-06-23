@extends('layouts.admin')
@push('title', get_phrase('Enroll History'))
@push('meta')@endpush
@push('css')@endpush
@section('content')

    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-12px px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Enroll History') }}
                </h4>

                <a href="{{ route('admin.student.enroll') }}" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                    <span class="fi-rr-plus"></span>
                    <span>{{ get_phrase('Add new enrollment') }}</span>
                </a>
            </div>
        </div>
    </div>

    <div class="ol-card">
        <div class="ol-card-body p-3">
            <div class="row mb-3 mt-3 row-gap-3">
                <div class="col-md-6 pt-2 pt-md-0">
                    @if (count($enroll_history) > 0)
                        <div class="custom-dropdown ">
                            <button class="dropdown-header btn ol-btn-light">
                                {{ get_phrase('Export') }}
                                <i class="fi-rr-file-export ms-2"></i>
                            </button>
                            <ul class="dropdown-list">
                                <li>
                                    <a class="dropdown-item" href="#" onclick="downloadPDF('.print-table', 'enroll-history')"><i class="fi-rr-file-pdf"></i> {{ get_phrase('PDF') }}</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" onclick="window.print();"><i class="fi-rr-print"></i> {{ get_phrase('Print') }}</a>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>

                <div class="col-md-6">
                    <form class="w-100" action="{{ route('admin.enroll.history') }}" method="get" class="d-flex justify-content-between">
                        <div class="row row-gap-3">
                            <div class="col-md-9">
                                <div class="position-relative position-relative">
                                    <input type="text" class="form-control ol-form-control daterangepicker w-100" name="eDateRange"
                                        value="{{ date('m/d/Y', $start_date) . ' - ' . date('m/d/Y', $end_date) }}" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn ol-btn-primary w-100" id="submit-button" onclick="update_date_range();"> {{ get_phrase('Filter') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    @if (count($enroll_history) > 0)
                        <div class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                            <p class="admin-tInfo">
                                {{ get_phrase('Showing') . ' ' . count($enroll_history) . ' ' . get_phrase('of') . ' ' . $enroll_history->total() . ' ' . get_phrase('data') }}
                            </p>
                        </div>
                        <div class="table-responsive enroll_history overflow-auto" id="enroll_history">
                            <!-- Add these columns to your table -->
                            <table class="table eTable eTable-2 print-table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">{{ get_phrase('Student Name') }}</th>
                                        <th scope="col">{{ get_phrase('Email') }}</th>
                                        <th scope="col">{{ get_phrase('Enrolled Class') }}</th>
                                        <th scope="col">{{ get_phrase('Course Type') }}</th>
                                        <th scope="col">{{ get_phrase('Amount') }}</th>
                                        <th scope="col">{{ get_phrase('Enrolled By') }}</th>
                                        <th scope="col">{{ get_phrase('Enrolled Date') }}</th>
                                        <!-- <th class="print-d-none" scope="col">{{ get_phrase('Action') }}</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($enroll_history as $key => $row)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $row->student_name }}</td>
                                            <td>{{ $row->email }}</td>
                                            <td>{{ $row->category_title }}</td>
                                            <td>{{ ucfirst($row->course_type) }}</td>
                                            <td>{{ $row->amount }}</td>
                                            <td>{{ $row->agent_name }}</td>
                                            <td>{{ date('d M Y', strtotime($row->created_at)) }}</td>
                                            <!-- <td class="print-d-none">
                                                <div class="adminTable-action">
                                                    <button type="button" class="btn ol-btn-light ol-icon-btn" 
                                                            onclick="confirmModal('{{ route('admin.enroll.history.delete', $row->id) }}')">
                                                        <i class="fi-rr-trash"></i>
                                                    </button>
                                                </div>
                                            </td> -->
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        @include('admin.no_data')
                    @endif
                    <!-- Data info and Pagination -->
                    @if (count($enroll_history) > 0)
                        <div class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                            <p class="admin-tInfo">
                                {{ get_phrase('Showing') . ' ' . count($enroll_history) . ' ' . get_phrase('of') . ' ' . $enroll_history->total() . ' ' . get_phrase('data') }}
                            </p>
                            {{ $enroll_history->links() }}

                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')

    <script type="text/javascript">
        "use strict";

        $(function() {
            $('.daterangepicker:not(.inited)').daterangepicker();
        });

        function Export() {

            // Choose the element that our invoice is rendered in.
            const element = document.getElementById("enroll_history");

            // clone the element
            var clonedElement = element.cloneNode(true);

            // change display of cloned element
            $(clonedElement).css("display", "block");

            // Choose the clonedElement and save the PDF for our user.
            var opt = {
                margin: 1,
                filename: 'enroll_history_{{ date('y-m-d') }}.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                }
            };

            // New Promise-based usage:
            html2pdf().set(opt).from(clonedElement).save();

            // remove cloned element
            clonedElement.remove();
        }


        function printableDiv(printableAreaDivId) {
            var printContents = document.getElementById(printableAreaDivId).innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }

        function update_date_range() {
            var x = $("#selectedValue").html();
            $("#date_range").val(x);
        }
    </script>
@endpush
