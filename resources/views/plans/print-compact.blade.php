@extends('layouts.print')

@section('title', 'چاپ فشرده - ' . $member->name)

@section('content')
<div class="print-container">
    <!-- Header -->
    <div class="print-header">
        <div class="gym-info">
            @if($gymInfo->logo_path)
                <img src="{{ $gymInfo->getLogoUrl() }}" alt="{{ $gymInfo->gym_name }}" class="gym-logo">
            @endif
            <div class="gym-details">
                <h1 class="gym-name">{{ $gymInfo->gym_name }}</h1>
                <p class="gym-address">{{ $gymInfo->address }}</p>
            </div>
        </div>
        <div class="document-title">
            <h1>خلاصه برنامه تناسب اندام شخصی</h1>
            <p class="print-date">تولید شده در {{ now()->format('M d, Y') }}</p>
        </div>
    </div>

    <!-- Member Summary -->
    <div class="member-summary">
        <h2>{{ $member->name }} - نمای کلی تناسب اندام</h2>
        <div class="summary-grid">
            <div class="summary-item">
                <span class="summary-label">سن:</span>
                <span class="summary-value">{{ $workoutPlan?->age ?? 'N/A' }} سال</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">وزن:</span>
                <span class="summary-value">{{ $workoutPlan?->weight ?? 'N/A' }} کیلوگرم</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">قد:</span>
                <span class="summary-value">{{ $workoutPlan?->height ?? 'N/A' }} سانتی‌متر</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">شاخص توده بدنی:</span>
                <span class="summary-value">{{ $bmi ?? 'N/A' }} ({{ $bmiCategory ?? 'N/A' }})</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">هدف:</span>
                <span class="summary-value">@php
                    $goalTranslations = [
                        'Fat Loss' => 'کاهش وزن',
                        'Muscle Gain' => 'افزایش عضله',
                        'General Fitness' => 'تناسب اندام عمومی',
                        'Strength Training' => 'تمرین قدرتی',
                        'Endurance' => 'تحمل',
                    ];
                    echo $goalTranslations[$workoutPlan?->goal] ?? $workoutPlan?->goal;
                @endphp</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">سطح:</span>
                <span class="summary-value">@php
                    $levelTranslations = [
                        'Beginner' => 'مبتدی',
                        'Intermediate' => 'متوسط',
                        'Advanced' => 'پیشرفته',
                    ];
                    echo $levelTranslations[$workoutPlan?->level] ?? $workoutPlan?->level;
                @endphp</span>
            </div>
        </div>
    </div>

    <!-- Workout Summary -->
    @if($workoutPlan && $formattedWorkout)
        <div class="plan-summary">
            <h2>💪 خلاصه تمرین هفتگی</h2>
            <div class="workout-summary">
                @foreach($formattedWorkout as $day => $details)
                    <div class="day-summary">
                        <h3>{{ $day }}</h3>
                        <p class="muscle-focus">{{ $details['muscle_group'] ?? 'N/A' }}</p>
                        <div class="exercise-list">
                            @foreach($details['exercises'] ?? [] as $exercise)
                                <div class="exercise-summary">
                                    <span class="exercise-name">{{ $exercise['name'] }}</span>
                                    <span class="exercise-specs">{{ $exercise['sets'] }} ست × {{ $exercise['reps'] }} تکرار</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Diet Summary -->
    @if($dietPlan && $formattedDiet)
        <div class="plan-summary">
            <h2>🍎 خلاصه تغذیه روزانه</h2>

            @if($dailyMacros)
                <div class="nutrition-overview">
                    <div class="macro-summary">
                        <span class="macro-total">{{ $dailyMacros['calories'] ?? 0 }} کالری</span>
                        <span class="macro-breakdown">
                            پروتئین: {{ $dailyMacros['protein'] ?? 0 }}گرم |
                            کربوهیدرات: {{ $dailyMacros['carbs'] ?? 0 }}گرم |
                            چربی: {{ $dailyMacros['fats'] ?? 0 }}گرم
                        </span>
                    </div>
                </div>
            @endif

            <div class="meal-summary">
                @php
                    $mealTranslations = [
                        'breakfast' => 'صبحانه',
                        'lunch' => 'ناهار',
                        'dinner' => 'شام',
                        'snack' => 'میان‌وعده',
                    ];
                @endphp
                @foreach($formattedDiet as $mealType => $meal)
                    <div class="meal-compact">
                        <h3>{{ $mealTranslations[$mealType] ?? ucfirst($mealType) }}: {{ $meal['name'] }}</h3>
                        <div class="meal-content">
                            <div class="meal-foods">
                                @foreach(array_slice($meal['foods'] ?? [], 0, 3) as $food)
                                    <span class="food-item">{{ $food }}</span>
                                @endforeach
                                @if(count($meal['foods'] ?? []) > 3)
                                    <span class="food-item">+{{ count($meal['foods']) - 3 }} بیشتر</span>
                                @endif
                            </div>
                            @if($meal['calories'])
                                <span class="meal-calories">{{ $meal['calories'] }} کالری</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Footer -->
    <div class="print-footer">
        <p>این خلاصه برنامه تناسب اندام شخصی شماست. برای دستورالعمل‌های详细، به برنامه کامل مراجعه کنید.</p>
        <p class="footer-note">تولید شده توسط {{ $gymInfo->gym_name }} در {{ now()->format('M d, Y \a\t h:i A') }}</p>
    </div>
</div>
@endsection