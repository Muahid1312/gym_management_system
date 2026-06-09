@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-semibold">{{ __('messages.reports') }}</h1>
            <a class="button" href="{{ route('reports.export') }}">{{ __('messages.export_pdf') }}</a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-4">
            <div class="card">
                <h3 class="text-sm text-slate-600">Daily Income</h3>
                <p class="text-lg font-semibold">AF {{ number_format($dailyIncome, 2) }}</p>
            </div>
            <div class="card">
                <h3 class="text-sm text-slate-600">Monthly Income</h3>
                <p class="text-lg font-semibold">AF {{ number_format($monthlyIncome, 2) }}</p>
            </div>
            <div class="card">
                <h3 class="text-sm text-slate-600">{{ __('messages.active') }} Members</h3>
                <p class="text-lg font-semibold">{{ $activeMembers }}</p>
            </div>
            <div class="card">
                <h3 class="text-sm text-slate-600">{{ __('messages.expired') }} Members</h3>
                <p class="text-lg font-semibold">{{ $expiredMembers }}</p>
            </div>
        </div>

        <h2 class="mt-6 text-lg font-semibold">Members with Debt</h2>
        <div class="overflow-x-auto mt-3">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.name') }}</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ __('messages.debt') }}</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($membersWithDebt as $member)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $member['name'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">AF {{ number_format($member['debt'], 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection