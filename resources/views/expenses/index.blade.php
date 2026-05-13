@extends('layouts.app')

@section('title', 'Expenses')

@section('content')
<div class="page-header">
    <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
        <div>
            <h1 class="page-title">Expense Management</h1>
            <p class="page-subtitle">Track and manage your gym expenses</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('expenses.create') }}" class="button">➕ Add Expense</a>
        </div>
    </div>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="stat-card bg-red-50 border-red-200">
        <div class="stat-card-content">
            <div class="stat-icon text-red-600">💸</div>
            <div class="stat-info">
                <h3 class="text-red-800">Today's Expenses</h3>
                <p class="text-red-600 font-bold text-xl">${{ number_format($financialMetrics['today_expenses'], 2) }}</p>
            </div>
        </div>
    </div>
    <div class="stat-card bg-blue-50 border-blue-200">
        <div class="stat-card-content">
            <div class="stat-icon text-blue-600">💰</div>
            <div class="stat-info">
                <h3 class="text-blue-800">Today's Income</h3>
                <p class="text-blue-600 font-bold text-xl">${{ number_format($financialMetrics['today_income'], 2) }}</p>
            </div>
        </div>
    </div>
    <div class="stat-card {{ $financialMetrics['today_profit'] >= 0 ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200' }}">
        <div class="stat-card-content">
            <div class="stat-icon {{ $financialMetrics['today_profit'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                {{ $financialMetrics['today_profit'] >= 0 ? '📈' : '📉' }}
            </div>
            <div class="stat-info">
                <h3 class="{{ $financialMetrics['today_profit'] >= 0 ? 'text-green-800' : 'text-red-800' }}">Today's Profit</h3>
                <p class="{{ $financialMetrics['today_profit'] >= 0 ? 'text-green-600' : 'text-red-600' }} font-bold text-xl">
                    ${{ number_format($financialMetrics['today_profit'], 2) }}
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="card mb-6">
    <div class="card-header">
        <h2 class="card-title">Filters</h2>
    </div>
    <div class="card-body">
        <form method="GET" class="flex flex-wrap gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Category</label>
                <select name="category" class="form-input">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Date From</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-input">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Date To</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-input">
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="button">Filter</button>
                <a href="{{ route('expenses.index') }}" class="button button-outline">Clear</a>
            </div>
        </form>
    </div>
</div>

<!-- Expenses Table -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Expenses</h2>
    </div>
    <div class="card-body">
        @if($expenses->isEmpty())
            <div class="text-center py-8">
                <p class="text-gray-500">No expenses found.</p>
                <a href="{{ route('expenses.create') }}" class="button mt-4">Add First Expense</a>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Note</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($expenses as $expense)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $expense->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $expense->category }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-red-600 font-semibold">${{ number_format($expense->amount, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $expense->date->format('M d, Y') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $expense->note ?: '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('expenses.edit', $expense) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                    <form action="{{ route('expenses.destroy', $expense) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $expenses->links() }}
            </div>
        @endif
    </div>
</div>
@endsection