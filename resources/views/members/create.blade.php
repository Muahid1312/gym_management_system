@extends('layouts.app')

@section('title', 'Add Member')

@section('content')
<div class="page-header">
    <h1 class="page-title">عضو جدید</h1>
    <p class="page-subtitle">ثبت عضو جدید </p>
</div>

<div class="button-group" style="margin-bottom: 2rem;">
    <a href="{{ route('members.index') }}" class="button button-outline">← بازگشت به صفحه اعضا</a>
</div>

<div class="card">
    <div class="card-header">
        <h2 class="card-title">معلومات  فرد</h2>
    </div>
    <div class="card-body">
        <form id="offlineMemberForm" action="{{ route('members.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div id="offlineFormHint" class="alert alert-warning hidden" style="margin-bottom: 1rem;">
                <strong>Offline-ready:</strong> زمان که به انترنت وصل شدید پروسه به طور خودکار ذخیره میشود.
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
                <div>
                    <label for="name" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">اسم</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" required style="width: 100%; padding: 0.5rem; border: 1px solid var(--border); border-radius: 4px;" placeholder="احمد " />
                    @error('name')
                        <p style="color: var(--danger); font-size: 0.875rem; margin: 0.25rem 0 0 0;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">نام پدر</label>
                    <input id="email" name="email" type="text" value="{{ old('email') }}" required style="width: 100%; padding: 0.5rem; border: 1px solid var(--border); border-radius: 4px;" placeholder="اسم پدر" />
                    @error('email')
                        <p style="color: var(--danger); font-size: 0.875rem; margin: 0.25rem 0 0 0;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="phone" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">شماره تماس</label>
                    <input id="phone" name="phone" type="tel" value="{{ old('phone') }}" required style="width: 100%; padding: 0.5rem; border: 1px solid var(--border); border-radius: 4px;" placeholder="+93 123 456 789" />
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
                        <option value="">انتخاب پلان</option>
                        @foreach($plans as $plan)
                            <option value="{{ $plan->id }}" {{ old('plan_id') == $plan->id ? 'selected' : '' }}>{{ $plan->name }} ({{ $plan->duration_days }} days) - AF {{ number_format($plan->price, 2) }}</option>
                        @endforeach
                    </select>
                    @error('plan_id')
                        <p style="color: var(--danger); font-size: 0.875rem; margin: 0.25rem 0 0 0;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="join_date" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">زمان عضویت</label>
                    <input id="join_date" name="join_date" type="date" value="{{ old('join_date', now()->toDateString()) }}" required style="width: 100%; padding: 0.5rem; border: 1px solid var(--border); border-radius: 4px;" />
                    @error('join_date')
                        <p style="color: var(--danger); font-size: 0.875rem; margin: 0.25rem 0 0 0;">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="workout_level" style="display: block; margin-bottom: 0.5rem; font-weight: 600;">سطح تمرین</label>
                    <select id="workout_level" name="workout_level" required style="width: 100%; padding: 0.5rem; border: 1px solid var(--border); border-radius: 4px;">
                        <option value="">انتخاب سطح</option>
                        @foreach($levels as $level)
                            <option value="{{ $level }}" {{ old('workout_level') == $level ? 'selected' : '' }}>{{ ucfirst($level) }}</option>
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
                            <option value="{{ $level }}" {{ old('diet_level') == $level ? 'selected' : '' }}>{{ ucfirst($level) }}</option>
                        @endforeach
                    </select>
                    @error('diet_level')
                        <p style="color: var(--danger); font-size: 0.875rem; margin: 0.25rem 0 0 0;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border); display: flex; gap: 1rem;">
                <a href="{{ route('members.index') }}" class="button button-outline" style="flex: 1;">لغو</a>
                <button type="submit" class="button" style="flex: 1;">ثبت عضو</button>
            </div>
        </form>
    </div>
</div>
@endsection
