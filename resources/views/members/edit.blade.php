@extends('layouts.app')

@section('title', "Edit {$member->name}")

@section('content')
<div class="page-header">
    <h1 class="page-title">ویرایش عضو</h1>
    <p class="page-subtitle">معلومات {{ $member->name }} بروزرسانی شد.</p>
</div>

<div class="button-group" style="margin-bottom: 2rem;">
    <a href="{{ route('members.show', $member) }}" class="button button-outline">← بازگشت به پروفایل</a>
</div>

<div style="display: grid; grid-template-columns: 1fr; gap: 1.5rem;" class="lg:grid-cols-3">
    <div style="grid-column: span 2;">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">اطلاعات عضو</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('members.update', $member) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                        <div>
                            <label for="name" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">نام کامل</label>
                            <input id="name" name="name" type="text" value="{{ old('name', $member->name) }}" required style="width: 100%; padding: 0.5rem; border: 1px solid var(--border); border-radius: 4px;" />
                            @error('name')
                                <p style="color: var(--danger); font-size: 0.875rem; margin: 0.25rem 0 0 0;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">نام پدر</label>
                            <input id="email" name="email" type="text" value="{{ old('email', $member->email) }}" required style="width: 100%; padding: 0.5rem; border: 1px solid var(--border); border-radius: 4px;" placeholder="نام پدر" />
                            @error('email')
                                <p style="color: var(--danger); font-size: 0.875rem; margin: 0.25rem 0 0 0;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="phone" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">شماره تلفن</label>
                            <input id="phone" name="phone" type="tel" value="{{ old('phone', $member->phone) }}" required style="width: 100%; padding: 0.5rem; border: 1px solid var(--border); border-radius: 4px;" />
                            @error('phone')
                                <p style="color: var(--danger); font-size: 0.875rem; margin: 0.25rem 0 0 0;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="photo" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">عکس</label>
                            <input id="photo" name="photo" type="file" accept="image/*" style="width: 100%; padding: 0.5rem; border: 1px solid var(--border); border-radius: 4px;" />
                            @error('photo')
                                <p style="color: var(--danger); font-size: 0.875rem; margin: 0.25rem 0 0 0;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="plan_id" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">پلان عضویت</label>
                            <select id="plan_id" name="plan_id" required style="width: 100%; padding: 0.5rem; border: 1px solid var(--border); border-radius: 4px;">
                                @foreach($plans as $plan)
                                    <option value="{{ $plan->id }}" {{ old('plan_id', $member->plan_id) == $plan->id ? 'selected' : '' }}>{{ $plan->name }} ({{ $plan->duration_days }} days) - AF {{ number_format($plan->price, 2) }}</option>
                                @endforeach
                            </select>
                            @error('plan_id')
                                <p style="color: var(--danger); font-size: 0.875rem; margin: 0.25rem 0 0 0;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="join_date" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">زمان عضویت</label>
                            <input id="join_date" name="join_date" type="date" value="{{ old('join_date', $member->join_date->format('Y-m-d')) }}" required style="width: 100%; padding: 0.5rem; border: 1px solid var(--border); border-radius: 4px;" />
                            @error('join_date')
                                <p style="color: var(--danger); font-size: 0.875rem; margin: 0.25rem 0 0 0;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="workout_level" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">سطح تمرین</label>
                            <select id="workout_level" name="workout_level" required style="width: 100%; padding: 0.5rem; border: 1px solid var(--border); border-radius: 4px;">
                                <option value="">انتخاب سطح</option>
                                @foreach($levels as $level)
                                    <option value="{{ $level }}" {{ old('workout_level', $member->workout_level) == $level ? 'selected' : '' }}>{{ ucfirst($level) }}</option>
                                @endforeach
                            </select>
                            @error('workout_level')
                                <p style="color: var(--danger); font-size: 0.875rem; margin: 0.25rem 0 0 0;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="diet_level" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">سطح رژیم</label>
                            <select id="diet_level" name="diet_level" required style="width: 100%; padding: 0.5rem; border: 1px solid var(--border); border-radius: 4px;">
                                <option value="">انتخاب سطح</option>
                                @foreach($levels as $level)
                                    <option value="{{ $level }}" {{ old('diet_level', $member->diet_level) == $level ? 'selected' : '' }}>{{ ucfirst($level) }}</option>
                                @endforeach
                            </select>
                            @error('diet_level')
                                <p style="color: var(--danger); font-size: 0.875rem; margin: 0.25rem 0 0 0;">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border); display: flex; gap: 1rem;">
                        <a href="{{ route('members.show', $member) }}" class="button button-outline" style="flex: 1;">لغو</a>
                        <button type="submit" class="button" style="flex: 1;">به‌روزرسانی عضو</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <aside style="display: grid; gap: 1.5rem;">
        @if($member->photo)
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">عکس عضو</h2>
                </div>
                <div class="card-body" style="text-align: center;">
                    <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}" style="width: 100%; border-radius: 0.5rem; object-fit: cover;" />
                </div>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <h2 class="card-title">اطلاعات سریع</h2>
            </div>
            <div class="card-body">
                <div style="display: grid; gap: 1rem;">
                    <div>
                        <p style="margin: 0 0 0.25rem 0; color: var(--text-muted); font-size: 0.875rem;">عضو از</p>
                        <p style="margin: 0; font-weight: 600;">{{ $member->join_date->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <p style="margin: 0 0 0.25rem 0; color: var(--text-muted); font-size: 0.875rem;">وضعیت فعلی</p>
                        <p style="margin: 0; font-weight: 600; color: {{ $member->expiry_date && $member->expiry_date->isFuture() ? 'var(--success)' : 'var(--danger)' }};">
                            {{ $member->expiry_date && $member->expiry_date->isFuture() ? 'فعال' : 'منقضی شده' }}
                        </p>
                    </div>
                    <div>
                        <p style="margin: 0 0 0.25rem 0; color: var(--text-muted); font-size: 0.875rem;">تاریخ انقضا</p>
                        <p style="margin: 0; font-weight: 600;">{{ $member->expiry_date?->format('M d, Y') ?? 'Not set' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </aside>
</div>
@endsection
