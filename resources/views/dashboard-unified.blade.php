@extends('layouts.app')

@section('title', 'داشبورد')

@section('content')
<div class="page-header">
    <h1 class="page-title">داشبورد</h1>
    <p class="page-subtitle">خوش آمدید! نمای کلی مدیریت باشگاه</p>
</div>

<!-- Quick Stats -->
@if(!empty($quickStats))
<div class="grid">
    @foreach($quickStats as $stat)
    <div class="stat-card">
        <div class="stat-card-content">
            <div class="stat-icon">{!! $stat['icon'] !!}</div>
            <div class="stat-info">
                <h3>{{ $stat['label'] }}</h3>
                <p>{{ $stat['value'] }}</p>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endif

<!-- Alerts -->
@if(!empty($alerts))
<div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));">
    @foreach($alerts as $alert)
    <div class="alert alert-{{ $alert['type'] }}">
        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20" style="flex-shrink: 0;">
            @if($alert['type'] === 'danger')
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            @elseif($alert['type'] === 'warning')
            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            @else
            <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0zm6 0a1 1 0 11-2 0 1 1 0 012 0zm2 6a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"/>
            @endif
        </svg>
        <div>
            <h4 style="margin: 0 0 4px; font-weight: 600; color: var(--text);">{{ $alert['title'] }}</h4>
            <p style="margin: 0 0 8px; font-size: 0.9rem;">{{ $alert['message'] }}</p>
            <a href="{{ $alert['action_url'] }}" class="button button-outline" style="font-size: 0.85rem; padding: 6px 12px;">مشاهده</a>
        </div>
    </div>
    @endforeach
</div>
@endif

