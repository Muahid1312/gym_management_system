@extends('layouts.app')

@section('title', 'برنامه‌های تمرینی و تغذیه')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">برنامه‌های تناسب اندام</h1>
        <p class="page-subtitle">برنامه‌های تمرینی و تغذیه شخصی‌سازی شده برای {{ $member->name }}</p>
    </div>
    <div class="flex gap-2">
        @if ($workoutPlan && $dietPlan)
            <a href="{{ route('ai.download-pdf-professional', $member) }}" class="btn btn-primary">📄 دانلود PDF حرفه‌ای</a>
            <a href="{{ route('ai.download-pdf', $member) }}" class="btn btn-outline">📥 PDF فشرده</a>
            <a href="{{ route('ai.print-plans', $member) }}" class="btn btn-outline" target="_blank">🖨️ چاپ کامل</a>
            <a href="{{ route('ai.print-plans-compact', $member) }}" class="btn btn-outline" target="_blank">📋 چاپ خلاصه</a>
        @endif
        <a href="{{ route('ai.generate', $member) }}" class="btn btn-outline">✏️ ویرایش برنامه‌ها</a>
        <a href="{{ route('members.show', $member) }}" class="btn btn-outline">← بازگشت</a>
    </div>
</div>

@if (session('success'))
    <x-alert type="success">{{ session('success') }}</x-alert>
@endif

<!-- Member Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <x-card class="bg-gradient-to-br from-blue-600 to-blue-700 border-0">
        <p class="text-blue-100">سن</p>
        <p class="text-2xl font-bold text-white">{{ $workoutPlan?->age ?? 'N/A' }}</p>
    </x-card>
    <x-card class="bg-gradient-to-br from-purple-600 to-purple-700 border-0">
        <p class="text-purple-100">وزن</p>
        <p class="text-2xl font-bold text-white">{{ $workoutPlan?->weight ?? 'N/A' }} <span class="text-lg">کیلوگرم</span></p>
    </x-card>
    <x-card class="bg-gradient-to-br from-green-600 to-green-700 border-0">
        <p class="text-green-100">قد</p>
        <p class="text-2xl font-bold text-white">{{ $workoutPlan?->height ?? 'N/A' }} <span class="text-lg">سانتی‌متر</span></p>
    </x-card>
    <x-card class="bg-gradient-to-br from-orange-600 to-orange-700 border-0">
        <p class="text-orange-100">شاخص توده بدنی</p>
        <div>
            <p class="text-2xl font-bold text-white">{{ $bmi ?? 'N/A' }}</p>
            <p class="text-xs text-orange-100 mt-1">{{ $bmiCategory ?? 'N/A' }}</p>
        </div>
    </x-card>
</div>

