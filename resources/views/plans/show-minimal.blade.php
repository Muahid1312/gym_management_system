@extends('layouts.app')

@section('title', 'برنامه‌های تمرینی و تغذیه')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">برنامه‌های تناسب اندام</h1>
        <p class="page-subtitle">برنامه‌های تمرینی و تغذیه شخصی‌سازی شده برای {{ $member->name }}</p>
    </div>
    <div class="flex gap-2">
        @if ($workoutPlan || $dietPlan)
            <a href="{{ route('ai.download-pdf', $member) }}" class="btn" target="_blank">
                <svg class="icon" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
                دانلود PDF
            </a>
            <a href="{{ route('ai.print-plans', $member) }}" class="btn-outline" target="_blank">
                <svg class="icon" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v3a2 2 0 002 2h1v2a2 2 0 002 2h6a2 2 0 002-2v-2h1a2 2 0 002-2V9a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm8 0H7v3h6V4zm0 8H7v4h6v-4z" clip-rule="evenodd"/>
                </svg>
                چاپ برنامه کامل
            </a>
            <a href="{{ route('ai.print-plans-compact', $member) }}" class="btn-outline" target="_blank">
                <svg class="icon" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                </svg>
                چاپ خلاصه
            </a>
        @endif
        <a href="{{ route('ai.generate', $member) }}" class="btn-outline">
            <svg class="icon" fill="currentColor" viewBox="0 0 20 20">
                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
            </svg>
            ویرایش برنامه‌ها
        </a>
        <a href="{{ route('members.show', $member) }}" class="btn-outline">← بازگشت</a>
    </div>
</div>

@if (session('success'))
    <div class="status-badge status-success" style="margin-bottom: 16px; display: block; padding: 12px;">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="status-badge status-error" style="margin-bottom: 16px; display: block; padding: 12px;">
        {{ session('error') }}
    </div>
@endif

<!-- Member Stats -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
    <div class="card">
        <div class="card-body">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-muted">سن</p>
                    <p style="font-size: 24px; font-weight: 700; margin: 4px 0;">{{ $workoutPlan?->age ?? 'N/A' }}</p>
                </div>
                <div style="width: 40px; height: 40px; background: var(--accent-soft); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20" style="color: var(--accent);">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-muted">وزن</p>
                    <p style="font-size: 24px; font-weight: 700; margin: 4px 0;">{{ $workoutPlan?->weight ?? 'N/A' }} <span style="font-size: 14px; font-weight: 500;">کیلوگرم</span></p>
                </div>
                <div style="width: 40px; height: 40px; background: var(--warning-soft); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20" style="color: var(--warning);">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-muted">قد</p>
                    <p style="font-size: 24px; font-weight: 700; margin: 4px 0;">{{ $workoutPlan?->height ?? 'N/A' }} <span style="font-size: 14px; font-weight: 500;">سانتی‌متر</span></p>
                </div>
                <div style="width: 40px; height: 40px; background: var(--success-soft); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20" style="color: var(--success);">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z" clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-muted">شاخص توده بدنی</p>
                    <p style="font-size: 24px; font-weight: 700; margin: 4px 0;">{{ $bmi ?? 'N/A' }}</p>
                    <p style="font-size: 12px; color: var(--text-muted); margin: 0;">{{ $bmiCategory ?? 'N/A' }}</p>
                </div>
                <div style="width: 40px; height: 40px; background: var(--accent-soft); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20" style="color: var(--accent);">
                        <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>

@php
    $goalTranslations = [
        'Fat Loss' => 'کاهش وزن',
        'Muscle Gain' => 'افزایش عضله',
        'General Fitness' => 'تناسب اندام عمومی',
        'Strength Training' => 'تمرین قدرتی',
        'Endurance' => 'تحمل',
    ];
    $levelTranslations = [
        'Beginner' => 'مبتدی',
        'Intermediate' => 'متوسط',
        'Advanced' => 'پیشرفته',
    ];
    $mealTranslations = [
        'breakfast' => 'صبحانه',
        'lunch' => 'ناهار',
        'dinner' => 'شام',
        'snack' => 'میان‌وعده',
    ];
@endphp

<!-- Workout Plan Section -->
@if ($workoutPlan && $formattedWorkout)
<div class="card" style="margin-bottom: 24px;">
    <div class="card-header">
        <div class="flex items-center justify-between">
            <span>💪 برنامه تمرینی</span>
            <div class="flex gap-2">
                <span class="status-badge status-info">{{ $goalTranslations[$workoutPlan->goal] ?? $workoutPlan->goal }}</span>
                <span class="status-badge status-warning">{{ $levelTranslations[$workoutPlan->level] ?? $workoutPlan->level }}</span>
            </div>
        </div>
    </div>
    <div class="card-body">
        @foreach ($formattedWorkout as $day => $exercises)
            <div style="margin-bottom: 24px;">
                <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 12px; color: var(--text);">{{ $day }}</h3>
                <div style="display: grid; gap: 12px;">
                    @foreach ($exercises as $exercise)
                        <div style="border: 1px solid var(--border); border-radius: 6px; padding: 12px;">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p style="margin: 0; font-weight: 600; color: var(--text);">{{ $exercise['name'] }}</p>
                                    <p style="margin: 4px 0 0 0; font-size: 14px; color: var(--text-muted);">{{ $exercise['sets'] }} ست × {{ $exercise['reps'] }} تکرار</p>
                                </div>
                                @if (isset($exercise['notes']) && $exercise['notes'])
                                    <span class="status-badge status-info" style="font-size: 12px;">{{ $exercise['notes'] }}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div style="margin-top: 16px; padding-top: 16px; border-top: 1px solid var(--border);">
            <form action="{{ route('plans.workout.delete', $workoutPlan) }}" method="POST" onsubmit="return confirm('آیا این برنامه تمرینی حذف شود؟');" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger" style="font-size: 14px; padding: 6px 12px;">حذف برنامه تمرینی</button>
            </form>
        </div>
    </div>