<!-- Key Metrics -->
<div class="grid" style="grid-template-columns: 1fr 1fr; gap: 24px;">
    <!-- Members Overview -->
    <x-ui-card title="نمای کلی اعضا">
        <div style="display: grid; gap: 16px;">
            <div style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid var(--border);">
                <span style="color: var(--muted);">کل اعضا</span>
                <span style="font-weight: 600; color: var(--text);">{{ $metrics['members']['total_members'] ?? 0 }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid var(--border);">
                <span style="color: var(--muted);">فعال</span>
                <span class="status-chip status-success">{{ $metrics['members']['active_members'] ?? 0 }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid var(--border);">
                <span style="color: var(--muted);">منقضی شده</span>
                <span class="status-chip status-error">{{ $metrics['members']['expired_members'] ?? 0 }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid var(--border);">
                <span style="color: var(--muted);">در حال انقضا (۳ روز)</span>
                <span class="status-chip status-warning">{{ $metrics['members']['members_expiring_soon'] ?? 0 }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 12px 0;">
                <span style="color: var(--muted);">بدهکار</span>
                <span class="status-chip status-error">{{ $metrics['members']['members_with_debt'] ?? 0 }}</span>
            </div>
        </div>
    </x-ui-card>

    <!-- Financial Overview -->
    <x-ui-card title="نمای کلی مالی">
        <div style="display: grid; gap: 16px;">
            <div style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid var(--border);">
                <span style="color: var(--muted);">درآمد امروز</span>
                <span class="status-chip status-success">{{ number_format($metrics['financial']['today_income'] ?? 0, 0) }} افغانی</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid var(--border);">
                <span style="color: var(--muted);">درآمد ماهانه</span>
                <span class="status-chip status-success">{{ number_format($metrics['financial']['monthly_income'] ?? 0, 0) }} افغانی</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid var(--border);">
                <span style="color: var(--muted);">بدهی معوق</span>
                <span class="status-chip status-error">{{ number_format($metrics['financial']['total_outstanding_debt'] ?? 0, 0) }} افغانی</span>
            </div>
            <div style="padding: 12px; background: var(--surface-soft); border-radius: 8px;">
                <p style="margin: 0 0 8px; color: var(--muted); font-size: 0.9rem; font-weight: 600;">آمار بدهی</p>
                <div style="display: grid; gap: 8px; font-size: 0.9rem;">
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--muted);">میانگین</span>
                        <span style="color: var(--text); font-weight: 600;">{{ number_format($metrics['financial']['debt_stats']['average_debt_per_member'] ?? 0, 0) }} افغانی</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: var(--muted);">بالاترین</span>
                        <span style="color: var(--text); font-weight: 600;">{{ number_format($metrics['financial']['debt_stats']['highest_debt'] ?? 0, 0) }} افغانی</span>
                    </div>
                </div>
            </div>
        </div>
    </x-ui-card>
</div>

<!-- At-Risk Sections -->
@if(!empty($expiringSoon) || !empty($withDebt) || !empty($inactive))
<div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));">
    <!-- Expiring Soon -->
    @if(!empty($expiringSoon))
    <x-ui-card title="⏰ در حال انقضا">
        <div style="display: grid; gap: 12px; max-height: 400px; overflow-y: auto;">
            @foreach(array_slice($expiringSoon, 0, 5) as $member)
            <div style="padding: 12px; background: var(--surface-soft); border-radius: 8px; border: 1px solid var(--border);">
                <p style="margin: 0 0 4px; font-weight: 600; color: var(--text);">{{ $member['name'] }}</p>
                <p class="small text-muted" style="margin: 0 0 8px;">{{ \Carbon\Carbon::parse($member['expiry_date'])->format('j F Y') }}</p>
                <a href="{{ route('members.show', $member['id']) }}" class="button button-outline" style="font-size: 0.85rem; padding: 6px 12px;">مشاهده</a>
            </div>
            @endforeach
        </div>
        @if(count($expiringSoon) > 5)
        <div style="margin-top: 16px; text-align: center;">
            <a href="{{ route('members.index', ['filter' => 'expiring_soon']) }}" class="button button-secondary">مشاهده همه</a>
        </div>
        @endif
    </x-ui-card>
    @endif

    <!-- With Debt -->
    @if(!empty($withDebt))
    <x-ui-card title="💳 بدهکاران">
        <div style="display: grid; gap: 12px; max-height: 400px; overflow-y: auto;">
            @foreach(array_slice($withDebt, 0, 5) as $member)
            <div style="padding: 12px; background: var(--surface-soft); border-radius: 8px; border: 1px solid var(--border);">
                <p style="margin: 0 0 4px; font-weight: 600; color: var(--text);">{{ $member['name'] }}</p>
                <p class="small text-muted" style="margin: 0 0 8px;">{{ number_format($member['debt'], 0) }} افغانی</p>
                <a href="{{ route('members.show', $member['id']) }}" class="button button-outline" style="font-size: 0.85rem; padding: 6px 12px;">مشاهده</a>
            </div>
            @endforeach
        </div>
        @if(count($withDebt) > 5)
        <div style="margin-top: 16px; text-align: center;">
            <a href="{{ route('members.index', ['filter' => 'in_debt']) }}" class="button button-secondary">مشاهده همه</a>
        </div>
        @endif
    </x-ui-card>
    @endif

    <!-- Inactive -->
    @if(!empty($inactive))
    <x-ui-card title="😴 غیرفعال">
        <div style="display: grid; gap: 12px; max-height: 400px; overflow-y: auto;">
            @foreach(array_slice($inactive, 0, 5) as $member)
            <div style="padding: 12px; background: var(--surface-soft); border-radius: 8px; border: 1px solid var(--border);">
                <p style="margin: 0 0 4px; font-weight: 600; color: var(--text);">{{ $member['name'] }}</p>
                <p class="small text-muted" style="margin: 0 0 8px;">بدون حضور اخیر</p>
                <a href="{{ route('members.show', $member['id']) }}" class="button button-outline" style="font-size: 0.85rem; padding: 6px 12px;">مشاهده</a>
            </div>
            @endforeach
        </div>
        @if(count($inactive) > 5)
        <div style="margin-top: 16px; text-align: center;">
            <a href="{{ route('members.index', ['filter' => 'inactive']) }}" class="button button-secondary">مشاهده همه</a>
        </div>
        @endif
    </x-ui-card>
    @endif
</div>
@endif

<!-- Income by Plan -->
@if(!empty($incomeByPlan))
<x-ui-card title="💵 درآمد براساس پلن">
    <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));">
        @foreach($incomeByPlan as $plan)
        <div style="padding: 20px; background: var(--surface-soft); border-radius: 12px; border: 1px solid var(--border);">
            <h4 style="margin: 0 0 16px; font-weight: 600; color: var(--text);">{{ $plan['plan_name'] }}</h4>
            <div style="display: grid; gap: 8px; font-size: 0.9rem;">
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--muted);">کل درآمد</span>
                    <span class="status-chip status-success">{{ number_format($plan['total_income'], 0) }} افغانی</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--muted);">پرداخت‌ها</span>
                    <span style="color: var(--text); font-weight: 600;">{{ $plan['payment_count'] }}</span>
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <span style="color: var(--muted);">میانگین</span>
                    <span style="color: var(--text); font-weight: 600;">{{ number_format($plan['average_payment'], 0) }} افغانی</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</x-ui-card>
@endif

<!-- Quick Actions -->
<x-ui-card title="اقدامات سریع">
    <div class="button-group">
        <x-ui-button type="primary" href="{{ route('members.create') }}">افزودن عضو</x-ui-button>
        <x-ui-button type="success" href="{{ route('payments.create') }}">ثبت پرداخت</x-ui-button>
        <x-ui-button type="secondary" href="{{ route('members.index') }}">مشاهده اعضا</x-ui-button>
        <x-ui-button type="secondary" href="{{ route('reports.index') }}">مشاهده گزارش‌ها</x-ui-button>
    </div>
</x-ui-card>

@endsection
