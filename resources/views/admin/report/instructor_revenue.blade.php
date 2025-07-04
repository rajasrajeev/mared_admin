@extends('layouts.admin')
@push('title', get_phrase('Revenue'))
@push('meta')@endpush
@push('css')@endpush
@section('content')
    <div class="ol-card radius-8px">
        <div class="ol-card-body my-3 py-4 px-20px">
            <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
                <h4 class="title fs-16px">
                    <i class="fi-rr-settings-sliders me-2"></i>
                    {{ get_phrase('Revenue Distribution') }}
                </h4>
            </div>
        </div>
    </div>

    <div class="ol-card p-4">
        <div class="ol-card-body">

            <div class="row mb-3 mt-3 row-gap-3">
                <div class="col-md-6 pt-2 pt-md-0">
                    @if ($reports->count() > 0)
                        <div class="custom-dropdown">
                            <button class="dropdown-header btn ol-btn-light">
                                {{ get_phrase('Export') }}
                                <i class="fi-rr-file-export ms-2"></i>
                            </button>
                            <ul class="dropdown-list">
                                <li>
                                    <a class="dropdown-item" href="#" onclick="downloadPDF('.print-table', 'revenue-distribution')"><i class="fi-rr-file-pdf"></i> {{ get_phrase('PDF') }}</a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#" onclick="window.print();"><i class="fi-rr-print"></i> {{ get_phrase('Print') }}</a>
                                </li>
                            </ul>
                        </div>
                    @endif
                </div>

                <div class="col-md-6">
                    <form class="form-inline" action="{{ route('admin.instructor.revenue') }}" method="get">
                        <div class="row row-gap-3">
                            <div class="col-md-9">
                                <div class="mb-3 position-relative position-relative">
                                    <input type="text" class="form-control ol-form-control daterangepicker w-100" name="eDateRange" value="{{ date('m/d/Y', $start_date) . ' - ' . date('m/d/Y', $end_date) }}" />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn ol-btn-primary w-100" id="submit-button" onclick="update_date_range();"> {{ get_phrase('Filter') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    @if ($reports->count() > 0)
                        <div class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                            <p class="admin-tInfo">
                                {{ get_phrase('Showing') . ' ' . count($reports) . ' ' . get_phrase('of') . ' ' . $reports->total() . ' ' . get_phrase('data') }}
                            </p>
                        </div>
                        <div class="table-responsive enroll_history" id="enroll_history">
                            <table class="table eTable eTable-2 print-table">
                                <thead>
                                    <tr>
                                        <th scope="col">{{ get_phrase('#') }}</th>
                                        <th scope="col">{{ get_phrase('Student Details') }}</th>
                                        <th scope="col">{{ get_phrase('Course Details') }}</th>
                                        <th scope="col">{{ get_phrase('Total Amount') }}</th>
                                        @if(auth()->user()->role == 'admin')
                                            <th scope="col">{{ get_phrase('Agent') }}</th>
                                            <th scope="col">{{ get_phrase('Supervisor') }}</th>
                                            <th scope="col">{{ get_phrase('Team Leader') }}</th>
                                        @elseif(auth()->user()->role == 'teamleader')
                                            <th scope="col">{{ get_phrase('Agent') }}</th>
                                            <th scope="col">{{ get_phrase('Supervisor') }}</th>
                                            <th scope="col">{{ get_phrase('Your Revenue') }}</th>
                                        @elseif(auth()->user()->role == 'supervisor')
                                            <th scope="col">{{ get_phrase('Agent') }}</th>
                                            <th scope="col">{{ get_phrase('Your Revenue') }}</th>
                                        @elseif(auth()->user()->role == 'agent')
                                            <th scope="col">{{ get_phrase('Your Revenue') }}</th>
                                        @endif
                                        <th scope="col">{{ get_phrase('Enrolled Date') }}</th>
                                        <!-- <th class="print-d-none" scope="col">{{ get_phrase('Option') }}</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $total_amount = 0;
                                        $total_agent_revenue = 0;
                                        $total_supervisor_revenue = 0;
                                        $total_teamleader_revenue = 0;
                                    @endphp

                                    @foreach ($reports as $key => $report)
                                        @php
                                            $total_amount += $report->amount;
                                            $total_agent_revenue += $report->agent_revenue;
                                            $total_supervisor_revenue += $report->supervisor_revenue;
                                            $total_teamleader_revenue += $report->teamleader_revenue;
                                        @endphp
                                        <tr>
                                            <th scope="row">
                                                <p class="row-number">{{ $key + 1 }}</p>
                                            </th>
                                            <td>
                                                <div class="dAdmin_profile d-flex align-items-center">
                                                    <div class="dAdmin_profile_name">
                                                        <h4 class="title fs-14px">{{ $report->student_name }}</h4>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="dAdmin_profile_name">
                                                    <h4 class="fs-14px">{{ $report->category }}</h4>
                                                    <p class="mt-1 fs-12px">{{ $report->course_type_label }}</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="dAdmin_info_name">
                                                    <p>{{ currency($report->amount) }}</p>
                                                </div>
                                            </td>

                                            @if(auth()->user()->role == 'admin')
                                                <td>
                                                    <div class="dAdmin_info_name">
                                                        <p>{{ $report->agent_name }} ({{ $report->agent_revenue_percentage }}%)</p>
                                                        <p class="fw-bold">{{ currency($report->agent_revenue) }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="dAdmin_info_name">
                                                        <p>{{ $report->supervisor_name ?? 'N/A' }} ({{ $report->supervisor_revenue_percentage ?? 0 }}%)</p>
                                                        <p class="fw-bold">{{ currency($report->supervisor_revenue) }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="dAdmin_info_name">
                                                        <p>{{ $report->teamleader_name ?? 'N/A' }} ({{ $report->teamleader_revenue_percentage ?? 0 }}%)</p>
                                                        <p class="fw-bold">{{ currency($report->teamleader_revenue) }}</p>
                                                    </div>
                                                </td>
                                            @elseif(auth()->user()->role == 'teamleader')
                                                <td>
                                                    <div class="dAdmin_info_name">
                                                        <p>{{ $report->agent_name }} ({{ $report->agent_revenue_percentage }}%)</p>
                                                        <p class="fw-bold">{{ currency($report->agent_revenue) }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="dAdmin_info_name">
                                                        <p>{{ $report->supervisor_name ?? 'N/A' }} ({{ $report->supervisor_revenue_percentage ?? 0 }}%)</p>
                                                        <p class="fw-bold">{{ currency($report->supervisor_revenue) }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="dAdmin_info_name">
                                                        <p>({{ $report->teamleader_revenue_percentage }}%)</p>
                                                        <p class="fw-bold">{{ currency($report->teamleader_revenue) }}</p>
                                                    </div>
                                                </td>
                                            @elseif(auth()->user()->role == 'supervisor')
                                                <td>
                                                    <div class="dAdmin_info_name">
                                                        <p>{{ $report->agent_name }} ({{ $report->agent_revenue_percentage }}%)</p>
                                                        <p class="fw-bold">{{ currency($report->agent_revenue) }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="dAdmin_info_name">
                                                        <p>({{ $report->supervisor_revenue_percentage }}%)</p>
                                                        <p class="fw-bold">{{ currency($report->supervisor_revenue) }}</p>
                                                    </div>
                                                </td>
                                            @elseif(auth()->user()->role == 'agent')
                                                <td>
                                                    <div class="dAdmin_info_name">
                                                        <p>({{ $report->agent_revenue_percentage }}%)</p>
                                                        <p class="fw-bold">{{ currency($report->agent_revenue) }}</p>
                                                    </div>
                                                </td>
                                            @endif

                                            <td>
                                                <div class="dAdmin_info_name">
                                                    <p>{{ date('d-M-Y', strtotime($report->date)) }}</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <th colspan="{{ auth()->user()->role == 'admin' ? '3' : (auth()->user()->role == 'teamleader' ? '3' : (auth()->user()->role == 'supervisor' ? '3' : '3')) }}">
                                            <strong>{{ get_phrase('Total') }}</strong>
                                        </th>
                                        <th>{{ currency($total_amount) }}</th>

                                        @if(auth()->user()->role == 'admin')
                                            <th>{{ currency($total_agent_revenue) }}</th>
                                            <th>{{ currency($total_supervisor_revenue) }}</th>
                                            <th>{{ currency($total_teamleader_revenue) }}</th>
                                        @elseif(auth()->user()->role == 'teamleader')
                                            <th>{{ currency($total_agent_revenue) }}</th>
                                            <th>{{ currency($total_supervisor_revenue) }}</th>
                                            <th>{{ currency($total_teamleader_revenue) }}</th>
                                        @elseif(auth()->user()->role == 'supervisor')
                                            <th>{{ currency($total_agent_revenue) }}</th>
                                            <th>{{ currency($total_supervisor_revenue) }}</th>
                                        @elseif(auth()->user()->role == 'agent')
                                            <th>{{ currency($total_agent_revenue) }}</th>
                                        @endif

                                        <th></th>
                                        <th class="print-d-none"></th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @else
                        @include('admin.no_data')
                    @endif
                    <!-- Data info and Pagination -->
                    @if (count($reports) > 0)
                        <div class="admin-tInfo-pagi d-flex justify-content-between justify-content-center align-items-center flex-wrap gr-15">
                            <p class="admin-tInfo">
                                {{ get_phrase('Showing') . ' ' . count($reports) . ' ' . get_phrase('of') . ' ' . $reports->total() . ' ' . get_phrase('data') }}
                            </p>
                            {{ $reports->links() }}
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

        function update_date_range() {
            var x = $("#selectedValue").html();
            $("#date_range").val(x);
        }
    </script>
@endpush
