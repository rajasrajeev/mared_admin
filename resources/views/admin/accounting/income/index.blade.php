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
            <!-- <a href="#" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                <span class="fi-rr-plus"></span>
                <span>{{ get_phrase('Add New Income') }}</span>
            </a> -->
        </div>
    </div>
</div>

<div class="ol-card p-4">
    <div class="ol-card-body">
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
