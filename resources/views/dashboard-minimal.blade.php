@extends('layouts.app')

@section('title', __('messages.dashboard'))

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">داشبورد</h1>
        <p class="page-subtitle">به سیستم مدیریت باشگاه خود خوش آمدید</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('members.create') }}" class="btn">+ افزودن عضو</a>
        <a href="{{ route('attendance.index') }}" class="btn-outline">ورود</a>
    </div>
</div>

<!-- Stats Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
    <div class="card">
        <div class="card-body">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-muted">کل اعضا</p>
                    <p style="font-size: 24px; font-weight: 700; margin: 4px 0;">۱,۲۴۷</p>
                </div>
                <div style="width: 40px; height: 40px; background: var(--accent-soft); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20" style="color: var(--accent);">
                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-muted">برنامه‌های فعال</p>
                    <p style="font-size: 24px; font-weight: 700; margin: 4px 0;">۸۹۲</p>
                </div>
                <div style="width: 40px; height: 40px; background: var(--success-soft); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20" style="color: var(--success);">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-muted">درآمد (ماه جاری)</p>
                    <p style="font-size: 24px; font-weight: 700; margin: 4px 0;">۴۵,۲۳۰ تومان</p>
                </div>
                <div style="width: 40px; height: 40px; background: var(--warning-soft); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20" style="color: var(--warning);">
                        <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-muted">ورودهای امروز</p>
                    <p style="font-size: 24px; font-weight: 700; margin: 4px 0;">۶۷</p>
                </div>
                <div style="width: 40px; height: 40px; background: var(--success-soft); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20" style="color: var(--success);">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- فعالیت‌های اخیر -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
    <div class="card">
        <div class="card-header">ورودهای اخیر</div>
        <div class="card-body">
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <div class="flex items-center justify-between">
                    <div>
                        <p style="margin: 0; font-weight: 500;">علی محمدی</p>
                        <p style="margin: 0; font-size: 12px; color: var(--text-muted);">۹:۱۵ صبح</p>
                    </div>
                    <span class="status-badge status-success">ورود کرده</span>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <p style="margin: 0; font-weight: 500;">فاطمه احمدی</p>
                        <p style="margin: 0; font-size: 12px; color: var(--text-muted);">۸:۴۵ صبح</p>
                    </div>
                    <span class="status-badge status-success">ورود کرده</span>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <p style="margin: 0; font-weight: 500;">حسن رضایی</p>
                        <p style="margin: 0; font-size: 12px; color: var(--text-muted);">۸:۳۰ صبح</p>
                    </div>
                    <span class="status-badge status-success">Checked In</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">انقضاهای نزدیک</div>
        <div class="card-body">
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <div class="flex items-center justify-between">
                    <div>
                        <p style="margin: 0; font-weight: 500;">رضا کریمی</p>
                        <p style="margin: 0; font-size: 12px; color: var(--text-muted);">۳ روز دیگر منقضی می‌شود</p>
                    </div>
                    <span class="status-badge status-warning">در حال انقضا</span>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <p style="margin: 0; font-weight: 500;">مریم احمدی</p>
                        <p style="margin: 0; font-size: 12px; color: var(--text-muted);">۷ روز دیگر منقضی می‌شود</p>
                    </div>
                    <span class="status-badge status-warning">در حال انقضا</span>
                </div>
                <div class="flex items-center justify-between">
                    <div>
                        <p style="margin: 0; font-weight: 500;">سارا حسینی</p>
                        <p style="margin: 0; font-size: 12px; color: var(--text-muted);">منقضی شده</p>
                    </div>
                    <span class="status-badge status-error">منقضی شده</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection