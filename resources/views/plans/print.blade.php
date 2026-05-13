@extends('layouts.print')

@section('title', 'چاپ برنامه‌ها - ' . $member->name)

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
                <p class="gym-contact">{{ $gymInfo->phone }} | {{ $gymInfo->email }}</p>
            </div>
        </div>
        <div class="document-title">
            <h1>برنامه تناسب اندام شخصی‌سازی شده</h1>
            <p class="print-date">تولید شده در {{ now()->format('M d, Y') }}</p>
        </div>
    </div>

    <!-- Member Information -->
    <div class="member-info">
        <h2>اطلاعات عضو</h2>
        <div class="member-details">
            <div class="member-photo-section">
                @if($member->photo)
                    <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}" class="member-photo">
                @else
                    <div class="member-photo-placeholder">
                        {{ strtoupper(substr($member->name, 0, 1)) }}
                    </div>
                @endif
            </div>
            <div class="member-stats">
                <div class="stat-row">
                    <div class="stat-item">
                        <span class="stat-label">نام:</span>
                        <span class="stat-value">{{ $member->name }}</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">سن:</span>
                        <span class="stat-value">{{ $workoutPlan?->age ?? 'N/A' }} سال</span>
                    </div>
                </div>
                <div class="stat-row">
                    <div class="stat-item">
                        <span class="stat-label">وزن:</span>
                        <span class="stat-value">{{ $workoutPlan?->weight ?? 'N/A' }} کیلوگرم</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">قد:</span>
                        <span class="stat-value">{{ $workoutPlan?->height ?? 'N/A' }} سانتی‌متر</span>
                    </div>
                </div>
                <div class="stat-row">
                    <div class="stat-item">
                        <span class="stat-label">شاخص توده بدنی:</span>
                        <span class="stat-value">{{ $bmi ?? 'N/A' }} ({{ $bmiCategory ?? 'N/A' }})</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">هدف:</span>
                        <span class="stat-value">@php
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
                </div>
                <div class="stat-row">
                    <div class="stat-item">
                        <span class="stat-label">سطح تناسب اندام:</span>
                        <span class="stat-value">@php
                            $levelTranslations = [
                                'Beginner' => 'مبتدی',
                                'Intermediate' => 'متوسط',
                                'Advanced' => 'پیشرفته',
                            ];
                            echo $levelTranslations[$workoutPlan?->level] ?? $workoutPlan?->level;
                        @endphp</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">عضویت از:</span>
                        <span class="stat-value">{{ $member->join_date->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Workout Plan -->
    @if($workoutPlan && $formattedWorkout)
        <div class="plan-section">
            <h2>برنامه تمرینی</h2>
            <div class="workout-grid">
                @foreach($formattedWorkout as $day => $details)
                    <div class="workout-day">
                        <h3>{{ $day }}</h3>
                        <div class="muscle-group">
                            <strong>گروه‌های عضلانی:</strong> {{ $details['muscle_group'] ?? 'N/A' }}
                        </div>
                        <div class="exercises">
                            @foreach($details['exercises'] ?? [] as $exercise)
                                <div class="exercise">
                                    <div class="exercise-name">{{ $exercise['name'] }}</div>
                                    <div class="exercise-details">
                                        <span><strong>ست‌ها:</strong> {{ $exercise['sets'] }}</span>
                                        <span><strong>تکرارها:</strong> {{ $exercise['reps'] }}</span>
                                    </div>
                                    @if($exercise['notes'])
                                        <div class="exercise-notes">{{ $exercise['notes'] }}</div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Diet Plan -->
    @if($dietPlan && $formattedDiet)
        <div class="plan-section page-break">
            <h2>برنامه تغذیه</h2>

            @if($dailyMacros)
                <div class="daily-macros">
                    <h3>خلاصه تغذیه روزانه</h3>
                    <div class="macros-grid">
                        <div class="macro-item">
                            <span class="macro-label">کل کالری:</span>
                            <span class="macro-value">{{ $dailyMacros['calories'] ?? 0 }}</span>
                        </div>
                        <div class="macro-item">
                            <span class="macro-label">پروتئین:</span>
                            <span class="macro-value">{{ $dailyMacros['protein'] ?? 0 }}گرم</span>
                        </div>
                        <div class="macro-item">
                            <span class="macro-label">کربوهیدرات:</span>
                            <span class="macro-value">{{ $dailyMacros['carbs'] ?? 0 }}گرم</span>
                        </div>
                        <div class="macro-item">
                            <span class="macro-label">چربی:</span>
                            <span class="macro-value">{{ $dailyMacros['fats'] ?? 0 }}گرم</span>
                        </div>
                    </div>
                </div>
            @endif

            <div class="meals">
                @php
                    $mealTranslations = [
                        'breakfast' => 'صبحانه',
                        'lunch' => 'ناهار',
                        'dinner' => 'شام',
                        'snack' => 'میان‌وعده',
                    ];
                @endphp
                @foreach($formattedDiet as $mealType => $meal)
                    <div class="meal">
                        <h3>{{ $mealTranslations[$mealType] ?? ucfirst($mealType) }}: {{ $meal['name'] }}</h3>
                        @if($meal['calories'])
                            <p class="meal-calories">{{ $meal['calories'] }} کالری</p>
                        @endif

                        <div class="meal-foods">
                            <strong>مواد غذایی:</strong>
                            <ul>
                                @foreach($meal['foods'] ?? [] as $food)
                                    <li>{{ $food }}</li>
                                @endforeach
                            </ul>
                        </div>

                        @if($meal['macros'])
                            <div class="meal-macros">
                                <div class="macro-breakdown">
                                    <span>پروتئین: {{ $meal['macros']['protein'] ?? 0 }}گرم</span>
                                    <span>کربوهیدرات: {{ $meal['macros']['carbs'] ?? 0 }}گرم</span>
                                    <span>چربی: {{ $meal['macros']['fats'] ?? 0 }}گرم</span>
                                </div>
                            </div>
                        @endif

                        @if($meal['notes'])
                            <div class="meal-notes">{{ $meal['notes'] }}</div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Footer -->
    <div class="print-footer">
        <p>این برنامه برای {{ $member->name }} شخصی‌سازی شده است. قبل از شروع هر برنامه تمرینی یا تغذیۀ جدید با متخصص سلامت مشورت کنید.</p>
        <p class="footer-note">تولید شده توسط {{ $gymInfo->gym_name }} در {{ now()->format('M d, Y \a\t h:i A') }}</p>
    </div>
</div>
@endsection