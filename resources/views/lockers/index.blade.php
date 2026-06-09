@extends('layouts.app-modern')

@section('title', 'Locker Management')

@section('content')
    <div class="page-header">
        <h1 class="page-title">مدیریت الماری</h1>
        <p class="page-subtitle">دیدن موجودی الماری٫ وضیعت الماری٫گزارش از فعالیت الماری</p>
    </div>

    <div class="button-group" style="margin-bottom: 1.5rem;">
        <a href="{{ route('lockers.create') }}" class="button">ساخت الماری</a>
        @if($firstAvailableLocker)
            <div class="status-chip status-success">پیشنهاد میشود: {{ $firstAvailableLocker->locker_number }}</div>
        @else
            <div class="status-chip status-warning">الماری فعال موجود نیست!</div>
        @endif
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">تخصیص الماری</h2>
            </div>

            <div class="card-body">
                @if($availableLockers->isEmpty())
                    <p style="color: var(--text-muted);">تمام الماری ها تخصیص داده شده ویا غیر فعال میباشند٫ الماری جدید بسازید!</p>
                @else
                    <form action="{{ route('lockers.assign') }}" method="POST" data-offline-sync="true" data-offline-sync-url="{{ route('lockers.assign') }}">
                        @csrf

                        <div class="form-group">
                            <label for="member_id">عضو</label>
                            <select name="member_id" id="member_id" required>
                                <option value="">انتخاب عضو</option>
                                @foreach($members as $member)
                                    <option value="{{ $member->id }}" {{ $member->id == $selectedMemberId ? 'selected' : '' }}>{{ $member->name }} ({{ $member->phone }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="locker_id">الماری</label>
                            <select name="locker_id" id="locker_id" required>
                                @foreach($availableLockers as $locker)
                                    <option value="{{ $locker->id }}">{{ $locker->locker_number }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="expiry_date">تاریخ انقضا (اختیاری)</label>
                            <input type="date" name="expiry_date" id="expiry_date" />
                        </div>

                        <div class="form-group" style="display: flex; align-items: center; gap: 0.75rem;">
                            <input type="checkbox" name="temporary" id="temporary" value="1" />
                            <label for="temporary" style="margin: 0;">روز های خالی هم حساب شود!</label>
                        </div>

                        <button type="submit" class="button">تخصیص الماری</button>
                    </form>
                @endif
            </div>
        </div>

        <div class="card lg:col-span-2">
            <div class="card-header">
                <h2 class="card-title">صفحه الماری</h2>
            </div>
            <div class="card-body">
                <div class="grid lg:grid-cols-3 gap-4">
                    @forelse($lockers as $locker)
                        @php
                            $statusClass = match($locker->status) {
                                'available' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                'occupied' => 'bg-rose-100 text-rose-700 border-rose-200',
                                'maintenance' => 'bg-amber-100 text-amber-700 border-amber-200',
                                default => 'bg-slate-100 text-slate-700 border-slate-200',
                            };
                        @endphp
                        <div class="card" style="border: 1px solid var(--border); background: var(--surface);">
                            <div style="display:flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                                <div>
                                    <p style="margin:0; font-size: 0.95rem; color: var(--muted);">الماری</p>
                                    <h3 style="margin:0; font-size: 1.5rem; font-weight: 700;">{{ $locker->locker_number }}</h3>
                                </div>
                                <span style="padding: 0.45rem 0.8rem; border-radius: 9999px; font-size: 0.8rem; font-weight: 700; {{ $statusClass }}">{{ ucfirst($locker->status) }}</span>
                            </div>

                            @if($locker->activeAssignment)
                                <p style="margin: 0 0 0.5rem 0; color: var(--text-muted);">تخصیص به</p>
                                <p style="margin: 0 0 1rem 0; font-weight: 600;">{{ $locker->activeAssignment->member->name }}</p>
                                <p style="margin: 0 0 1rem 0; color: var(--text-muted);">انقضا: {{ $locker->activeAssignment->expiry_date?->format('M d, Y') ?? 'No expiry' }}</p>
                                <form action="{{ route('lockers.release', $locker) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="button button-secondary">آزاد سازی الماری</button>
                                </form>
                            @else
                                <p style="margin: 0 0 1rem 0; color: var(--text-muted);">آماده برای استفاده است!</p>
                                @if($locker->status === 'available')
                                    <a href="{{ route('lockers.index', ['member' => $selectedMemberId]) }}#member_id" class="button button-outline">تخصیص از بالا</a>
                                @else
                                    <p style="font-size: 0.9rem; color: var(--text-muted);">قفل های که در حالت تعمیر استند را میتوان  ویرایش کرد تا فعال گردند!</p>
                                @endif
                            @endif
                        </div>
                    @empty
                        <p style="color: var(--text-muted);">تا هنوز الماری ای تنظیم نشده٫ لطفا الماری جدید بسازید!</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
