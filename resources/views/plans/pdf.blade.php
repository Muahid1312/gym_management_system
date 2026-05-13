<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8" />
    <title>برنامه تناسب اندام - {{ $member->name }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            color: #333;
            line-height: 1.6;
            background: white;
            direction: rtl;
            text-align: right;
            font-size: 14px;
        }

        .page {
            page-break-after: always;
            padding: 40px;
            background: white;
            min-height: 100vh;
        }

        .header {
            text-align: right;
            margin-bottom: 40px;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 20px;
        }

        .header h1 {
            color: #1e3a8a;
            font-size: 32px;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .header p {
            color: #666;
            font-size: 14px;
        }

        .member-info {
            background: #f3f4f6;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            width: 100%;
            border-collapse: collapse;
        }

        .member-info td {
            padding: 10px;
            text-align: center;
            border: none;
        }

        .section-title {
            color: #1e3a8a;
            font-size: 24px;
            font-weight: bold;
            margin-top: 30px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #2563eb;
            text-align: right;
        }

        .subsection-title {
            color: #2563eb;
            font-size: 16px;
            font-weight: 600;
            margin-top: 15px;
            margin-bottom: 10px;
            text-align: right;
        }

        .day-plan {
            background: #f9fafb;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 6px;
            border-right: 4px solid #2563eb;
        }

        .day-title {
            color: #1e3a8a;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 8px;
            text-align: right;
        }

        .muscle-group {
            color: #666;
            font-size: 12px;
            margin-bottom: 10px;
            font-style: italic;
            text-align: right;
        }

        .exercise {
            background: white;
            padding: 10px;
            margin-bottom: 8px;
            border-radius: 4px;
            text-align: right;
        }

        .exercise-name {
            color: #1e3a8a;
            font-weight: 600;
            text-align: right;
        }

        .exercise-details {
            color: #666;
            font-size: 11px;
            margin-top: 3px;
            text-align: right;
        }

        .meal-plan {
            background: #f9fafb;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 6px;
            border-right: 4px solid #16a34a;
            text-align: right;
        }

        .meal-title {
            color: #166534;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 8px;
            text-align: right;
        }

        .meal-name {
            color: #1e3a8a;
            font-weight: 600;
            margin-bottom: 5px;
            text-align: right;
        }

        .meal-foods {
            color: #666;
            font-size: 11px;
            margin-bottom: 8px;
            text-align: right;
        }

        .macros {
            background: white;
            padding: 10px;
            border-radius: 4px;
            font-size: 11px;
            width: 100%;
            border-collapse: collapse;
        }

        .macros td {
            padding: 5px;
            text-align: center;
        }

        .notes {
            color: #666;
            font-size: 11px;
            font-style: italic;
            margin-top: 5px;
            padding-top: 5px;
            border-top: 1px solid #e5e7eb;
            text-align: right;
        }

        .daily-macros {
            background: #f3f4f6;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            width: 100%;
            border-collapse: collapse;
        }

        .daily-macros td {
            padding: 15px;
            text-align: center;
            background: white;
            border-radius: 6px;
            margin: 5px;
        }

        .daily-macro-box label {
            display: block;
            color: #666;
            font-size: 12px;
            margin-bottom: 5px;
        }

        .daily-macro-box value {
            display: block;
            color: #1e3a8a;
            font-size: 20px;
            font-weight: bold;
        }

        .two-column {
            column-count: 2;
            column-gap: 30px;
            direction: rtl;
        }

        .two-column .day-plan {
            break-inside: avoid;
            margin-bottom: 20px;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            .page {
                page-break-after: always;
                margin: 0;
                padding: 40px;
                min-height: 100vh;
            }
        }
    </style>
</head>
        }

        .day-title {
            color: #1e3a8a;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .muscle-group {
            color: #666;
            font-size: 12px;
            margin-bottom: 10px;
            font-style: italic;
        }

        .exercise {
            background: white;
            padding: 10px;
            margin-bottom: 8px;
            border-radius: 4px;
            font-size: 12px;
        }

        .exercise-name {
            color: #1e3a8a;
            font-weight: 600;
        }

        .exercise-details {
            color: #666;
            font-size: 11px;
            margin-top: 3px;
        }

        .meal-plan {
            background: #f9fafb;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 6px;
            border-right: 4px solid #16a34a;
            text-align: right;
        }

        .meal-title {
            color: #166534;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .meal-name {
            color: #1e3a8a;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .meal-foods {
            color: #666;
            font-size: 11px;
            margin-bottom: 8px;
        }

        .macros {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
            gap: 10px;
            background: white;
            padding: 10px;
            border-radius: 4px;
            font-size: 11px;
            justify-content: space-between;
        }

        .macro-item {
            flex: 1;
            min-width: 80px;
            text-align: center;
        }

        .macro-label {
            color: #666;
            font-size: 10px;
            display: block;
            margin-bottom: 3px;
        }

        .macro-value {
            color: #1e3a8a;
            font-weight: bold;
            font-size: 12px;
        }

        .notes {
            color: #666;
            font-size: 11px;
            font-style: italic;
            margin-top: 5px;
            padding-top: 5px;
            border-top: 1px solid #e5e7eb;
        }

        .daily-macro-box label {
            display: block;
            color: #666;
            font-size: 12px;
            margin-bottom: 5px;
        }

        .daily-macro-box value {
            display: block;
            color: #1e3a8a;
            font-size: 20px;
            font-weight: bold;
        }

        .two-column {
            column-count: 2;
            column-gap: 30px;
            direction: rtl;
        }

        .two-column .day-plan {
            break-inside: avoid;
            margin-bottom: 20px;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }
            .page {
                page-break-after: always;
                margin: 0;
                padding: 40px;
                min-height: 100vh;
            }
        }
    </style>