<!-- Workout Plan Section -->
@if ($workoutPlan && $formattedWorkout)
    <x-card class="bg-slate-950 border-slate-700 mb-6">
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-700">
            <div>
                <h2 class="text-2xl font-bold text-white">💪 برنامه تمرینی</h2>
                <p class="text-gray-400 text-sm mt-1">
                    <strong>هدف:</strong> @php
                        $goalTranslations = [
                            'Fat Loss' => 'کاهش وزن',
                            'Muscle Gain' => 'افزایش عضله',
                            'General Fitness' => 'تناسب اندام عمومی',
                            'Strength Training' => 'تمرین قدرتی',
                            'Endurance' => 'تحمل',
                        ];
                        echo $goalTranslations[$workoutPlan->goal] ?? $workoutPlan->goal;
                    @endphp | 
                    <strong>سطح:</strong> @php
                        $levelTranslations = [
                            'Beginner' => 'مبتدی',
                            'Intermediate' => 'متوسط',
                            'Advanced' => 'پیشرفته',
                        ];
                        echo $levelTranslations[$workoutPlan->level] ?? $workoutPlan->level;
                    @endphp
                </p>
            </div>
            <form action="{{ route('plans.workout.delete', $workoutPlan) }}" method="POST" onsubmit="return confirm('این برنامه تمرینی حذف شود؟');" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-400 hover:text-red-300 text-sm">🗑️ حذف</button>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach ($formattedWorkout as $day => $details)
                <div class="bg-slate-900 rounded-lg p-4 border border-slate-800">
                    <h3 class="text-lg font-semibold text-blue-400 mb-3">{{ $day }}</h3>
                    <p class="text-gray-400 text-sm mb-4">
                        <strong>گروه‌های عضلانی:</strong> {{ $details['muscle_group'] ?? 'N/A' }}
                    </p>

                    <div class="space-y-3">
                        @foreach ($details['exercises'] ?? [] as $exercise)
                            <div class="bg-slate-950 rounded p-3 border-l-2 border-blue-500">
                                <p class="font-semibold text-white">{{ $exercise['name'] }}</p>
                                <div class="grid grid-cols-3 gap-2 mt-2 text-xs text-gray-300">
                                    <div>
                                        <span class="text-gray-500">ست‌ها</span>
                                        <p class="font-semibold">{{ $exercise['sets'] }}</p>
                                    </div>
                                    <div>
                                        <span class="text-gray-500">تکرارها</span>
                                        <p class="font-semibold">{{ $exercise['reps'] }}</p>
                                    </div>
                                </div>
                                @if ($exercise['notes'])
                                    <p class="text-gray-400 text-xs mt-2 italic">💡 {{ $exercise['notes'] }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </x-card>
@else
    <x-card class="bg-slate-950 border-slate-700 mb-6">
        <p class="text-center text-gray-400 py-8">هنوز برنامه تمرینی تولید نشده است. <a href="{{ route('ai.generate', $member) }}" class="text-blue-400 hover:underline">اکنون یکی تولید کنید</a></p>
    </x-card>
@endif

<!-- Diet Plan Section -->
@if ($dietPlan && $formattedDiet)
    <x-card class="bg-slate-950 border-slate-700 mb-6">
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-700">
            <div>
                <h2 class="text-2xl font-bold text-white">🍎 برنامه تغذیه</h2>
                <p class="text-gray-400 text-sm mt-1">
                    <strong>هدف:</strong> @php
                        $goalTranslations = [
                            'Fat Loss' => 'کاهش وزن',
                            'Muscle Gain' => 'افزایش عضله',
                            'General Fitness' => 'تناسب اندام عمومی',
                            'Strength Training' => 'تمرین قدرتی',
                            'Endurance' => 'تحمل',
                        ];
                        echo $goalTranslations[$dietPlan->goal] ?? $dietPlan->goal;
                    @endphp | 
                    <strong>سطح:</strong> @php
                        $levelTranslations = [
                            'Beginner' => 'مبتدی',
                            'Intermediate' => 'متوسط',
                            'Advanced' => 'پیشرفته',
                        ];
                        echo $levelTranslations[$dietPlan->level] ?? $dietPlan->level;
                    @endphp
                </p>
            </div>
            <form action="{{ route('plans.diet.delete', $dietPlan) }}" method="POST" onsubmit="return confirm('این برنامه تغذیه حذف شود؟');" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-400 hover:text-red-300 text-sm">🗑️ حذف</button>
            </form>
        </div>

        <!-- Daily Macros Summary -->
        @if ($dailyMacros)
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6 pb-6 border-b border-slate-700">
                <div class="bg-slate-900 rounded-lg p-4">
                    <p class="text-gray-500 text-sm">کل کالری</p>
                    <p class="text-2xl font-bold text-orange-400">{{ $dailyMacros['calories'] ?? 0 }}</p>
                </div>
                <div class="bg-slate-900 rounded-lg p-4">
                    <p class="text-gray-500 text-sm">پروتئین</p>
                    <p class="text-2xl font-bold text-red-400">{{ $dailyMacros['protein'] ?? 0 }}گرم</p>
                </div>
                <div class="bg-slate-900 rounded-lg p-4">
                    <p class="text-gray-500 text-sm">کربوهیدرات</p>
                    <p class="text-2xl font-bold text-blue-400">{{ $dailyMacros['carbs'] ?? 0 }}گرم</p>
                </div>
                <div class="bg-slate-900 rounded-lg p-4">
                    <p class="text-gray-500 text-sm">چربی</p>
                    <p class="text-2xl font-bold text-yellow-400">{{ $dailyMacros['fats'] ?? 0 }}گرم</p>
                </div>
            </div>
        @endif

        <!-- Meals -->
        <div class="space-y-6">
            @php
                $mealTranslations = [
                    'breakfast' => 'صبحانه',
                    'lunch' => 'ناهار',
                    'dinner' => 'شام',
                    'snack' => 'میان‌وعده',
                ];
            @endphp
            @foreach ($formattedDiet as $mealType => $meal)
                <div class="border border-slate-800 rounded-lg p-5 bg-slate-900/50">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-semibold text-green-400 capitalize">{{ $mealTranslations[$mealType] ?? ucfirst($mealType) }}: {{ $meal['name'] }}</h3>
                            @if ($meal['calories'])
                                <p class="text-gray-400 text-sm mt-1">{{ $meal['calories'] }} کالری</p>
                            @endif
                        </div>
                    </div>

                    <div class="mb-4">
                        <p class="text-gray-400 text-sm mb-2">مواد غذایی:</p>
                        <ul class="space-y-1">
                            @foreach ($meal['foods'] ?? [] as $food)
                                <li class="text-gray-300 text-sm">• {{ $food }}</li>
                            @endforeach
                        </ul>
                    </div>

                    @if ($meal['macros'])
                        <div class="grid grid-cols-3 gap-3 py-3 border-t border-slate-700">
                            <div>
                                <p class="text-gray-500 text-xs">پروتئین</p>
                                <p class="font-semibold text-red-400">{{ $meal['macros']['protein'] ?? 0 }}گرم</p>
                            </div>
                            <div>
                                <p class="text-gray-500 text-xs">کربوهیدرات</p>
                                <p class="font-semibold text-blue-400">{{ $meal['macros']['carbs'] ?? 0 }}گرم</p>
                            </div>
                            <div>
                                <p class="text-gray-500 text-xs">چربی</p>
                                <p class="font-semibold text-yellow-400">{{ $meal['macros']['fats'] ?? 0 }}گرم</p>
                            </div>
                        </div>
                    @endif

                    @if ($meal['notes'])
                        <p class="text-gray-400 text-sm mt-4 italic">💡 {{ $meal['notes'] }}</p>
                    @endif
                </div>
            @endforeach
        </div>
    </x-card>
@else
    <x-card class="bg-slate-950 border-slate-700">
        <p class="text-center text-gray-400 py-8">هنوز برنامه تغذیه تولید نشده است. <a href="{{ route('ai.generate', $member) }}" class="text-blue-400 hover:underline">اکنون یکی تولید کنید</a></p>
    </x-card>
@endif

@endsection
