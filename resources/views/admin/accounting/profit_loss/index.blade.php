<!-- resources/views/admin/accounting/profit_loss.blade.php -->
@extends('layouts.admin')

@push('title', get_phrase('Profit and Loss'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')
<div class="ol-card radius-8px">
    <div class="ol-card-body my-3 py-12px px-20px">
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
            <h4 class="title fs-16px">
                <i class="fi-rr-pie-chart me-2"></i>
                {{ get_phrase('Profit and Loss Report') }}
            </h4>
        </div>
    </div>
</div>

<div class="ol-card p-4">
    <div class="ol-card-body">
        <form method="GET" action="{{ route('admin.accounting.profit_loss.index') }}">
            <div class="d-flex mb-3">
                <input type="text" name="search" class="form-control ol-form-control" placeholder="{{ get_phrase('Search by month or year') }}" value="{{ request('search') }}">
                <button type="submit" class="btn ol-btn-primary ms-2">{{ get_phrase('Search') }}</button>
            </div>
        </form>

        <table class="table eTable eTable-2">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{ get_phrase('Date') }}</th>
                    <th scope="col">{{ get_phrase('Amount') }}</th>
                    <th scope="col">{{ get_phrase('type') }}</th>
                    <th scope="col">{{ get_phrase('Options') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($profitLoss as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item['date'] }}</td>
                        <td>{{ currency($item['amount']) }}</td>
                        <td>{{ currency($item['type']) }}</td>
                        <td>
                            <a href="{{ route('admin.accounting.profit_loss.show', ['id' => $item['id']]) }}" class="btn ol-btn-outline-secondary">{{ get_phrase('View Details') }}</a>
                        </td>
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
