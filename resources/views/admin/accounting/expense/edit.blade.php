<!-- resources/views/admin/accounting/expense/edit.blade.php -->
@extends('layouts.admin')

@push('title', get_phrase('Edit Expense'))
@push('meta')
@endpush
@push('css')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endpush

@section('content')
<div class="ol-card radius-8px">
    <div class="ol-card-body my-3 py-12px px-20px">
        <div class="d-flex align-items-center">
            <h4 class="title fs-16px">
                <i class="fi-rr-wallet me-2"></i>
                {{ get_phrase('Edit Expense') }}
            </h4>
        </div>
    </div>
</div>

<div class="ol-card p-4">
    <div class="ol-card-body">
        <form method="POST" action="{{ route('admin.accounting.expense.update', ['id' => $expense->id]) }}">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="type" class="form-label">{{ get_phrase('Expense Type') }}</label>
                    <select name="type" id="type" class="form-select ol-form-control @error('type') is-invalid @enderror" required>
                        <option value="regular" {{ $expense->type == 'regular' ? 'selected' : '' }}>{{ get_phrase('Regular') }}</option>
                        <option value="special" {{ $expense->type == 'special' ? 'selected' : '' }}>{{ get_phrase('Special') }}</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="category" class="form-label">{{ get_phrase('Category') }}</label>
                    <select name="category" id="category" class="form-select ol-form-control @error('category') is-invalid @enderror" required>
                        <option value="">{{ get_phrase('Select a category') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $expense->category == $category->id ? 'selected' : '' }}>
                                {{ $category->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="amount" class="form-label">{{ get_phrase('Amount') }}</label>
                    <input type="number" step="0.01" name="amount" id="amount" class="form-control ol-form-control @error('amount') is-invalid @enderror" value="{{ $expense->amount }}" required>
                    @error('amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6">
                    <label for="date" class="form-label">{{ get_phrase('Date') }}</label>
                    <input type="text" name="date" id="date" class="form-control ol-form-control datepicker @error('date') is-invalid @enderror" value="{{ $expense->date }}" required>
                    @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12">
                    <label for="description" class="form-label">{{ get_phrase('Description') }}</label>
                    <textarea name="description" id="description" class="form-control ol-form-control @error('description') is-invalid @enderror" rows="4" required>{{ $expense->description }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="payment_status" class="form-label">{{ get_phrase('Payment Status') }}</label>
                    <select name="payment_status" id="payment_status" class="form-select ol-form-control @error('payment_status') is-invalid @enderror" required>
                        <option value="paid" {{ $expense->payment_status == 'paid' ? 'selected' : '' }}>{{ get_phrase('Paid') }}</option>
                        <option value="unpaid" {{ $expense->payment_status == 'unpaid' ? 'selected' : '' }}>{{ get_phrase('Unpaid') }}</option>
                    </select>
                    @error('payment_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <button type="submit" class="btn ol-btn-primary">{{ get_phrase('Update Expense') }}</button>
                    <a href="{{ route('admin.accounting.expense.index') }}" class="btn ol-btn-outline-secondary ms-2">{{ get_phrase('Cancel') }}</a>
                </div>
            </div>
        </form>
    </div>
</div>
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