</head>
<body>
    <!-- Workout Plan Page -->
    <div class="page">
        <div class="header">
            <h1>🏋️ برنامه تمرینی</h1>
            <p>برنامه تمرینی شخصی‌سازی شده برای {{ $member->name }}</p>
        </div>

        <table class="member-info">
            <tr>
                <td>
                    <label>نام</label>
                    <value>{{ $member->name }}</value>
                </td>
                <td>
                    <label>هدف</label>
                    <value>@php
                        $goalTranslations = [
                            'Fat Loss' => 'کاهش وزن',
                            'Muscle Gain' => 'افزایش عضله',
                            'General Fitness' => 'تناسب اندام عمومی',
                            'Strength Training' => 'تمرین قدرتی',
                            'Endurance' => 'تحمل',
                        ];
                        echo $goalTranslations[$workoutPlan->goal] ?? $workoutPlan->goal;
                    @endphp</value>
                </td>
                <td>
                    <label>سطح</label>
                    <value>@php
                        $levelTranslations = [
                            'Beginner' => 'مبتدی',
                            'Intermediate' => 'متوسط',
                            'Advanced' => 'پیشرفته',
                        ];
                        echo $levelTranslations[$workoutPlan->level] ?? $workoutPlan->level;
                    @endphp</value>
                </td>
                <td>
                    <label>سن</label>
                    <value>{{ $workoutPlan->age }}</value>
                </td>
            </tr>
        </table>

        <div class="subsection-title">📅 برنامه تمرینی ۷ روزه</div>

        <div class="two-column">
            @php
                $workoutData = $workoutPlan->plan_data ?? [];
                $planService = app('App\Services\PlanService');
                $formatted = $planService->formatWorkoutPlanForDisplay($workoutData);
            @endphp

            @foreach ($formatted as $day => $details)
                <div class="day-plan">
                    <div class="day-title">{{ $day }}</div>
                    <div class="muscle-group">گروه‌های عضلانی: {{ $details['muscle_group'] ?? 'N/A' }}</div>

                    @foreach ($details['exercises'] ?? [] as $exercise)
                        <div class="exercise">
                            <div class="exercise-name">{{ $exercise['name'] }}</div>
                            <div class="exercise-details">
                                ست‌ها: {{ $exercise['sets'] }} | تکرارها: {{ $exercise['reps'] }}
                                @if ($exercise['notes'])
                                    <div class="notes">{{ $exercise['notes'] }}</div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

        <p style="text-align: right; color: #999; font-size: 10px; margin-top: 30px;">
            این برنامه بر اساس سن ({{ $workoutPlan->age }} سال)، وزن ({{ $workoutPlan->weight }} کیلوگرم) و قد ({{ $workoutPlan->height }} سانتی‌متر) شما تنظیم شده است.
        </p>
    </div>

    <!-- Diet Plan Page -->
    <div class="page">
        <div class="header">
            <h1>🍎 برنامه تغذیه</h1>
            <p>برنامه تغذیه شخصی‌سازی شده برای {{ $member->name }}</p>
        </div>

        <table class="member-info">
            <tr>
                <td>
                    <label>نام</label>
                    <value>{{ $member->name }}</value>
                </td>
                <td>
                    <label>هدف</label>
                    <value>@php
                        $goalTranslations = [
                            'Fat Loss' => 'کاهش وزن',
                            'Muscle Gain' => 'افزایش عضله',
                            'General Fitness' => 'تناسب اندام عمومی',
                            'Strength Training' => 'تمرین قدرتی',
                            'Endurance' => 'تحمل',
                        ];
                        echo $goalTranslations[$dietPlan->goal] ?? $dietPlan->goal;
                    @endphp</value>
                </td>
                <td>
                    <label>سطح</label>
                    <value>@php
                        $levelTranslations = [
                            'Beginner' => 'مبتدی',
                            'Intermediate' => 'متوسط',
                            'Advanced' => 'پیشرفته',
                        ];
                        echo $levelTranslations[$dietPlan->level] ?? $dietPlan->level;
                    @endphp</value>
                </td>
                <td>
                    <label>قد / وزن</label>
                    <value>{{ $dietPlan->height }} سانتی‌متر / {{ $dietPlan->weight }} کیلوگرم</value>
                </td>
            </tr>
        </table>

        @php
            $dietData = $dietPlan->plan_data ?? [];
            $formatted = $planService->formatDietPlanForDisplay($dietData);
            $dailyMacros = $planService->calculateDailyMacros($formatted);
        @endphp

        <table class="daily-macros">
            <tr>
                <td>
                    <label>کل کالری</label>
                    <value>{{ $dailyMacros['calories'] ?? 0 }}</value>
                </td>
                <td>
                    <label>پروتئین</label>
                    <value>{{ $dailyMacros['protein'] ?? 0 }} گرم</value>
                </td>
                <td>
                    <label>کربوهیدرات</label>
                    <value>{{ $dailyMacros['carbs'] ?? 0 }} گرم</value>
                </td>
                <td>
                    <label>چربی</label>
                    <value>{{ $dailyMacros['fats'] ?? 0 }} گرم</value>
                </td>
            </tr>
        </table>

        <div class="subsection-title">🥗 برنامه غذایی روزانه</div>

        @foreach ($formatted as $mealType => $meal)
            <div class="meal-plan">
                <div class="meal-title">@php
                    $mealTranslations = [
                        'breakfast' => 'صبحانه',
                        'lunch' => 'ناهار',
                        'dinner' => 'شام',
                        'snack' => 'میان‌وعده',
                    ];
                @endphp
                {{ $mealTranslations[$mealType] ?? ucfirst($mealType) }} - {{ $meal['name'] }}</div>

                <div class="meal-foods">
                    <strong>مواد غذایی:</strong><br>
                    @foreach ($meal['foods'] ?? [] as $food)
                        • {{ $food }}<br>
                    @endforeach
                </div>

                @if ($meal['macros'] || $meal['calories'])
                    <table class="macros">
                        <tr>
                            <td>
                                <span class="macro-label">کالری</span>
                                <span class="macro-value">{{ $meal['calories'] ?? 0 }}</span>
                            </td>
                            <td>
                                <span class="macro-label">پروتئین</span>
                                <span class="macro-value">{{ $meal['macros']['protein'] ?? 0 }} گرم</span>
                            </td>
                            <td>
                                <span class="macro-label">کربوهیدرات</span>
                                <span class="macro-value">{{ $meal['macros']['carbs'] ?? 0 }} گرم</span>
                            </td>
                            <td>
                                <span class="macro-label">چربی</span>
                                <span class="macro-value">{{ $meal['macros']['fats'] ?? 0 }} گرم</span>
                            </td>
                        </tr>
                    </table>
                @endif

                @if ($meal['notes'])
                    <div class="notes"><strong>💡 نکته:</strong> {{ $meal['notes'] }}</div>
                @endif
            </div>
        @endforeach

        <p style="text-align: right; color: #999; font-size: 10px; margin-top: 30px;">
            این برنامه بر اساس سن ({{ $dietPlan->age }} سال)، وزن ({{ $dietPlan->weight }} کیلوگرم) و قد ({{ $dietPlan->height }} سانتی‌متر) شما تنظیم شده است.
        </p>
    </div>
</body>
</html>
