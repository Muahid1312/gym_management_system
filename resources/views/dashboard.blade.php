@extends('layouts.app')

@section('content')
    <div class="card hero">
        <div>
            <h1 class="page-title">Gym Dashboard</h1>
            <p class="subtitle">Track members, plan performance, payments, and membership expiry at a glance.</p>
            <div class="button-group">
                <a href="{{ route('members.index') }}" class="button">View Members</a>
                <a href="{{ route('payments.index') }}" class="button">View Payments</a>
            </div>
        </div>
        <div class="grid">
            <div class="stat-card">
                <h3>Total Members</h3>
                <p>{{ $membersCount }}</p>
            </div>
            <div class="stat-card">
                <h3>Active Plans</h3>
                <p>{{ $plansCount }}</p>
            </div>
            <div class="stat-card">
                <h3>Payments Recorded</h3>
                <p>{{ $paymentsCount }}</p>
            </div>
        </div>
    </div>

    <div class="card">
        <h2 class="page-title">Expiring Soon</h2>
        @if($expiringSoon->isEmpty())
            <p class="small-text">No members are expiring in the next 3 days.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Expiry Date</th>
                        <th>Plan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expiringSoon as $member)
                        <tr>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->expiry_date->format('Y-m-d') }}</td>
                            <td>{{ $member->plan->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="card">
        <h2 class="page-title">Expired Members</h2>
        @if($expired->isEmpty())
            <p class="small-text">No expired members.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Expired On</th>
                        <th>Plan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($expired as $member)
                        <tr>
                            <td>{{ $member->name }}</td>
                            <td>{{ $member->expiry_date->format('Y-m-d') }}</td>
                            <td>{{ $member->plan->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
