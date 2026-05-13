<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="utf-8" />
    <title>پلان فیتنس</title>
    @php
        include_once app_path('Support/persian_pdf_helpers.php');
    @endphp
    <style>
        @page {
            size: A4;
            margin: 20px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html,
        body {
            font-family: 'Vazir', serif !important;
            font-size: 11px;
            line-height: 1.6;
            color: #1a1a1a;
            background: white;
            direction: rtl;
            text-align: right;
        }

        .container {
            width: 100%;
            padding: 0;
            margin: 0;
        }

        /* ===== HEADER SECTION ===== */
        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #2c3e50;
        }

        .gym-logo-section {
            margin-bottom: 12px;
        }

        .gym-logo {
            max-width: 40px;
            height: auto;
            margin-bottom: 8px;
        }

        .gym-name {
            font-size: 18px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 4px;
        }

        .header-subtitle {
            font-size: 10px;
            color: #7f8c8d;
            margin-bottom: 8px;
        }

        .header-date {
            font-size: 9px;
            color: #7f8c8d;
        }

        /* ===== MEMBER INFO SECTION ===== */
        .member-section {
            margin-bottom: 18px;
            padding: 10px;
            background-color: #ecf0f1;
            border-radius: 4px;
        }

        .section-title {
            font-size: 12px;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 10px;
            border-bottom: 1px solid #bdc3c7;
            padding-bottom: 6px;
        }

        .member-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .member-item {
            padding: 0;
        }

        .member-label {
            font-size: 9px;
            font-weight: bold;
            color: #34495e;
            margin-bottom: 3px;
        }

        .member-value {
            font-size: 10px;
            color: #2c3e50;
        }

        /* ===== WORKOUT TABLE ===== */
        .workout-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
            font-size: 9px;
        }

        .workout-table thead {
            background-color: #34495e;
            color: white;
        }

        .workout-table th {
            padding: 10px;
            text-align: right;
            font-weight: bold;
            border: 1px solid #bdc3c7;
        }

        .workout-table td {
            padding: 10px;
            border: 1px solid #bdc3c7;
            text-align: right;
            vertical-align: top;
        }

        .workout-table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        .day-cell {
            font-weight: bold;
            width: 15%;
            color: #2c3e50;
        }

        .muscle-cell {
            font-weight: bold;
            width: 22%;
            color: #27ae60;
        }

        .exercises-cell {
            width: 63%;
        }

        .exercise-item {
            margin-bottom: 6px;
            line-height: 1.4;
        }

        .exercise-name {
            font-weight: bold;
            color: #1a1a1a;
        }

        .exercise-details {
            color: #7f8c8d;
            font-size: 8px;
            margin-right: 4px;
        }

        /* ===== DIET SECTION ===== */
        .diet-section {
            margin-bottom: 18px;
        }

        .diet-macros-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr;
            gap: 8px;
            margin-bottom: 12px;
        }

        .macro-box {
            background-color: #ecf0f1;
            padding: 8px;
            border-radius: 4px;
            text-align: center;
            border: 1px solid #bdc3c7;
        }

        .macro-label {
            font-size: 8px;
            color: #7f8c8d;
            margin-bottom: 3px;
        }

        .macro-value {
            font-size: 11px;
            font-weight: bold;
            color: #27ae60;
        }

        .diet-meals {
            font-size: 9px;
        }

        .meal-box {
            margin-bottom: 10px;
            padding: 8px;
            background-color: #f8f9fa;
            border-right: 3px solid #27ae60;
            border-radius: 2px;
        }

        .meal-name {
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 4px;
        }

        .meal-foods {
            color: #34495e;
            line-height: 1.5;
        }

        /* ===== FOOTER ===== */
        .footer {
            margin-top: 20px;
            padding-top: 12px;
            border-top: 1px solid #bdc3c7;
            text-align: center;
            font-size: 8px;
            color: #7f8c8d;
        }

        .footer-text {
            margin: 3px 0;
        }

        /* ===== PRINT OPTIMIZATION ===== */
        @media print {
            body {
                margin: 0;
                padding: 0;
                background: white;
            }
            .container {
                page-break-inside: avoid;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- ===== HEADER ===== -->
        <div class="header">
            <div class="gym-logo-section">
                @if(isset($gymInfo) && $gymInfo->logo_path)
                    <img src="{{ $gymInfo->getLogoUrl() }}" alt="لوگو" class="gym-logo">
                @endif
            </div>
            <div class="gym-name">{{ isset($gymInfo) ? persian_pdf_shape((string)$gymInfo->gym_name) : persian_pdf_shape('سیستم مدیریت باشگاه') }}</div>
            <div class="header-subtitle">{{ persian_pdf_shape('پلان فیتنس و تغذیه') }}</div>
            <div class="header-date">{{ now()->format('d/m/Y') }}</div>
        </div>

        <!-- ===== MEMBER INFORMATION ===== -->
        <div class="member-section">
            <div class="section-title">{{ persian_pdf_shape('اطلاعات عضو') }}</div>
            <div class="member-grid">
                <div class="member-item">
                    <div class="member-label">{{ persian_pdf_shape('نام') }}</div>
                    <div class="member-value">{{ persian_pdf_shape((string)$member->name) }}</div>
                </div>
                <div class="member-item">
                    <div class="member-label">{{ persian_pdf_shape('سن') }}</div>
                    <div class="member-value">{{ $workoutPlan->age ?? 'N/A' }} {{ persian_pdf_shape('سال') }}</div>
                </div>
                <div class="member-item">
                    <div class="member-label">{{ persian_pdf_shape('وزن') }}</div>
                    <div class="member-value">{{ $workoutPlan->weight ?? 'N/A' }} {{ persian_pdf_shape('کیلوگرم') }}</div>
                </div>
                <div class="member-item">
                    <div class="member-label">{{ persian_pdf_shape('هدف') }}</div>
                    <div class="member-value">
                        @php
                            $goalTranslations = [
                                'Fat Loss' => 'کاهش چربی',
                                'Muscle Gain' => 'افزایش ماس عضلانی',
                                'Weight Maintenance' => 'حفظ وزن',
                                'General Fitness' => 'سلامتی عمومی',
                                'Strength Training' => 'تقویت قدرت',
                                'Endurance' => 'تحمل ورزشی',
                            ];
                            $goal = $goalTranslations[$workoutPlan->goal] ?? $workoutPlan->goal;
                            echo persian_pdf_shape((string)$goal);
                        @endphp
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== WORKOUT PLAN TABLE ===== -->
        <div>
            <div class="section-title">{{ persian_pdf_shape('برنامه ورزشی') }}</div>
            <table class="workout-table">
                <thead>
                    <tr>
                        <th class="day-cell">{{ persian_pdf_shape('روز') }}</th>
                        <th class="muscle-cell">{{ persian_pdf_shape('گروه عضلانی') }}</th>
                        <th class="exercises-cell">{{ persian_pdf_shape('تمرینات') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $workoutData = $workoutPlan->plan_data ?? [];
                        $planService = app('App\Services\PlanService');
                        $formatted = $planService->formatWorkoutPlanForDisplay($workoutData);
                    @endphp

                    @foreach ($formatted as $day => $details)
                        <tr>
                            <td class="day-cell">{{ persian_pdf_shape((string)$day) }}</td>
                            <td class="muscle-cell">{{ persian_pdf_shape((string)($details['muscle_group'] ?? 'N/A')) }}</td>
                            <td class="exercises-cell">
                                @foreach(array_slice($details['exercises'] ?? [], 0, 5) as $exercise)
                                    <div class="exercise-item">
                                        <span class="exercise-name">{{ persian_pdf_shape((string)$exercise['name']) }}</span>
                                        <span class="exercise-details">({{ $exercise['sets'] }}×{{ $exercise['reps'] }})</span>
                                    </div>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- ===== DIET PLAN SECTION ===== -->
        <div class="diet-section">
            <div class="section-title">{{ persian_pdf_shape('برنامه تغذیهای') }}</div>

            @php
                $dietData = $dietPlan->plan_data ?? [];
                $formattedDiet = $planService->formatDietPlanForDisplay($dietData);
                $dailyMacros = $planService->calculateDailyMacros($formattedDiet);
            @endphp

            <!-- Macros Grid -->
            <div class="diet-macros-grid">
                <div class="macro-box">
                    <div class="macro-label">{{ persian_pdf_shape('کالری') }}</div>
                    <div class="macro-value">{{ $dailyMacros['calories'] ?? 0 }}</div>
                </div>
                <div class="macro-box">
                    <div class="macro-label">{{ persian_pdf_shape('پروتئین') }}</div>
                    <div class="macro-value">{{ $dailyMacros['protein'] ?? 0 }}گ</div>
                </div>
                <div class="macro-box">
                    <div class="macro-label">{{ persian_pdf_shape('کربوهیدرات') }}</div>
                    <div class="macro-value">{{ $dailyMacros['carbs'] ?? 0 }}گ</div>
                </div>
                <div class="macro-box">
                    <div class="macro-label">{{ persian_pdf_shape('چربی') }}</div>
                    <div class="macro-value">{{ $dailyMacros['fats'] ?? 0 }}گ</div>
                </div>
            </div>

            <!-- Meals List -->
            <div class="diet-meals">
                @php
                    $mealTranslations = [
                        'breakfast' => 'صبحانه',
                        'lunch' => 'ناهار',
                        'dinner' => 'شام',
                        'snack' => 'اسنک',
                    ];
                @endphp
                @foreach(array_slice($formattedDiet, 0, 4) as $mealType => $meal)
                    <div class="meal-box">
                        <div class="meal-name">{{ persian_pdf_shape((string)($mealTranslations[$mealType] ?? ucfirst($mealType))) }}</div>
                        <div class="meal-foods">
                            {{ persian_pdf_shape((string)implode(' • ', array_slice($meal['foods'] ?? [], 0, 4))) }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- ===== FOOTER ===== -->
        <div class="footer">
            <div class="footer-text">{{ persian_pdf_shape('ثابت قدم باشید و هوشمند تمرین کنید') }}</div>
            <div class="footer-text">{{ persian_pdf_shape('تاریخ:') }} {{ now()->format('d F Y') }}</div>
            @if(isset($gymInfo))
                <div class="footer-text">{{ $gymInfo->phone }} • {{ $gymInfo->email }}</div>
            @endif
        </div>
    </div>
</body>
</html>