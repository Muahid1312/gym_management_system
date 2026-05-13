@extends('layouts.app')

@section('title', __('messages.members'))

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">اعضا</h1>
        <p class="page-subtitle">تنظیم اعضا و معلومات آنها</p>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('members.create') }}" class="btn">+ افزودن عضو</a>
        <button class="btn-outline" onclick="exportMembers()">خروجی گرفتن</button>
    </div>
</div>

<!-- Search and Filters -->
<div class="card" style="margin-bottom: 24px;">
    <div class="card-body">
        <form method="GET" action="{{ route('members.index') }}" style="display: grid; grid-template-columns: 1fr auto auto; gap: 16px; align-items: end;">
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">جستجو</label>
                <input type="text" class="form-input" name="search" placeholder="Search by name, email, or phone..." value="{{ $search ?? '' }}">
            </div>
            <div class="form-group" style="margin-bottom: 0;">
                <label class="form-label">وضعیت</label>
                <select class="form-input" name="filter">
                    <option value="all" {{ ($filter ?? 'all') === 'all' ? 'selected' : '' }}>همه وضعیت‌ها</option>
                    <option value="active" {{ ($filter ?? 'all') === 'active' ? 'selected' : '' }}>فعال</option>
                    <option value="expired" {{ ($filter ?? 'all') === 'expired' ? 'selected' : '' }}>منقضی شده</option>
                    <option value="expiring_soon" {{ ($filter ?? 'all') === 'expiring_soon' ? 'selected' : '' }}>در حال انقضا</option>
                    <option value="in_debt" {{ ($filter ?? 'all') === 'in_debt' ? 'selected' : '' }}>بدهکار</option>
                </select>
            </div>
            <button type="submit" class="btn">اعمال فیلترها</button>
        </form>
    </div>
</div>

<!-- Members Table -->
<div class="card">
    <div class="card-header">
        Members ({{ $members->count() }} total)
    </div>
    <div class="card-body" style="padding: 0;">
        <table class="table">
            <thead>
                <tr>
                    <th>عضو</th>
                    <th>پلان</th>
                    <th>وضیعت</th>
                    <th>زمان عضویت</th>
                    <th>تاریخ انقضا</th>
                    <th>عملکرد ها</th>
                </tr>
            </thead>
            <tbody>
                @forelse($members as $member)
                <tr>
                    <td>
                        <div class="flex items-center gap-3">
                            <div style="width: 32px; height: 32px; background: var(--accent); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 600; font-size: 12px;">
                                {{ strtoupper(substr($member->name, 0, 1)) }}
                            </div>
                            <div>
                                <p style="margin: 0; font-weight: 500;">{{ $member->name }}</p>
                                <p style="margin: 0; font-size: 12px; color: var(--text-muted);">{{ $member->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td>{{ $member->plan?->name ?? 'No Plan' }}</td>
                    <td>
                        @if($member->expiry_date && $member->expiry_date->isFuture())
                            @if($member->expiry_date->diffInDays(now()) <= 3)
                                <span class="status-badge status-warning">در حال انقضا</span>
                            @else
                                <span class="status-badge status-success">فعال</span>
                            @endif
                        @else
                            <span class="status-badge status-error">منقضی شده</span>
                        @endif
                    </td>
                    <td>{{ $member->created_at?->format('M d, Y') ?? 'N/A' }}</td>
                    <td>{{ $member->expiry_date?->format('M d, Y') ?? 'N/A' }}</td>
                    <td>
                        <div class="flex gap-2">
                            <a href="{{ route('members.show', $member) }}" class="btn-outline" style="padding: 4px 8px; font-size: 12px;">دیدن</a>
                            <a href="{{ route('ai.show-plans-minimal', $member) }}" class="btn-outline" style="padding: 4px 8px; font-size: 12px;">
                                <svg class="icon" fill="currentColor" viewBox="0 0 20 20" style="width: 12px; height: 12px;">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                </svg>
                                پلان ها
                            </a>
                            <a href="{{ route('members.edit', $member) }}" class="btn-outline" style="padding: 4px 8px; font-size: 12px;">ویرایش</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 48px; color: var(--text-muted);">
                        <svg width="48" height="48" fill="currentColor" viewBox="0 0 20 20" style="margin: 0 auto 16px; opacity: 0.5;">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p style="margin: 0; font-size: 16px;">عضوی یافت نشد</p>
                        <p style="margin: 8px 0 24px 0; font-size: 14px;">عبارت جستجو با فیلتر را تغییر دهید</p>
                        <a href="{{ route('members.create') }}" class="btn">اضافه کردن عضو جدید</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination -->
@if(isset($members) && $members->hasPages())
<div style="display: flex; justify-content: between; align-items: center; margin-top: 24px;">
    <p class="text-sm text-muted">اعضای {{ $members->firstItem() }}-{{ $members->lastItem() }} از {{ $members->total() }} نشان میدهد</p>
    <div class="flex gap-2">
        @if($members->onFirstPage())
            <button class="btn-outline" disabled>قبلی</button>
        @else
            <a href="{{ $members->previousPageUrl() }}" class="btn-outline">قبلی</a>
        @endif

        @foreach($members->getUrlRange(1, $members->lastPage()) as $page => $url)
            @if($page == $members->currentPage())
                <button class="btn">{{ $page }}</button>
            @else
                <a href="{{ $url }}" class="btn-outline">{{ $page }}</a>
            @endif
        @endforeach

        @if($members->hasMorePages())
            <a href="{{ $members->nextPageUrl() }}" class="btn-outline">بعدی</a>
        @else
            <button class="btn-outline" disabled>بعدی</button>
        @endif
    </div>
</div>
@endif

<script>
function exportMembers() {
    // In a real app, this would trigger a CSV/PDF export
    alert('عملیه خروجی اینحا صورت میگرد');
}
</script>
@endsection