@extends('layouts.app-modern')

@section('title', 'اعضا')

@section('content')
<div class="page-header">
    <h1 class="page-title">مدیریت اعضاء</h1>
    <p class="page-subtitle">اعضای باشگاه خود را جستجو، فیلتر و مدیریت کنید</p>
</div>

<!-- Search and Filter Bar -->
<x-card class="mb-6">
    <form method="GET" action="{{ route('members.index') }}" class="grid gap-4 md:grid-cols-4">
        <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">جستجو</label>
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="نام، تلفن یا ایمیل" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-sky-500" />
        </div>

        <div>
            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">فیلتر</label>
            <select name="filter" class="w-full px-3 py-2 border border-slate-300 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                <option value="all" {{ ($filter ?? 'all') === 'all' ? 'selected' : '' }}>همه اعضا</option>
                <option value="active" {{ ($filter ?? 'all') === 'active' ? 'selected' : '' }}>فعال</option>
                <option value="expired" {{ ($filter ?? 'all') === 'expired' ? 'selected' : '' }}>منقضی شده</option>
                <option value="expiring_soon" {{ ($filter ?? 'all') === 'expiring_soon' ? 'selected' : '' }}>در حال انقضا</option>
                <option value="in_debt" {{ ($filter ?? 'all') === 'in_debt' ? 'selected' : '' }}>بدهکار</option>
            </select>
        </div>

        <div class="flex gap-2 md:col-span-2">
            <x-button type="submit" class="flex-1">🔍 جستجو</x-button>
            <x-button type="button" variant="outline" onclick="window.location.href='{{ route('members.index') }}'" class="flex-1">↺ پاک کردن</x-button>
        </div>
    </form>
</x-card>

@if($members->isEmpty())
    <x-card class="text-center py-12">
        <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-2">هیچ عضوی یافت نشد</h3>
        <p class="text-slate-600 dark:text-slate-400 mb-6">نتیجه‌ای برای جستجوی شما موجود نیست.</p>
        <x-button href="{{ route('members.create') }}">+ افزودن عضو جدید</x-button>
    </x-card>
@else
    <x-card class="overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700">
                    <tr>
                        <th class="px-6 py-3 text-left font-semibold text-slate-700 dark:text-slate-300">عضو</th>
                        <th class="px-6 py-3 text-left font-semibold text-slate-700 dark:text-slate-300">تماس</th>
                        <th class="px-6 py-3 text-left font-semibold text-slate-700 dark:text-slate-300">پلان</th>
                        <th class="px-6 py-3 text-left font-semibold text-slate-700 dark:text-slate-300">وضعیت</th>
                        <th class="px-6 py-3 text-left font-semibold text-slate-700 dark:text-slate-300">تاریخ انقضا</th>
                        <th class="px-6 py-3 text-left font-semibold text-slate-700 dark:text-slate-300">بدهی</th>
                        <th class="px-6 py-3 text-left font-semibold text-slate-700 dark:text-slate-300">عملیات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($members as $member)
                        <tr class="border-b border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    @if($member->photo)
                                        <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}" class="w-10 h-10 rounded-full object-cover" />
                                    @else
                                        <div class="w-10 h-10 rounded-full bg-sky-600 text-white flex items-center justify-center font-bold text-sm">
                                            {{ strtoupper(substr($member->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-semibold text-slate-900 dark:text-slate-100">{{ $member->name }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                                <div class="text-sm">{{ $member->phone }}</div>
                                <div class="text-xs text-slate-500 dark:text-slate-400">{{ $member->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium">{{ $member->plan->name ?? 'بدون پلان' }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($member->expiry_date && $member->expiry_date->isFuture())
                                    @if($member->expiry_date->diffInDays(now()) <= 3)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">⏰ در حال انقضا</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">✅ فعال</span>
                                    @endif
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">❌ منقضی</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                                {{ $member->expiry_date?->format('M d, Y') ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium {{ $member->debt > 0 ? 'text-red-600' : 'text-emerald-600' }}">
                                    AF {{ number_format($member->debt, 2) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <x-button href="{{ route('members.show', $member) }}" size="sm" variant="outline">مشاهده</x-button>
                                    <x-button href="{{ route('members.edit', $member) }}" size="sm" variant="outline">ویرایش</x-button>
                                    <form action="{{ route('members.destroy', $member) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <x-button type="submit" size="sm" variant="danger" onclick="return confirm('آیا مطمئن هستید؟');">حذف</x-button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-card>

    @if($members->hasPages())
        <div class="mt-6 flex justify-center">
            {{ $members->links() }}
        </div>
    @endif
@endif

<div class="mt-6">
    <x-button href="{{ route('members.create') }}">+ عضو جدید</x-button>
</div>
@endsection
