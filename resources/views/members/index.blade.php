@extends('layouts.app')

@section('title', 'Members')

@section('content')
<div class="page-header">
    <h1 class="page-title">مدیریت اعضاء</h1>
    <p class="page-subtitle">اعضای باشگاه خود را به یک انترفیس حرفه ای و یکپارچه  جستجو فیلتر و مدیریت کنید!</p>
</div>

<div class="button-group" style="margin-bottom: 2rem;">
    <a href="{{ route('members.create') }}" class="button">عضو جدید</a>
    <a href="{{ route('members.index', array_merge(request()->except('view_mode'), ['view_mode' => $viewMode === 'modal' ? 'dropdown' : 'modal'])) }}" class="button button-outline">
        {{ $viewMode === 'modal' ? 'Use Dropdown UI' : 'نمایش به شکل پروفایل' }}
    </a>
</div>

@if($members->isEmpty())
    <div class="card">
        <div class="card-body" style="text-align: center;">
            <h3 style="margin: 0 0 1rem 0; font-size: 1.25rem; font-weight: 600;">عضوی یافت نشد</h3>
            <p style="margin: 0 0 1.5rem 0; color: var(--text-muted);">جستجوی شما نتیجه ای نداشت.</p>
            <a href="{{ route('members.create') }}" class="button">عضو اول را اضافه کنید</a>
        </div>
    </div>
@else
    <div style="display: grid; gap: 1.5rem;">
        @foreach($members as $member)
            <div class="card">
                <div class="card-body">
                    <div style="display: flex; gap: 1.5rem; align-items: flex-start;">
                        <div style="flex-shrink: 0;">
                            @if($member->photo)
                                <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}" style="width: 4rem; height: 4rem; border-radius: 50%; object-fit: cover;" />
                            @else
                                <div style="width: 4rem; height: 4rem; border-radius: 50%; background-color: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.25rem;">
                                    {{ strtoupper(substr($member->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div style="flex: 1;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                                <div>
                                    <h3 style="margin: 0 0 0.25rem 0; font-size: 1.25rem; font-weight: 600;">{{ $member->name }}</h3>
                                    <p style="margin: 0; color: var(--text-muted);">{{ $member->phone }} · {{ $member->email }}</p>
                                </div>
                                <div style="display: flex; gap: 0.5rem;">
                                    @if($member->expiry_date && $member->expiry_date->isFuture())
                                        @if($member->expiry_date->diffInDays(now()) <= 3)
                                            <span style="background-color: var(--warning); color: white; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">⏰ Expiring Soon</span>
                                        @else
                                            <span style="background-color: var(--success); color: white; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">✅ Active</span>
                                        @endif
                                    @else
                                        <span style="background-color: var(--danger); color: white; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">❌ Expired</span>
                                    @endif
                                </div>
                            </div>

                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
                                <div>
                                    <span style="color: var(--text-muted); font-size: 0.875rem;">پلان</span>
                                    <p style="margin: 0.25rem 0 0 0; font-weight: 600;">{{ $member->plan->name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <span style="color: var(--text-muted); font-size: 0.875rem;">تاریخ انقضا</span>
                                    <p style="margin: 0.25rem 0 0 0; font-weight: 600;">{{ $member->expiry_date?->format('M d, Y') ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <span style="color: var(--text-muted); font-size: 0.875rem;">بدهی</span>
                                    <p style="margin: 0.25rem 0 0 0; font-weight: 600; color: {{ $member->debt > 0 ? 'var(--danger)' : 'var(--success)' }};">AF {{ number_format($member->debt, 2) }}</p>
                                </div>
                                <div>
                                    <span style="color: var(--text-muted); font-size: 0.875rem;">سطوح</span>
                                    <p style="margin: 0.25rem 0 0 0; font-weight: 600;">{{ ucfirst($member->workout_level) }} / {{ ucfirst($member->diet_level) }}</p>
                                </div>
                            </div>

                            <div class="button-group">
                                <a href="{{ route('members.show', $member) }}" class="button">نمایش پروفایل</a>
                                <a href="{{ route('ai.show-plans', $member) }}" class="button button-outline">نمایش پلان‌ها</a>
                                <a href="{{ route('members.edit', $member) }}" class="button button-outline">ویرایش</a>
                                <form action="{{ route('members.destroy', $member) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="button" style="background-color: var(--danger); border-color: var(--danger);" onclick="return confirm('Are you sure you want to delete this member?');">حذف</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

<!-- Search and Filter Form -->
<div class="card" style="margin-top: 2rem;">
    <div class="card-header">
        <h2 class="card-title">Search & Filter</h2>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('members.index') }}" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; align-items: end;">
            @if($viewMode === 'modal')
                <input type="hidden" name="view_mode" value="modal">
            @endif

            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Search</label>
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search by name, father's name, or phone" style="width: 100%; padding: 0.5rem; border: 1px solid var(--border); border-radius: 4px;" />
            <div>
                <label style="display: block; margin-bottom: 0.5rem; font-weight: 600;">Filter</label>
                <select name="filter" style="width: 100%; padding: 0.5rem; border: 1px solid var(--border); border-radius: 4px;">
                    <option value="all" {{ ($filter ?? 'all') === 'all' ? 'selected' : '' }}>All Members</option>
                    <option value="active" {{ ($filter ?? 'all') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="expired" {{ ($filter ?? 'all') === 'expired' ? 'selected' : '' }}>Expired</option>
                    <option value="expiring_soon" {{ ($filter ?? 'all') === 'expiring_soon' ? 'selected' : '' }}>Expiring Soon</option>
                    <option value="in_debt" {{ ($filter ?? 'all') === 'in_debt' ? 'selected' : '' }}>In Debt</option>
                </select>
            </div>

            <div>
                <button type="submit" class="button">Search</button>
            </div>
        </form>
    </div>
</div>
@endsection