</div>
@else
<div class="card" style="margin-bottom: 24px;">
    <div class="card-body" style="text-align: center; padding: 48px;">
        <svg width="48" height="48" fill="currentColor" viewBox="0 0 20 20" style="color: var(--text-muted); margin: 0 auto 16px;">
            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
        </svg>
        <h3 style="margin: 0 0 8px 0; color: var(--text);">هنوز برنامه تمرینی وجود ندارد</h3>
        <p style="margin: 0 0 24px 0; color: var(--text-muted);">هیچ برنامه تمرینی هنوز تولید نشده است.</p>
        <a href="{{ route('ai.generate', $member) }}" class="btn">تولید برنامه تمرینی</a>
    </div>
</div>
@endif

<!-- Diet Plan Section -->
@if ($dietPlan && $formattedDiet)
<div class="card" style="margin-bottom: 24px;">
    <div class="card-header">
        <div class="flex items-center justify-between">
            <span>🍎 برنامه تغذیه</span>
            <div class="flex gap-2">
                <span class="status-badge status-success">{{ $goalTranslations[$dietPlan->goal] ?? $dietPlan->goal }}</span>
                <span class="status-badge status-warning">{{ $levelTranslations[$dietPlan->level] ?? $dietPlan->level }}</span>
            </div>
        </div>
    </div>
    <div class="card-body">
        <!-- Daily Macros Summary -->
        @if (!empty($dailyMacros))
        <div style="margin-bottom: 24px; padding: 16px; background: var(--surface-soft); border-radius: 6px;">
            <h4 style="margin: 0 0 12px 0; font-size: 16px; font-weight: 600; color: var(--text);">هدف‌های تغذیه روزانه</h4>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); gap: 12px;">
                @foreach ($dailyMacros as $macro => $value)
                    @php
                        $macroLabels = [
                            'calories' => 'کالری',
                            'protein' => 'پروتئین',
                            'carbs' => 'کربوهیدرات',
                            'fats' => 'چربی',
                        ];
                    @endphp
                    <div style="text-align: center;">
                        <p style="margin: 0; font-size: 18px; font-weight: 700; color: var(--accent);">{{ $value }}{{ in_array($macro, ['protein','carbs','fats']) ? ' گرم' : '' }}</p>
                        <p style="margin: 2px 0 0 0; font-size: 12px; color: var(--text-muted); text-transform: uppercase;">{{ $macroLabels[$macro] ?? $macro }}</p>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        @foreach ($formattedDiet as $meal => $foods)
            <div style="margin-bottom: 24px;">
                <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 12px; color: var(--text);">{{ $mealTranslations[$meal] ?? ucfirst($meal) }}</h3>
                <div style="display: grid; gap: 8px;">
                    @foreach ($foods as $food)
                        <div style="border: 1px solid var(--border); border-radius: 6px; padding: 12px;">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p style="margin: 0; font-weight: 500; color: var(--text);">{{ $food['name'] }}</p>
                                    @if (isset($food['portion']) && $food['portion'])
                                        <p style="margin: 2px 0 0 0; font-size: 14px; color: var(--text-muted);">{{ $food['portion'] }}</p>
                                    @endif
                                </div>
                                @if (isset($food['calories']) && $food['calories'])
                                    <span class="status-badge status-info" style="font-size: 12px;">{{ $food['calories'] }} کالری</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div style="margin-top: 16px; padding-top: 16px; border-top: 1px solid var(--border);">
            <form action="{{ route('plans.diet.delete', $dietPlan) }}" method="POST" onsubmit="return confirm('آیا این برنامه تغذیه حذف شود؟');" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger" style="font-size: 14px; padding: 6px 12px;">حذف برنامه تغذیه</button>
            </form>
        </div>
    </div>
</div>
@else
<div class="card">
    <div class="card-body" style="text-align: center; padding: 48px;">
        <svg width="48" height="48" fill="currentColor" viewBox="0 0 20 20" style="color: var(--text-muted); margin: 0 auto 16px;">
            <path d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293 4.293a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"/>
        </svg>
        <h3 style="margin: 0 0 8px 0; color: var(--text);">هنوز برنامه تغذیه وجود ندارد</h3>
        <p style="margin: 0 0 24px 0; color: var(--text-muted);">هیچ برنامه تغذیه هنوز تولید نشده است.</p>
        <a href="{{ route('ai.generate', $member) }}" class="btn">تولید برنامه تغذیه</a>
    </div>
</div>
@endif
@endsection