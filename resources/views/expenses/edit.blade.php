@extends('layouts.app')

@section('title', 'Edit Expense')

@section('content')
<div class="page-header">
    <div class="flex items-center gap-4">
        <a href="{{ route('expenses.index') }}" class="text-gray-500 hover:text-gray-700">
            ← Back to Expenses
        </a>
        <h1 class="page-title">Edit Expense</h1>
    </div>
</div>

<div class="max-w-2xl">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Expense Details</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('expenses.update', $expense) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title *</label>
                        <input type="text" id="title" name="title" value="{{ old('title', $expense->title) }}" required
                               class="form-input" placeholder="e.g., Rent, Electricity">
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                        <select id="category" name="category" required class="form-input">
                            <option value="">Select Category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" {{ old('category', $expense->category) == $category ? 'selected' : '' }}>{{ $category }}</option>
                            @endforeach
                        </select>
                        @error('category')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">Amount *</label>
                        <input type="number" id="amount" name="amount" value="{{ old('amount', $expense->amount) }}" required
                               step="0.01" min="0" class="form-input" placeholder="0.00">
                        @error('amount')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700 mb-1">Date *</label>
                        <input type="date" id="date" name="date" value="{{ old('date', $expense->date->format('Y-m-d')) }}" required
                               class="form-input">
                        @error('date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label for="note" class="block text-sm font-medium text-gray-700 mb-1">Note (Optional)</label>
                    <textarea id="note" name="note" rows="3" class="form-input"
                              placeholder="Additional notes about this expense">{{ old('note', $expense->note) }}</textarea>
                    @error('note')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                </div>

                <div class="mt-6 flex gap-3">
                    <button type="submit" class="button">Update Expense</button>
                    <a href="{{ route('expenses.index') }}" class="button button-outline">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection