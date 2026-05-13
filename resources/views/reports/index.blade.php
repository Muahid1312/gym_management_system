@extends('layouts.app')

@section('content')
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h1>{{ __('messages.reports') }}</h1>
            <a class="button" href="{{ route('reports.export') }}">{{ __('messages.export_pdf') }}</a>
        </div>
        <div class="grid">
            <div class="card">
                <h3>Daily Income</h3>
                <p>AF {{ number_format($dailyIncome, 2) }}</p>
            </div>
            <div class="card">
                <h3>Monthly Income</h3>
                <p>AF {{ number_format($monthlyIncome, 2) }}</p>
            </div>
            <div class="card">
                <h3>{{ __('messages.active') }} Members</h3>
                <p>{{ $activeMembers }}</p>
            </div>
            <div class="card">
                <h3>{{ __('messages.expired') }} Members</h3>
                <p>{{ $expiredMembers }}</p>
            </div>
        </div>
        <h2>Members with Debt</h2>
        <table>
            <thead>
                <tr>
                    <th>{{ __('messages.name') }}</th>
                    <th>{{ __('messages.debt') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($membersWithDebt as $member)
                    <tr>
                        <td>{{ $member['name'] }}</td>
                        <td>AF {{ number_format($member['debt'], 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection