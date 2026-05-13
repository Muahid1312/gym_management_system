@extends('layouts.app')

@section('title', 'داشبورد')

@section('content')
<div class="page-header">
    <h1 class="page-title">داشبورد</h1>
    <p class="page-subtitle">خوش آمدید! اینجا نمای کلی مدیریت باشگاه شما است.</p>
</div>

<!-- Stats Cards -->
@if(!empty($quickStats))
<div class="grid">
    @foreach($quickStats as $stat)
    <div class="stat-card">
        <div class="stat-card-content">
            <div class="stat-icon">
                {!! $stat['icon'] !!}
            </div>
            <div class="stat-info">
                <h3>{{ $stat['label'] }}</h3>
                <p>{{ $stat['value'] }}</p>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

<!-- Alerts Section -->
@if(!empty($alerts))
<div class="card">
    <div class="card-header">
        <h2 class="card-title">هشدارهای مهم</h2>
    </div>
    <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));">
        @foreach($alerts as $alert)
        <div class="alert alert-{{ $alert['type'] }}">
            <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                @if($alert['type'] === 'danger')
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                @elseif($alert['type'] === 'warning')
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                @else
                <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0zm6 0a1 1 0 11-2 0 1 1 0 012 0zm2 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
                @endif
            </svg>
            <div>
                <h4 style="margin: 0 0 4px; font-weight: 600;">{{ $alert['title'] }}</h4>
                <p style="margin: 0 0 8px; font-size: 0.9rem;">{{ $alert['message'] }}</p>
                <a href="{{ $alert['action_url'] }}" class="button button-outline" style="font-size: 0.85rem; padding: 6px 12px;">مشاهده جزئیات</a>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- Detailed Metrics -->
