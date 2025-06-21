<!-- resources/views/admin/accounting/income.blade.php -->
@extends('layouts.admin')

@push('title', get_phrase('Income'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
<div class="ol-card radius-8px">
    <div class="ol-card-body my-3 py-12px px-20px">
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
            <h4 class="title fs-16px">
                <i class="fi-rr-wallet me-2"></i>
                {{ get_phrase('Income Records') }}
            </h4>
        </div>
    </div>
</div>

<div class="ol-card p-4">
    <div class="ol-card-body">

            <div class="col-md-6 pt-2 pt-md-0">
                <div class="custom-dropdown">
                    <button class="dropdown-header btn ol-btn-light">
                        {{ get_phrase('Export') }}
                        <i class="fi-rr-file-export ms-2"></i>
                    </button>
                    <ul class="dropdown-list">
                        <li>
                            <a class="dropdown-item" href="#" onclick="downloadPDF('.eTable', 'income-list')">
                                <i class="fi-rr-file-pdf"></i> {{ get_phrase('PDF') }}
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" onclick="window.print();">
                                <i class="fi-rr-print"></i> {{ get_phrase('Print') }}
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

        <form method="GET" action="{{ route('admin.accounting.income.index') }}">
            <div class="d-flex mb-3">
                <input type="text" name="search" class="form-control ol-form-control" placeholder="{{ get_phrase('Search by student name or agent name') }}" value="{{ request('search') }}">
                <button type="submit" class="btn ol-btn-primary ms-2">{{ get_phrase('Search') }}</button>
            </div>
        </form>

        <table class="table eTable eTable-2">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{ get_phrase('Suggested By') }}</th>
                    <th scope="col">{{ get_phrase('Student Name') }}</th>
                    <th scope="col">{{ get_phrase('Category') }}</th>
                    <th scope="col">{{ get_phrase('Course Type') }}</th>
                    <th scope="col">{{ get_phrase('Amount') }}</th>
                    <th scope="col">{{ get_phrase('Date') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($incomes as $income)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $income->agent_name }}</td>
                        <td>{{ $income->student_name }}</td>
                        <td>{{ $income->category }}</td>
                        <td>{{ $income->course_type }}</td>
                        <td>{{ $income->amount }}</td>
                        <td>{{ $income->date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @include('admin.no_data')
    </div>
</div>

@endsection

@push('js')
@endpush
