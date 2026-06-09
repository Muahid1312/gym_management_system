@extends('layouts.app')

@section('content')
<!-- Toolbar -->
<div class="status-row">
    <div style="flex:1">
        <div class="card">
            <div class="card-body" style="display:flex; align-items:center; gap:12px;">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="color:var(--muted)">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.5 5.5a7.5 7.5 0 0010.5 10.5z" />
                </svg>
                <input type="text" placeholder="Search members..." class="form-control" />
            </div>
        </div>
    </div>

    <div style="display:flex; gap:8px;">
        <input type="date" class="form-control" />
        <button class="button">Mark Attendance</button>
    </div>
</div>

<!-- Attendance Stats -->
<div class="grid" style="margin-bottom:24px;">
    <div class="card">
        <div class="card-body" style="display:flex; align-items:center; gap:16px;">
            <div class="stat-icon green"></div>
            <div>
                <div class="small text-muted" style="text-transform:uppercase;">Today's Check-in</div>
                <div style="font-size:24px; font-weight:700;">{{ $todayCount }}</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body" style="display:flex; align-items:center; gap:16px;">
            <div class="stat-icon blue"></div>
            <div>
                <div class="small text-muted" style="text-transform:uppercase;">Week Average</div>
                <div style="font-size:24px; font-weight:700;">{{ $weekAverage }}</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body" style="display:flex; align-items:center; gap:16px;">
            <div class="stat-icon" style="background-color: #F3E8FF; color: #7C3AED;"></div>
            <div>
                <div class="small text-muted" style="text-transform:uppercase;">Month Total</div>
                <div style="font-size:24px; font-weight:700;">{{ $monthCount }}</div>
            </div>
        </div>
    </div>
</div>
@extends('layouts.app')

@section('title', 'Attendance')

@section('content')
<!-- Toolbar -->
<div class="grid" style="grid-template-columns: 1fr auto auto; gap: 1rem; margin-bottom: 1.5rem; align-items: center;">
    <div class="card" style="padding: 0.5rem 1rem; display:flex; align-items:center; gap:0.75rem;">
        <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24" style="color:var(--muted)">
            <path d="M21 21l-5.197-5.197A7.5 7.5 0 105.5 5.5" />
        </svg>
        <input type="text" placeholder="Search members..." class="form-control" />
    </div>

    <input type="date" class="form-control" />

    <button class="button">Mark Attendance</button>
</div>

<!-- Attendance Stats -->
<div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 24px;">
    <div class="card">
        <div class="stat-card-content">
            <div class="stat-icon green">📥</div>
            <div class="stat-info">
                <h3>Today's Check-in</h3>
                <p style="font-size:1.25rem; margin:0; font-weight:700">{{ $todayCount ?? 0 }}</p>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="stat-card-content">
            <div class="stat-icon blue">📊</div>
            <div class="stat-info">
                <h3>Week Average</h3>
                <p style="font-size:1.25rem; margin:0; font-weight:700">{{ $weekAverage ?? 0 }}</p>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="stat-card-content">
            <div class="stat-icon">🗓️</div>
            <div class="stat-info">
                <h3>Month Total</h3>
                <p style="font-size:1.25rem; margin:0; font-weight:700">{{ $monthCount ?? 0 }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Attendance Table -->
<div class="card">
    <div class="card-header">
        <div>
            <h3 class="card-title">Today's Attendance</h3>
            <p class="card-subtitle">{{ now()->format('F j, Y') }}</p>
        </div>
    </div>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Plan</th>
                    <th>Check-in Time</th>
                    <th>Check-out Time</th>
                    <th>Duration</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendances as $att)
                    <tr>
                        <td>
                            <div style="display:flex; align-items:center; gap:12px;">
                                <div class="user-avatar">{{ strtoupper(substr($att->member->name ?? 'U', 0, 2)) }}</div>
                                <div>
                                    <div style="font-weight:600; color:var(--text);">{{ $att->member->name ?? 'Unknown' }}</div>
                                    <div style="font-size:12px; color:var(--muted);">{{ $att->member->email ?? '' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $att->member->plan->name ?? 'N/A' }}</td>
                        <td>{{ optional($att->check_in_time)->format('h:i A') ?? '--' }}</td>
                        <td>{{ optional($att->check_out_time)->format('h:i A') ?? '--' }}</td>
                        <td>
                            @if($att->check_in_time && $att->check_out_time)
                                <strong>{{ \Carbon\Carbon::parse($att->check_in_time)->diffForHumans($att->check_out_time, true) }}</strong>
                            @else
                                <strong>--</strong>
                            @endif
                        </td>
                        <td>
                            <a href="#" class="button button-outline">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="display:flex; justify-content:space-between; align-items:center; padding-top:20px; border-top:1px solid var(--border); margin-top:20px;">
        <div style="font-size:12px; color:var(--muted);">
            Showing {{ $attendances->firstItem() ?? 0 }} to {{ $attendances->lastItem() ?? 0 }} of {{ $attendances->total() }} check-ins
        </div>
        <div>
            {{ $attendances->links() }}
        </div>
    </div>
</div>
@endsection