<div class="grid" style="grid-template-columns: 1fr 1fr;">
    <!-- Members Overview -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">نمای کلی اعضا</h2>
        </div>
        <div style="display: grid; gap: 16px;">
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid var(--border);">
                <span style="color: var(--muted);">کل اعضا</span>
                <span style="font-weight: 600; color: var(--text);">{{ $metrics['members']['total_members'] }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid var(--border);">
                <span style="color: var(--muted);">اعضای فعال</span>
                <span style="font-weight: 600; color: var(--success);">{{ $metrics['members']['active_members'] }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid var(--border);">
                <span style="color: var(--muted);">اعضای منقضی شده</span>
                <span style="font-weight: 600; color: var(--danger);">{{ $metrics['members']['expired_members'] }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid var(--border);">
                <span style="color: var(--muted);">در حال انقضا (۳ روز)</span>
                <span style="font-weight: 600; color: var(--warning);">{{ $metrics['members']['members_expiring_soon'] }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="color: var(--muted);">اعضای بدهکار</span>
                <span style="font-weight: 600; color: var(--danger);">{{ $metrics['members']['members_with_debt'] }}</span>
            </div>
        </div>
    </div>

    <!-- Financial Overview -->
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">نمای کلی مالی</h2>
        </div>
        <div style="display: grid; gap: 16px;">
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid var(--border);">
                <span style="color: var(--muted);">درآمد امروز</span>
                <span style="font-weight: 600; color: var(--success); font-size: 1.1rem;">AF {{ number_format($metrics['financial']['today_income'], 2) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid var(--border);">
                <span style="color: var(--muted);">درآمد ماهانه</span>
                <span style="font-weight: 600; color: var(--success); font-size: 1.1rem;">AF {{ number_format($metrics['financial']['monthly_income'], 2) }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid var(--border);">
                <span style="color: var(--muted);">کل بدهی معوق</span>
                <span style="font-weight: 600; color: var(--danger); font-size: 1.1rem;">AF {{ number_format($metrics['financial']['total_outstanding_debt'], 2) }}</span>
            </div>
            <div style="padding: 16px; background: var(--surface-soft); border-radius: 8px;">
                <p style="margin: 0 0 12px; color: var(--muted); font-size: 0.9rem; font-weight: 600;">آمار بدهی:</p>
                <div style="display: grid; gap: 8px; font-size: 0.9rem;">
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--muted);">میانگین بدهی هر عضو</span>
                        <span style="color: var(--text); font-weight: 600;">AF {{ number_format($metrics['financial']['debt_stats']['average_debt_per_member'], 2) }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--muted);">بالاترین بدهی</span>
                        <span style="color: var(--text); font-weight: 600;">AF {{ number_format($metrics['financial']['debt_stats']['highest_debt'], 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Members at Risk -->
@if(!empty($expiringSoon) || !empty($withDebt) || !empty($inactive))
<div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));">
    <!-- Expiring Soon -->
    @if(!empty($expiringSoon))
    <div class="card">
        <div class="card-header">
            <h2 class="card-title" style="color: var(--warning);">⏰ در حال انقضا</h2>
        </div>
        <div style="display: grid; gap: 12px; max-height: 400px; overflow-y: auto;">
            @foreach(array_slice($expiringSoon, 0, 5) as $member)
            <div style="padding: 12px; background: var(--surface-soft); border-radius: 8px; border: 1px solid var(--border);">
                <p style="margin: 0 0 4px; font-weight: 600; color: var(--text);">{{ $member['name'] }}</p>
                <p style="margin: 0 0 8px; color: var(--warning); font-size: 0.9rem;">{{ \Carbon\Carbon::parse($member['expiry_date'])->format('M d, Y') }}</p>
                <a href="{{ route('members.show', $member['id']) }}" class="button button-outline" style="font-size: 0.85rem; padding: 6px 12px;">مشاهده پروفایل</a>
            </div>
            @endforeach
        </div>
        @if(count($expiringSoon) > 5)
        <div style="margin-top: 16px; text-align: center;">
            <a href="{{ route('members.index', ['filter' => 'expiring_soon']) }}" class="button button-secondary" style="font-size: 0.9rem;">مشاهده همه {{ count($expiringSoon) }}</a>
        </div>
        @endif
    </div>
    @endif

    <!-- Members with Debt -->
    @if(!empty($withDebt))
    <div class="card">
        <div class="card-header">
            <h2 class="card-title" style="color: var(--danger);">💳 اعضای بدهکار</h2>
        </div>
        <div style="display: grid; gap: 12px; max-height: 400px; overflow-y: auto;">
            @foreach(array_slice($withDebt, 0, 5) as $member)
            <div style="padding: 12px; background: var(--surface-soft); border-radius: 8px; border: 1px solid var(--border);">
                <p style="margin: 0 0 4px; font-weight: 600; color: var(--text);">{{ $member['name'] }}</p>
                <p style="margin: 0 0 8px; color: var(--danger); font-size: 0.9rem;">{{ number_format($member['debt'], 2) }} افغانی بدهی</p>
                <a href="{{ route('members.show', $member['id']) }}" class="button button-outline" style="font-size: 0.85rem; padding: 6px 12px;">مشاهده پروفایل</a>
            </div>
            @endforeach
        </div>
        @if(count($withDebt) > 5)
        <div style="margin-top: 16px; text-align: center;">
            <a href="{{ route('members.index', ['filter' => 'in_debt']) }}" class="button button-secondary" style="font-size: 0.9rem;">مشاهده همه {{ count($withDebt) }}</a>
        </div>
        @endif
    </div>
    @endif

    <!-- Inactive Members -->
    @if(!empty($inactive))
    <div class="card">
        <div class="card-header">
            <h2 class="card-title" style="color: var(--accent);">😴 اعضای غیرفعال</h2>
        </div>
        <div style="display: grid; gap: 12px; max-height: 400px; overflow-y: auto;">
            @foreach(array_slice($inactive, 0, 5) as $member)
            <div style="padding: 12px; background: var(--surface-soft); border-radius: 8px; border: 1px solid var(--border);">
                <p style="margin: 0 0 4px; font-weight: 600; color: var(--text);">{{ $member['name'] }}</p>
                <p style="margin: 0 0 8px; color: var(--accent); font-size: 0.9rem;">بدون حضور اخیر</p>
                <a href="{{ route('members.show', $member['id']) }}" class="button button-outline" style="font-size: 0.85rem; padding: 6px 12px;">مشاهده پروفایل</a>
            </div>
            @endforeach
        </div>
        @if(count($inactive) > 5)
        <div style="margin-top: 16px; text-align: center;">
            <a href="{{ route('members.index', ['filter' => 'inactive']) }}" class="button button-secondary" style="font-size: 0.9rem;">مشاهده همه {{ count($inactive) }}</a>
        </div>
        @endif
    </div>
    @endif
</div>
@endif

<!-- Income by Plan -->
@if(!empty($incomeByPlan))
<div class="card">
    <div class="card-header">
        <h2 class="card-title">💵 درآمد بر اساس پلن</h2>
    </div>
    <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));">
        @foreach($incomeByPlan as $plan)
        <div style="padding: 20px; background: var(--surface-soft); border-radius: 12px; border: 1px solid var(--border);">
            <h4 style="margin: 0 0 16px; font-weight: 600; color: var(--text);">{{ $plan['plan_name'] }}</h4>
            <div style="display: grid; gap: 8px; font-size: 0.9rem;">
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--muted);">کل درآمد:</span>
                    <span style="color: var(--success); font-weight: 600;">AF {{ number_format($plan['total_income'], 2) }}</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--muted);">پرداخت‌ها:</span>
                    <span style="color: var(--text); font-weight: 600;">{{ $plan['payment_count'] }}</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--muted);">میانگین پرداخت:</span>
                    <span style="color: var(--text); font-weight: 600;">AF {{ number_format($plan['average_payment'], 2) }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- Quick Actions -->
<div class="card">
    <div class="card-header">
        <h2 class="card-title">اقدامات سریع</h2>
    </div>
    <div class="button-group">
        <a href="{{ route('members.create') }}" class="button">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20" style="margin-right: 8px;">
                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
            </svg>
            افزودن عضو
        </a>
        <a href="{{ route('payments.create') }}" class="button button-success">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20" style="margin-right: 8px;">
                <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"/>
            </svg>
            ثبت پرداخت
        </a>
        <a href="{{ route('members.index') }}" class="button button-secondary">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20" style="margin-right: 8px;">
                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
            </svg>
            مشاهده اعضا
        </a>
        <a href="{{ route('reports.index') }}" class="button button-secondary">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 20 20" style="margin-right: 8px;">
                <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            مشاهده گزارش‌ها
        </a>
    </div>
</div>
@endsection
