@extends('layouts.app')

@section('title', 'تولید برنامه تمرینی و تغذیه')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">تولید برنامه‌های محلی</h1>
        <p class="page-subtitle">ایجاد برنامه‌های تمرینی و تغذیه شخصی‌سازی شده به صورت محلی برای {{ $member->name }}</p>
    </div>
    <a href="{{ route('members.show', $member) }}" class="btn btn-outline">← بازگشت به عضو</a>
</div>

@if ($errors->any())
    <x-alert type="error">
        <ul class="space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </x-alert>
@endif

@if (session('success'))
    <x-alert type="success">{{ session('success') }}</x-alert>
@endif

@if (session('error'))
    <x-alert type="error">{{ session('error') }}</x-alert>
@endif

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Shared Data Section -->
    <div class="lg:col-span-2">
        <x-card class="bg-slate-950 border-slate-700">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-white">اطلاعات عضو</h2>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div class="bg-slate-900 rounded-lg p-4">
                    <p class="text-gray-500 text-sm">نام</p>
                    <p class="text-white font-semibold">{{ $member->name }}</p>
                </div>
                <div class="bg-slate-900 rounded-lg p-4">
                    <p class="text-gray-500 text-sm">نام پدر</p>
                    <p class="text-white font-semibold text-sm">{{ $member->email }}</p>
                </div>
                <div class="bg-slate-900 rounded-lg p-4">
                    <p class="text-gray-500 text-sm">تلفن</p>
                    <p class="text-white font-semibold">{{ $member->phone ?? 'نامشخص' }}</p>
                </div>
                <div class="bg-slate-900 rounded-lg p-4">
                    <p class="text-gray-500 text-sm">تاریخ عضویت</p>
                    <p class="text-white font-semibold">{{ $member->join_date?->format('M d, Y') ?? 'نامشخص' }}</p>
                </div>
            </div>
        </x-card>
    </div>

    <!-- Workout Plan Form -->
    <div>
        <x-card class="bg-slate-950 border-slate-700 h-full">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-white">تولید برنامه تمرینی</h2>
                @if ($latestWorkout)
                    <span class="px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-xs font-semibold">ایجاد شده</span>
                @endif
            </div>

            <form action="{{ route('ai.workout', $member) }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="workout_age" class="block text-gray-400 font-semibold mb-2">سن</label>
                    <input type="number" id="workout_age" name="age" min="13" max="120" required
                        value="{{ old('age', $latestWorkout?->age ?? '') }}"
                        class="w-full rounded-lg border border-slate-700 bg-slate-900 px-4 py-2 text-white outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500" />
                    @error('age')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="workout_weight" class="block text-gray-400 font-semibold mb-2">وزن (کیلوگرم)</label>
                    <input type="number" id="workout_weight" name="weight" min="30" max="500" step="0.1" required
                        value="{{ old('weight', $latestWorkout?->weight ?? '') }}"
                        class="w-full rounded-lg border border-slate-700 bg-slate-900 px-4 py-2 text-white outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500" />
                    @error('weight')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="workout_height" class="block text-gray-400 font-semibold mb-2">قد (سانتی‌متر)</label>
                    <input type="number" id="workout_height" name="height" min="120" max="250" required
                        value="{{ old('height', $latestWorkout?->height ?? '') }}"
                        class="w-full rounded-lg border border-slate-700 bg-slate-900 px-4 py-2 text-white outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500" />
                    @error('height')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="workout_goal" class="block text-gray-400 font-semibold mb-2">هدف</label>
                    <select id="workout_goal" name="goal" required
                        class="w-full rounded-lg border border-slate-700 bg-slate-900 px-4 py-2 text-white outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                        <option value="">یک هدف انتخاب کنید...</option>
                        <option value="Fat Loss" {{ old('goal', $latestWorkout?->goal) === 'Fat Loss' ? 'selected' : '' }}>کاهش وزن</option>
                        <option value="Muscle Gain" {{ old('goal', $latestWorkout?->goal) === 'Muscle Gain' ? 'selected' : '' }}>افزایش عضله</option>
                        <option value="General Fitness" {{ old('goal', $latestWorkout?->goal) === 'General Fitness' ? 'selected' : '' }}>تناسب اندام عمومی</option>
                    </select>
                    @error('goal')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="workout_level" class="block text-gray-400 font-semibold mb-2">سطح تجربه</label>
                    <select id="workout_level" name="level" required
                        class="w-full rounded-lg border border-slate-700 bg-slate-900 px-4 py-2 text-white outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                        <option value="">یک سطح انتخاب کنید...</option>
                        <option value="Beginner" {{ old('level', $latestWorkout?->level) === 'Beginner' ? 'selected' : '' }}>مبتدی</option>
                        <option value="Intermediate" {{ old('level', $latestWorkout?->level) === 'Intermediate' ? 'selected' : '' }}>متوسط</option>
                        <option value="Advanced" {{ old('level', $latestWorkout?->level) === 'Advanced' ? 'selected' : '' }}>پیشرفته</option>
                    </select>
                    @error('level')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg transition">
                    تولید برنامه تمرینی
                </button>

                @if ($latestWorkout)
                    <a href="{{ route('ai.show-plans', $member) }}" class="w-full block text-center bg-slate-700 hover:bg-slate-600 text-white font-semibold py-2 rounded-lg transition">
                        مشاهده آخرین برنامه
                    </a>
                @endif
            </form>
        </x-card>
    </div>

    <!-- Diet Plan Form -->
    <div>
        <x-card class="bg-slate-950 border-slate-700 h-full">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-white">تولید برنامه تغذیه</h2>
                @if ($latestDiet)
                    <span class="px-3 py-1 bg-green-500/20 text-green-400 rounded-full text-xs font-semibold">ایجاد شده</span>
                @endif
            </div>

            <form action="{{ route('ai.diet', $member) }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="diet_age" class="block text-gray-400 font-semibold mb-2">سن</label>
                    <input type="number" id="diet_age" name="age" min="13" max="120" required
                        value="{{ old('age', $latestDiet?->age ?? '') }}"
                        class="w-full rounded-lg border border-slate-700 bg-slate-900 px-4 py-2 text-white outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500" />
                    @error('age')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="diet_weight" class="block text-gray-400 font-semibold mb-2">وزن (کیلوگرم)</label>
                    <input type="number" id="diet_weight" name="weight" min="30" max="500" step="0.1" required
                        value="{{ old('weight', $latestDiet?->weight ?? '') }}"
                        class="w-full rounded-lg border border-slate-700 bg-slate-900 px-4 py-2 text-white outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500" />
                    @error('weight')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="diet_height" class="block text-gray-400 font-semibold mb-2">قد (سانتی‌متر)</label>
                    <input type="number" id="diet_height" name="height" min="120" max="250" required
                        value="{{ old('height', $latestDiet?->height ?? '') }}"
                        class="w-full rounded-lg border border-slate-700 bg-slate-900 px-4 py-2 text-white outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500" />
                    @error('height')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="diet_goal" class="block text-gray-400 font-semibold mb-2">هدف</label>
                    <select id="diet_goal" name="goal" required
                        class="w-full rounded-lg border border-slate-700 bg-slate-900 px-4 py-2 text-white outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                        <option value="">یک هدف انتخاب کنید...</option>
                        <option value="Fat Loss" {{ old('goal', $latestDiet?->goal) === 'Fat Loss' ? 'selected' : '' }}>کاهش وزن</option>
                        <option value="Muscle Gain" {{ old('goal', $latestDiet?->goal) === 'Muscle Gain' ? 'selected' : '' }}>افزایش عضله</option>
                        <option value="General Fitness" {{ old('goal', $latestDiet?->goal) === 'General Fitness' ? 'selected' : '' }}>تناسب اندام عمومی</option>
                    </select>
                    @error('goal')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="diet_level" class="block text-gray-400 font-semibold mb-2">سطح تجربه</label>
                    <select id="diet_level" name="level" required
                        class="w-full rounded-lg border border-slate-700 bg-slate-900 px-4 py-2 text-white outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                        <option value="">یک سطح انتخاب کنید...</option>
                        <option value="Beginner" {{ old('level', $latestDiet?->level) === 'Beginner' ? 'selected' : '' }}>مبتدی</option>
                        <option value="Intermediate" {{ old('level', $latestDiet?->level) === 'Intermediate' ? 'selected' : '' }}>متوسط</option>
                        <option value="Advanced" {{ old('level', $latestDiet?->level) === 'Advanced' ? 'selected' : '' }}>پیشرفته</option>
                    </select>
                    @error('level')
                        <p class="text-red-400 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-lg transition">
                    تولید برنامه تغذیه
                </button>

                @if ($latestDiet)
                    <a href="{{ route('ai.show-plans', $member) }}" class="w-full block text-center bg-slate-700 hover:bg-slate-600 text-white font-semibold py-2 rounded-lg transition">
                        مشاهده آخرین برنامه
                    </a>
                @endif
            </form>
        </x-card>
    </div>
</div>

@endsection
