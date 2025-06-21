<!-- resources/views/admin/accounting/expense.blade.php -->
@extends('layouts.admin')

@push('title', get_phrase('Expense'))
@push('meta')
@endpush
@push('css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endpush

@section('content')
<div class="ol-card radius-8px">
    <div class="ol-card-body my-3 py-12px px-20px">
        <div class="d-flex align-items-center justify-content-between gap-3 flex-wrap flex-md-nowrap">
            <h4 class="title fs-16px">
                <i class="fi-rr-wallet me-2"></i>
                {{ get_phrase('Expense Records') }}
            </h4>
            <a href="{{ route('admin.accounting.expense.create') }}" class="btn ol-btn-outline-secondary d-flex align-items-center cg-10px">
                <span class="fi-rr-plus"></span>
                <span>{{ get_phrase('Add New Expense') }}</span>
            </a>
        </div>
    </div>
</div>

<div class="ol-card p-4">
    <div class="ol-card-body">
        <form method="GET" action="{{ route('admin.accounting.expense.index') }}">
            <div class="row mb-3">
                <div class="col-md-3">
                    <input type="text" name="search" class="form-control ol-form-control" placeholder="{{ get_phrase('Search by description') }}" value="{{ request('search') }}">
                </div>

                <div class="col-md-2">
                    <select name="category" class="form-control ol-form-control">
                        <option value="">{{ get_phrase('All Categories') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="payment_status" class="form-control ol-form-control">
                        <option value="all">{{ get_phrase('All Status') }}</option>
                        <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>{{ get_phrase('Paid') }}</option>
                        <option value="unpaid" {{ request('payment_status') == 'unpaid' ? 'selected' : '' }}>{{ get_phrase('Unpaid') }}</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="type" class="form-control ol-form-control">
                        <option value="">{{ get_phrase('All Types') }}</option>
                        <option value="regular" {{ request('type') == 'regular' ? 'selected' : '' }}>{{ get_phrase('Regular') }}</option>
                        <option value="special" {{ request('type') == 'special' ? 'selected' : '' }}>{{ get_phrase('Special') }}</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <div class="d-flex">
                        <button type="submit" class="btn ol-btn-primary me-2">{{ get_phrase('Filter') }}</button>
                        <a href="{{ route('admin.accounting.expense.index') }}" class="btn ol-btn-outline-secondary">{{ get_phrase('Reset') }}</a>
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <input type="text" name="start_date" id="start_date" class="form-control ol-form-control datepicker" placeholder="{{ get_phrase('Start Date') }}" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-3">
                    <input type="text" name="end_date" id="end_date" class="form-control ol-form-control datepicker" placeholder="{{ get_phrase('End Date') }}" value="{{ request('end_date') }}">
                </div>
            </div>
        </form>

        <div class="d-flex justify-content-end mb-3">
    <div class="custom-dropdown">
        <button class="dropdown-header btn ol-btn-light">
            {{ get_phrase('Export') }}
            <i class="fi-rr-file-export ms-2"></i>
        </button>
        <ul class="dropdown-list">
            <li>
                <a class="dropdown-item" href="#" onclick="downloadPDF('.eTable', 'expense-list')">
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


        <table class="table eTable eTable-2">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">{{ get_phrase('Expense Type') }}</th>
                    <th scope="col">{{ get_phrase('Expense Category') }}</th>
                    <th scope="col">{{ get_phrase('Description') }}</th>
                    <th scope="col">{{ get_phrase('Amount') }}</th>
                    <th scope="col">{{ get_phrase('Date') }}</th>
                    <th scope="col">{{ get_phrase('Status') }}</th>
                    <th scope="col">{{ get_phrase('Options') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expenses as $expense)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $expense->type }}</td>
                        <td>{{ $expense->expenseCategory ? $expense->expenseCategory->title : "" }}</td>
                        <td>{!! $expense->description !!}</td>
                        <td>{{ currency($expense->amount) }}</td>
                        <td>{{ date('D, d-M-Y', strtotime($expense->date)) }}</td>
                        <td>
                            <span class="badge bg-{{ $expense->payment_status == 'paid' ? 'success' : 'warning' }}">
                                {{ ucfirst($expense->payment_status) }}
                            </span>
                        </td>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-sm ol-btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ get_phrase('Actions') }}
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <li>
                                        <a href="{{ route('admin.accounting.expense.edit', ['id' => $expense->id]) }}" class="dropdown-item">
                                            {{ get_phrase('Edit') }}
                                        </a>
                                    </li>
                                    <li>
                                        <a href="javascript:void(0)" onclick="deleteExpense({{ $expense->id }})" class="dropdown-item">
                                            {{ get_phrase('Delete') }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if(count($expenses) == 0)
            @include('admin.no_data')
        @endif
    </div>
</div>

<script>
function deleteExpense(id) {
    if (confirm('{{ get_phrase('Are you sure you want to delete this expense?') }}')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route('admin.accounting.expense.delete', ['id' => ':id']) }}'.replace(':id', id);
        form.style.display = 'none';

        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';

        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';

        form.appendChild(csrfToken);
        form.appendChild(methodField);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>

@endsection

@push('js')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script>
    $(function() {
        $(".datepicker").datepicker({
            dateFormat: 'yy-mm-dd',
            changeMonth: true,
            changeYear: true
        });
    });
</script>
@endpush
