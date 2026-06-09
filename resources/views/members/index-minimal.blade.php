@extends('layouts.app-modern')

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
<x-card class="mb-6">
    <form method="GET" action="{{ route('members.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
        <div>
            <label class="form-label">جستجو</label>
            <input type="text" class="form-input" name="search" placeholder="Search by name, email, or phone..." value="{{ $search ?? '' }}">
        </div>

        <div>
            <label class="form-label">وضعیت</label>
            <select class="form-input" name="filter">
                <option value="all" {{ ($filter ?? 'all') === 'all' ? 'selected' : '' }}>همه وضعیت‌ها</option>
                <option value="active" {{ ($filter ?? 'all') === 'active' ? 'selected' : '' }}>فعال</option>
                <option value="expired" {{ ($filter ?? 'all') === 'expired' ? 'selected' : '' }}>منقضی شده</option>
                <option value="expiring_soon" {{ ($filter ?? 'all') === 'expiring_soon' ? 'selected' : '' }}>در حال انقضا</option>
                <option value="in_debt" {{ ($filter ?? 'all') === 'in_debt' ? 'selected' : '' }}>بدهکار</option>
            </select>
        </div>

        <div class="flex gap-2">
            <x-button href="{{ route('members.index') }}" variant="outline">اعمال فیلترها</x-button>
        </div>
    </form>
</x-card>

<!-- Members Table -->
<x-card>
    <div class="flex items-center justify-between mb-4">
        <div class="text-sm text-slate-600">Members ({{ $members->count() }} total)</div>
        <div></div>
    </div>

    <x-table>
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
                            <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-xs">
                                {{ strtoupper(substr($member->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="m-0 font-medium">{{ $member->name }}</p>
                                <p class="m-0 text-xs text-slate-500">{{ $member->email }}</p>
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
                            <x-button href="{{ route('members.show', $member) }}" variant="outline" size="sm">دیدن</x-button>
                            <x-button href="{{ route('ai.show-plans-minimal', $member) }}" variant="ghost" size="sm">پلان ها</x-button>
                            <x-button href="{{ route('members.edit', $member) }}" variant="outline" size="sm">ویرایش</x-button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-12 text-slate-500">
                        <svg width="48" height="48" fill="currentColor" viewBox="0 0 20 20" class="mx-auto mb-4 opacity-50">
                            <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-base">عضوی یافت نشد</p>
                        <p class="text-sm mt-2 mb-4">عبارت جستجو با فیلتر را تغییر دهید</p>
                        <x-button href="{{ route('members.create') }}">اضافه کردن عضو جدید</x-button>
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