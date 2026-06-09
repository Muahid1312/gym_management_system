@extends('layouts.app')

@section('title', 'حضور و غیاب')

@section('content')
<div class="page-header">
    <h1 class="page-title">حضور و غیاب</h1>
    <p class="page-subtitle">مدیریت ورود و خروج اعضا</p>
</div>

<!-- Stats Cards -->
<div class="grid">
    <div class="stat-card">
        <div class="stat-card-content">
            <div class="stat-icon">📥</div>
            <div class="stat-info">
                <h3>حضور امروز</h3>
                <p>{{ $todayCount ?? 0 }}</p>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-content">
            <div class="stat-icon">📊</div>
            <div class="stat-info">
                <h3>میانگین هفتگی</h3>
                <p>{{ $weekAverage ?? 0 }}</p>
            </div>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-card-content">
            <div class="stat-icon">🗓️</div>
            <div class="stat-info">
                <h3>کل ماهانه</h3>
                <p>{{ $monthCount ?? 0 }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Search & Filter -->
<x-ui-card title="جستجو و فیلتر">
    <div style="display: grid; grid-template-columns: 1fr auto auto; gap: 16px; align-items: flex-end;">
        <x-ui-input 
            name="search" 
            placeholder="جستجو براساس نام یا تماس..."
            style="margin-bottom: 0;"
        />
        <x-ui-input 
            name="date" 
            type="date"
            style="margin-bottom: 0;"
        />
        <x-ui-button type="success">ثبت حضور</x-ui-button>
    </div>
</x-ui-card>

<!-- Attendance Table -->
<x-ui-card title="حضور و غیاب امروز">
    <div class="table-card">
        <table>
            <thead>
                <tr>
                    <th>نام عضو</th>
                    <th>پلن</th>
                    <th>زمان ورود</th>
                    <th>زمان خروج</th>
                    <th>مدت</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
                @forelse($attendances as $att)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 12px;">
                                <div class="user-avatar">{{ strtoupper(substr($att->member->name ?? 'U', 0, 2)) }}</div>
                                <div>
                                    <div style="font-weight: 600; color: var(--text);">{{ $att->member->name ?? '—' }}</div>
                                    <div class="small text-muted">{{ $att->member->phone ?? '—' }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $att->member->plan->name ?? '—' }}</td>
                        <td>{{ optional($att->check_in_time)->format('H:i') ?? '—' }}</td>
                        <td>{{ optional($att->check_out_time)->format('H:i') ?? '—' }}</td>
                        <td>
                            @if($att->check_in_time && $att->check_out_time)
                                <span class="status-chip status-info">
                                    {{ \Carbon\Carbon::parse($att->check_in_time)->diffForHumans($att->check_out_time, true) }}
                                </span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            <div style="display: flex; gap: 8px;">
                                <x-ui-button 
                                    type="outline" 
                                    href="{{ route('attendance.show', $att->id) }}"
                                >مشاهده</x-ui-button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--muted);">
                            هیچ رکوردی برای امروز موجود نیست
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 16px; margin-top: 16px; border-top: 1px solid var(--border);">
        <div class="small text-muted">
            نمایش {{ $attendances->firstItem() ?? 0 }} تا {{ $attendances->lastItem() ?? 0 }} از {{ $attendances->total() }} 
        </div>
        <div>
            {{ $attendances->links() }}
        </div>
    </div>
</x-ui-card>

@endsection
