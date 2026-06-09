@extends('layouts.app-modern')

@section('title', 'Settings')

@section('content')
<div class="page-header">
    <div class="relative overflow-hidden rounded-2xl p-8 shadow-lg bg-gradient-to-r from-sky-500 to-cyan-500">
        <div class="relative z-10 max-w-3xl">
            <span class="inline-flex items-center rounded-full bg-white/15 px-4 py-1 text-sm font-semibold text-white backdrop-blur-sm">
                ✨ Premium settings
            </span>
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mt-4">Make your gym experience shine</h1>
            <p class="text-slate-100 max-w-2xl">Update gym branding, contact details, and visual theme with a sleek, modern settings page designed for fast control and clear feedback.</p>
        </div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_rgba(255,255,255,0.18),_transparent_30%)]"></div>
        <div class="absolute bottom-0 left-0 h-24 w-24 rounded-full bg-white/10 blur-2xl"></div>
    </div>
</div>

<div class="grid gap-6 xl:grid-cols-[1.7fr_1fr]">
    <section class="card overflow-hidden rounded-[26px] border-transparent shadow-lg">
        <div class="card-header bg-gradient-to-r from-sky-500 to-cyan-500 text-white">Gym Information</div>
        <div class="card-body bg-slate-50 dark:bg-slate-800">
            <form action="{{ route('settings.updateGymInfo') }}" method="POST" enctype="multipart/form-data" data-offline-sync="true">
                @csrf

                <div class="grid gap-4 md:grid-cols-2">
                    <div class="form-group">
                        <label class="form-label" for="gym_name">Gym Name</label>
                        <input type="text" id="gym_name" name="gym_name" value="{{ $gymInfo->gym_name ?? 'GymPro Fitness' }}" class="form-input" placeholder="Enter gym name" required>
                        @error('gym_name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="currency">Currency</label>
                        <select id="currency" name="currency" class="form-input">
                            <option value="AFN" {{ ($gymInfo->currency ?? 'AFN') == 'AFN' ? 'selected' : '' }}>AFN - Afghan Afghani (AF)</option>
                            <option value="USD" {{ ($gymInfo->currency ?? '') == 'USD' ? 'selected' : '' }}>USD - US Dollar ($)</option>
                            <option value="EUR" {{ ($gymInfo->currency ?? '') == 'EUR' ? 'selected' : '' }}>EUR - Euro (€)</option>
                            <option value="PKR" {{ ($gymInfo->currency ?? '') == 'PKR' ? 'selected' : '' }}>PKR - Pakistani Rupee (Rs)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="address">Address</label>
                        <input type="text" id="address" name="address" value="{{ $gymInfo->address ?? '' }}" class="form-input" placeholder="123 Main Street, City, State" required>
                        @error('address')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="phone">شماره تلفن</label>
                        <input type="tel" id="phone" name="phone" value="{{ $gymInfo->phone ?? '+93 123 456 789' }}" class="form-input" placeholder="+93 123 456 789" required>
                        @error('phone')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group md:col-span-2">
                        <label class="form-label" for="email">ایمیل</label>
                        <input type="email" id="email" name="email" value="{{ $gymInfo->email ?? 'info@gympro.com' }}" class="form-input" placeholder="info@gympro.com" required>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:justify-end">
                    <button type="submit" class="btn btn-success">ذخیره تغییرات</button>
                    <button type="button" class="btn btn-outline" onclick="window.history.back()">Cancel</button>
                </div>
            </form>
        </div>
    </section>

    <section class="card overflow-hidden rounded-[26px] border-transparent shadow-lg">
        <div class="card-header bg-gradient-to-r from-cyan-500 to-sky-600 text-white">تنظیمات تیم</div>
        <div class="card-body">
                <div class="mb-6 flex items-start gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-3xl bg-sky-100 text-sky-700 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 3a1 1 0 011 1v1a1 1 0 11-2 0V4a1 1 0 011-1zm6.364 3.636a1 1 0 010 1.414L17.414 8.999a1 1 0 01-1.414-1.414l1.95-1.95a1 1 0 011.414 0zM21 11a1 1 0 100 2h-1a1 1 0 100-2h1zM17.364 17.364a1 1 0 00-1.414 1.414l1.95 1.95a1 1 0 001.414-1.414l-1.95-1.95zM12 18a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zm-5.364-1.636a1 1 0 00-1.414 1.414l1.95 1.95a1 1 0 001.414-1.414l-1.95-1.95zM4 11a1 1 0 100 2H3a1 1 0 100-2h1zm1.636-5.364a1 1 0 011.414-1.414l1.95 1.95A1 1 0 018.999 8.999l-1.95-1.95z" />
                        <path d="M12 7a5 5 0 100 10 5 5 0 000-10z" />
                    </svg>
                </div>
                <div>
                    <h2 class="text-lg font-semibold">انتخاب تم</h2>
                    <p class="text-sm text-slate-400">بهترین حالت را برای داشبورد خود انتخاب کنید و اجازه دهید سیستم انتخاب شما را به خاطر بسپارد.</p>
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-3">
                <button type="button" class="theme-option rounded-2xl border p-5 text-left transition hover:-translate-y-0.5 bg-white/5 text-white shadow-sm" data-theme="light">
                    <div class="flex items-center justify-between gap-3">
                        <span class="text-base font-semibold">روشن</span>
                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">روشن</span>
                    </div>
                    <p class="mt-3 text-sm text-slate-400">A clean, energetic layout with soft shadows and bright accents.</p>
                </button>

                <button type="button" class="theme-option rounded-2xl border p-5 text-left transition hover:-translate-y-0.5 bg-white/5 text-white shadow-sm" data-theme="dark">
                    <div class="flex items-center justify-between gap-3">
                        <span class="text-base font-semibold">تاریک</span>
                        <span class="rounded-full bg-slate-800 px-3 py-1 text-xs font-semibold text-slate-200">تاریک</span>
                    </div>
                    <p class="mt-3 text-sm text-slate-400">یک حالت  فونت بولد و واضاحت بیشتر برای اواخر شب</p>
                </button>

                <button type="button" class="theme-option rounded-2xl border p-5 text-left transition hover:-translate-y-0.5 bg-white/5 text-white shadow-sm" data-theme="auto">
                    <div class="flex items-center justify-between gap-3">
                        <span class="text-base font-semibold">خودکار</span>
                        <span class="rounded-full bg-sky-100 px-3 py-1 text-xs font-semibold text-sky-700">هوشمند</span>
                    </div>
                    <p class="mt-3 text-sm text-slate-400">نظر به زمان دستگاه مود تاریک و روشن تنظیم میگردد</p>
                </button>
            </div>
        </div>
    </section>
</div>
<script>
    function updateThemeSelection(theme) {
        document.querySelectorAll('.theme-option').forEach((option) => {
            const active = option.dataset.theme === theme;
            option.classList.toggle('ring-2', active);
            option.classList.toggle('ring-sky-400', active);
            option.classList.toggle('bg-sky-500/10', active);
        });
    }

    function setTheme(theme) {
        const html = document.documentElement;

        if (theme === 'light') {
            html.classList.remove('theme-dark');
            html.classList.add('theme-light');
        } else if (theme === 'dark') {
            html.classList.remove('theme-light');
            html.classList.add('theme-dark');
        } else if (theme === 'auto') {
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            html.classList.toggle('theme-dark', prefersDark);
            html.classList.toggle('theme-light', !prefersDark);
        }

        localStorage.setItem('theme', theme);
        updateThemeSelection(theme);
    }

    document.addEventListener('DOMContentLoaded', function () {
        const savedTheme = localStorage.getItem('theme') || 'auto';
        updateThemeSelection(savedTheme);
        setTheme(savedTheme);

        document.querySelectorAll('.theme-option').forEach((option) => {
            option.addEventListener('click', function () {
                setTheme(this.dataset.theme);
            });
        });
    });
</script>
@endsection