<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'fa' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <title>{{ __('messages.pdf_combined_plan') }} - {{ $member->name }}</title>
    <style>
        @page {
            size: A4;
            margin: 1.5cm 1.2cm;
        }

        html,
        body {
            margin: 0;
            padding: 0;
            font-family: 'DejaVu Sans', sans-serif;
            color: #1f1f1f;
            background: #ffffff;
            font-size: 12px;
            line-height: 1.45;
            direction: {{ app()->getLocale() === 'fa' ? 'rtl' : 'ltr' }};
            text-align: {{ app()->getLocale() === 'fa' ? 'right' : 'left' }};
        }

        body {
            min-height: 100%;
        }

        .page {
            page-break-after: always;
            width: auto;
            padding: 0;
            box-sizing: border-box;
        }

        .page-inner {
            width: 100%;
            max-width: 100%;
            margin: 0 auto;
            box-sizing: border-box;
        }

        .header-table,
        .info-table,
        .plan-table,
        .macro-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .header-table td {
            vertical-align: top;
            padding: 0;
        }

        .logo-cell {
            width: 72px;
            padding-left: 12px;
        }

        .logo {
            width: 72px;
            height: auto;
            display: block;
        }

        .gym-name {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 4px;
            color: #1a1a1a;
        }

        .gym-address {
            font-size: 10px;
            color: #666;
            line-height: 1.4;
        }

        .header-right {
            text-align: {{ app()->getLocale() === 'fa' ? 'right' : 'left' }};
        }

        .document-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 4px;
            color: #111;
        }

        .document-date {
            font-size: 11px;
            color: #666;
        }

        .section-title {
            font-size: 14px;
            font-weight: 700;
            color: #111;
            margin: 22px 0 10px;
            padding-bottom: 6px;
            border-bottom: 1px solid #d7d9dc;
            text-transform: uppercase;
            letter-spacing: 0.04em;
        }

        html[dir="rtl"] .section-title {
            text-transform: none;
            letter-spacing: normal;
        }

        .info-table td {
            padding: 10px 8px 8px 0;
            vertical-align: top;
        }

        .info-label {
            display: block;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #6c7280;
            margin-bottom: 4px;
        }

        .info-value {
            font-size: 12px;
            font-weight: 600;
            color: #20232a;
        }

        .box {
            background: #f9fafb;
            border: 1px solid #e3e5e8;
            border-radius: 4px;
            padding: 12px;
            margin-bottom: 18px;
        }

        .plan-table th,
        .plan-table td,
        .macro-table th,
        .macro-table td {
            border: 1px solid #d7d9dc;
            padding: 10px 10px;
            vertical-align: top;
            word-wrap: break-word;
            overflow-wrap: break-word;
            font-size: 11px;
        }

        .plan-table th,
        .macro-table th {
            background: #f1f3f5;
            color: #2b3037;
            font-weight: 700;
            text-align: {{ app()->getLocale() === 'fa' ? 'right' : 'left' }};
            letter-spacing: 0.03em;
        }

        .plan-table tbody tr:nth-child(odd) {
            background: #ffffff;
        }

        .plan-table tbody tr:nth-child(even) {
            background: #fbfcfd;
        }

        .exercise-list {
            margin: 0;
            padding-left: {{ app()->getLocale() === 'fa' ? '0' : '16px' }};
            padding-right: {{ app()->getLocale() === 'fa' ? '16px' : '0' }};
            list-style: disc;
            direction: {{ app()->getLocale() === 'fa' ? 'rtl' : 'ltr' }};
        }

        .exercise-list li {
            margin-bottom: 6px;
            font-size: 11px;
            color: #222;
        }

        .exercise-name {
            font-weight: 700;
            color: #1a1a1a;
        }

        .exercise-details {
            color: #575d65;
            font-size: 10px;
            display: block;
            margin-top: 2px;
        }

        .notes-box {
            background: #f4f5f6;
            border: 1px solid #dee1e4;
            border-radius: 4px;
            padding: 12px;
            font-size: 11px;
            color: #2b3037;
            line-height: 1.5;
            margin-bottom: 14px;
        }

        .notes-box strong {
            display: block;
            margin-bottom: 8px;
            color: #111;
            font-size: 11px;
        }

        .notes-box ul {
            margin: 0;
            padding-left: 18px;
        }

        .notes-box li {
            margin-bottom: 6px;
        }

        .footer {
            margin-top: 18px;
            padding-top: 12px;
            border-top: 1px solid #dde0e3;
            text-align: center;
            font-size: 10px;
            color: #667085;
        }

        .footer-note {
            font-weight: 700;
            color: #13131a;
            margin-bottom: 4px;
        }

        .footer-contact {
            font-size: 10px;
        }

        @media print {
            .page {
                page-break-after: always;
            }

            .plan-table tr,
            .macro-table tr,
            .info-table tr {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="page-inner">
            <table class="header-table">
                <tr>
                    <td class="logo-cell">
                        @if(isset($gymInfo) && $gymInfo->logo_path)
                            <img src="{{ $gymInfo->getLogoUrl() }}" alt="{{ $gymInfo->gym_name }}" class="logo">
                        @endif
                    </td>
                    <td>
                        <div class="gym-name">{{ $gymInfo->gym_name ?? 'Gym Management System' }}</div>
                        <div class="gym-address">{{ $gymInfo->address ?? 'Professional fitness planning and progress tracking at your gym.' }}</div>
                    </td>
                    <td class="header-right">
                        <div class="document-title">{{ __('messages.pdf_workout_plan') }}</div>
                        <div class="document-date">{{ now()->isoFormat('MMMM D, YYYY') }}</div>
                    </td>
                </tr>
            </table>

            <div class="section-title">{{ __('messages.membership_status_title') }}</div>
            <table class="info-table">
                <tr>
                    <td>
                        <span class="info-label">{{ __('messages.name') }}</span>
                        <span class="info-value">{{ $member->name }}</span>
                    </td>
                    <td>
                        <span class="info-label">{{ __('messages.pdf_age') }}</span>
                        <span class="info-value">{{ $workoutPlan->age ?? 'N/A' }} {{ __('messages.pdf_age_unit') }}</span>
                    </td>
                    <td>
                        <span class="info-label">{{ __('messages.pdf_weight') }}</span>
                        <span class="info-value">{{ $workoutPlan->weight ?? 'N/A' }} {{ __('messages.pdf_weight_unit') }}</span>
                    </td>
                    <td>
                        <span class="info-label">{{ __('messages.pdf_goal') }}</span>
                        <span class="info-value">@php
                            $goalTranslations = [
                                'Fat Loss' => __('messages.goal_fat_loss'),
                                'Muscle Gain' => __('messages.goal_muscle_gain'),
                                'General Fitness' => __('messages.goal_general_fitness'),
                                'Strength Training' => __('messages.goal_strength_training'),
                                'Endurance' => __('messages.goal_endurance'),
                            ];
                            echo $goalTranslations[$workoutPlan->goal] ?? $workoutPlan->goal;
                        @endphp</span>
                    </td>
                </tr>
            </table>

            <div class="section-title">{{ __('messages.pdf_workout_plan') }} (7-Day)</div>
            <div class="box">
                <table class="plan-table">
                    <thead>
                        <tr>
                            <th style="width: 16%;">{{ __('messages.pdf_day') }}</th>
                            <th style="width: 24%;">{{ __('messages.pdf_muscle_group') }}</th>
                            <th style="width: 60%;">{{ __('messages.pdf_exercises') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $workoutData = $workoutPlan->plan_data ?? [];
                            $planService = app('App\\Services\\PlanService');
                            $formatted = $planService->formatWorkoutPlanForDisplay($workoutData);
                        @endphp

                        @foreach ($formatted as $day => $details)
                            <tr>
                                <td><strong>{{ $day }}</strong></td>
                                <td>{{ $details['muscle_group'] ?? 'N/A' }}</td>
                                <td>
                                    <ul class="exercise-list">
                                        @foreach(array_slice($details['exercises'] ?? [], 0, 5) as $exercise)
                                            <li>
                                                <span class="exercise-name">{{ $exercise['name'] }}</span>
                                                <span class="exercise-details">{{ $exercise['sets'] ?? '0' }} {{ __('messages.pdf_sets') }} × {{ $exercise['reps'] ?? '0' }} {{ __('messages.pdf_reps') }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="notes-box">
                <strong>{{ __('messages.pdf_notes') }}</strong>
                <ul>
                    <li>Warm up before each workout and cool down after.</li>
                    <li>Focus on consistent progress and proper recovery.</li>
                    <li>Maintain proper form to reduce risk of injury.</li>
                    <li>Stay hydrated and keep your body properly nourished.</li>
                </ul>
            </div>

            <div class="footer">
                <div class="footer-note">Thank you for trusting us with your fitness journey.</div>
                @if(isset($gymInfo))
                    <div class="footer-contact">{{ $gymInfo->phone }} • {{ $gymInfo->email }}</div>
                @endif
            </div>
        </div>
    </div>

    @if($dietPlan)
        <div class="page">
            <div class="page-inner">
                <table class="header-table">
                    <tr>
                        <td class="logo-cell">
                            @if(isset($gymInfo) && $gymInfo->logo_path)
                                <img src="{{ $gymInfo->getLogoUrl() }}" alt="{{ $gymInfo->gym_name }}" class="logo">
                            @endif
                        </td>
                        <td>
                            <div class="gym-name">{{ $gymInfo->gym_name ?? 'Gym Management System' }}</div>
                            <div class="gym-address">{{ $gymInfo->address ?? 'Professional fitness planning and progress tracking at your gym.' }}</div>
                        </td>
                        <td class="header-right">
                            <div class="document-title">{{ __('messages.pdf_diet_plan') }}</div>
                            <div class="document-date">{{ now()->isoFormat('MMMM D, YYYY') }}</div>
                        </td>
                    </tr>
                </table>

                <div class="section-title">{{ __('messages.membership_status_title') }}</div>
                <table class="info-table">
                    <tr>
                        <td>
                            <span class="info-label">{{ __('messages.name') }}</span>
                            <span class="info-value">{{ $member->name }}</span>
                        </td>
                        <td>
                            <span class="info-label">{{ __('messages.pdf_goal') }}</span>
                            <span class="info-value">@php
                                $goalTranslations = [
                                    'Fat Loss' => __('messages.goal_fat_loss'),
                                    'Muscle Gain' => __('messages.goal_muscle_gain'),
                                    'General Fitness' => __('messages.goal_general_fitness'),
                                    'Strength Training' => __('messages.goal_strength_training'),
                                    'Endurance' => __('messages.goal_endurance'),
                                ];
                                echo $goalTranslations[$dietPlan->goal] ?? $dietPlan->goal;
                            @endphp</span>
                        </td>
                        <td>
                            <span class="info-label">{{ __('messages.pdf_level') }}</span>
                            <span class="info-value">@php
                                $levelTranslations = [
                                    'Beginner' => __('messages.level_beginner'),
                                    'Intermediate' => __('messages.level_intermediate'),
                                    'Advanced' => __('messages.level_advanced'),
                                ];
                                echo $levelTranslations[$dietPlan->level] ?? $dietPlan->level;
                            @endphp</span>
                        </td>
                        <td>
                            <span class="info-label">{{ __('messages.pdf_height') }} / {{ __('messages.pdf_weight') }}</span>
                            <span class="info-value">{{ $dietPlan->height ?? 'N/A' }} {{ __('messages.pdf_height_unit') }} / {{ $dietPlan->weight ?? 'N/A' }} {{ __('messages.pdf_weight_unit') }}</span>
                        </td>
                    </tr>
                </table>

                <div class="section-title">{{ __('messages.pdf_daily_nutrition') }}</div>
                @php
                    $dietData = $dietPlan->plan_data ?? [];
                    $formattedDiet = $planService->formatDietPlanForDisplay($dietData);
                    $dailyMacros = $planService->calculateDailyMacros($formattedDiet);
                @endphp

                <table class="macro-table" style="margin-bottom: 16px;">
                    <thead>
                        <tr>
                            <th style="text-align: center; width: 25%;">{{ __('messages.pdf_calories') }}</th>
                            <th style="text-align: center; width: 25%;">{{ __('messages.pdf_protein') }}</th>
                            <th style="text-align: center; width: 25%;">{{ __('messages.pdf_carbs') }}</th>
                            <th style="text-align: center; width: 25%;">{{ __('messages.pdf_fats') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="background: #fbfcfd;">
                            <td style="text-align: center; font-weight: 700;">{{ $dailyMacros['calories'] ?? 0 }}</td>
                            <td style="text-align: center; font-weight: 700;">{{ $dailyMacros['protein'] ?? 0 }} {{ __('messages.pdf_protein_unit') }}</td>
                            <td style="text-align: center; font-weight: 700;">{{ $dailyMacros['carbs'] ?? 0 }} {{ __('messages.pdf_carbs_unit') }}</td>
                            <td style="text-align: center; font-weight: 700;">{{ $dailyMacros['fats'] ?? 0 }} {{ __('messages.pdf_fats_unit') }}</td>
                        </tr>
                    </tbody>
                </table>

                <div class="section-title">{{ __('messages.pdf_meal_foods') }}</div>
                @foreach($formattedDiet as $mealType => $meal)
                    <div class="box" style="margin-bottom: 14px;">
                        <div style="font-size: 12px; font-weight: 700; color: #111; margin-bottom: 8px; text-transform: uppercase; letter-spacing: 0.04em;">
                            @php
                                $mealTranslations = [
                                    'breakfast' => __('messages.pdf_breakfast'),
                                    'lunch' => __('messages.pdf_lunch'),
                                    'dinner' => __('messages.pdf_dinner'),
                                    'snack' => __('messages.pdf_snack'),
                                ];
                            @endphp
                            {{ $mealTranslations[$mealType] ?? ucfirst($mealType) }}
                            @if(isset($meal['name']))
                                - {{ $meal['name'] }}
                            @endif
                        </div>

                        @if(isset($meal['foods']) && count($meal['foods']) > 0)
                            <div style="font-size: 11px; color: #2b3037; margin-bottom: 8px;">
                                <strong style="font-weight: 700; color: #111;">{{ __('messages.pdf_meal_foods') }}:</strong>
                                <ul style="margin: 8px 0 0 16px; padding: 0; list-style: disc; direction: ltr;">
                                    @foreach(array_slice($meal['foods'] ?? [], 0, 4) as $food)
                                        <li style="margin-bottom: 5px;">{{ $food }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(isset($meal['macros']))
                            <div style="font-size: 10px; color: #5d6975; line-height: 1.5;">
                                <span style="display: inline-block; min-width: 100px; margin-right: 14px;"><strong style="color: #111;">{{ __('messages.pdf_protein') }}:</strong> {{ $meal['macros']['protein'] ?? 0 }} {{ __('messages.pdf_protein_unit') }}</span>
                                <span style="display: inline-block; min-width: 100px; margin-right: 14px;"><strong style="color: #111;">{{ __('messages.pdf_carbs') }}:</strong> {{ $meal['macros']['carbs'] ?? 0 }} {{ __('messages.pdf_carbs_unit') }}</span>
                                <span style="display: inline-block; min-width: 80px;"><strong style="color: #111;">{{ __('messages.pdf_fats') }}:</strong> {{ $meal['macros']['fats'] ?? 0 }} {{ __('messages.pdf_fats_unit') }}</span>
                            </div>
                        @endif
                    </div>
                @endforeach

                <div class="notes-box">
                    <strong>{{ __('messages.pdf_notes') }}</strong>
                    <ul>
                        <li>Drink at least 8 glasses of water daily.</li>
                        <li>Choose lean proteins and whole food options.</li>
                        <li>Prepare meals in advance for consistency.</li>
                        <li>Adjust portion sizes based on your activity level.</li>
                    </ul>
                </div>

                <div class="footer">
                    <div class="footer-note">Eat smart, train hard, recover well.</div>
                    @if(isset($gymInfo))
                        <div class="footer-contact">{{ $gymInfo->phone }} • {{ $gymInfo->email }}</div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</body>
</html>
