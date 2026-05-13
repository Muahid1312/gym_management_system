@extends('layouts.app')

@section('content')
@php
    $activeSection = $activeSection ?? request('section', 'general');
@endphp

<div class="min-h-screen bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 py-10 sm:px-6 lg:px-8">
        <div class="mb-8 rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <div class="sm:flex sm:items-center sm:justify-between sm:gap-6">
                <div>
                    <p class="text-sm uppercase tracking-[0.3em] text-slate-500">{{ __('messages.control_panel') }}</p>
                    <h1 class="mt-3 text-3xl font-semibold text-slate-900">{{ __('messages.settings') }}</h1>
                    <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-600">
                        {{ __('messages.settings_description') }}
                    </p>
                </div>
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                    <a href="{{ route('backups.index') }}" class="inline-flex items-center rounded-3xl bg-slate-100 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-200">
                        {{ __('messages.backup_manager') }}
                    </a>
                    <div class="rounded-3xl border border-slate-200 bg-white p-5 text-sm text-slate-700 shadow-sm">
                        <label for="localeSelector" class="block text-sm font-medium text-slate-700">{{ __('messages.language') }}</label>
                        <select id="localeSelector" onchange="window.location.href = this.value" class="mt-2 block w-full rounded-3xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-900 shadow-sm focus:border-sky-500 focus:ring-sky-500">
                            <option value="{{ route('locale.switch', 'fa') }}" {{ app()->getLocale() === 'fa' ? 'selected' : '' }}>{{ __('messages.language_fa') }}</option>
                            <option value="{{ route('locale.switch', 'en') }}" {{ app()->getLocale() === 'en' ? 'selected' : '' }}>{{ __('messages.language_en') }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-[260px_1fr]">
            <aside class="space-y-5">
                <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                    <h2 class="text-base font-semibold text-slate-900">{{ __('messages.sections_label') }}</h2>
                    <nav class="mt-5 space-y-2">
                        @php
                            $tabs = [
                                'general' => __('messages.general'),
                                'currency' => __('messages.currency'),
                                'membership' => __('messages.membership'),
                                'notifications' => __('messages.notifications'),
                                'system' => __('messages.system'),
                                'ui' => __('messages.ui'),
                            ];
                        @endphp
                        @foreach ($tabs as $key => $label)
                            <a href="{{ route('settings.index', ['section' => $key]) }}" class="flex items-center justify-between rounded-2xl px-4 py-3 text-sm font-medium transition {{ $activeSection === $key ? 'bg-slate-100 text-slate-900 shadow-sm' : 'text-slate-600 hover:bg-slate-50' }}">
                                <span>{{ $label }}</span>
                                <span class="text-slate-400">→</span>
                            </a>
                        @endforeach
                    </nav>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
                    <h3 class="text-sm font-semibold text-slate-900">{{ __('messages.quick_tips_label') }}</h3>
                    <ul class="mt-4 space-y-3 text-sm text-slate-600">
                        <li>{{ __('messages.quick_tips_gym_name') }}</li>
                        <li>{{ __('messages.quick_tips_currency') }}</li>
                        <li>{{ __('messages.quick_tips_backup') }}</li>
                    </ul>
                </div>
            </aside>

            <main class="space-y-6">
                @if(session('success'))
                    <div class="rounded-3xl border border-emerald-200 bg-emerald-50 p-5 text-sm text-emerald-900 shadow-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm {{ $activeSection !== 'general' ? 'hidden' : '' }}" id="section-general">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-slate-900">{{ __('messages.general_settings') }}</h2>
                            <p class="mt-2 text-sm text-slate-600">{{ __('messages.manage_identity') }}</p>
                        </div>
                        <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-slate-600">{{ __('messages.brand') }}</span>
                    </div>

                    <form action="{{ route('settings.updateGymInfo') }}" method="POST" enctype="multipart/form-data" class="mt-6 space-y-6">
                        @csrf
                        <div class="grid gap-5 lg:grid-cols-2">
                            <div>
                                <label for="gym_name" class="block text-sm font-medium text-slate-700">{{ __('messages.gym_name') }}</label>
                                <input id="gym_name" name="gym_name" type="text" value="{{ old('gym_name', $gymInfo->gym_name) }}" class="mt-2 block w-full rounded-3xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-900 shadow-sm focus:border-sky-500 focus:ring-sky-500" required>
                                @error('gym_name')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="address" class="block text-sm font-medium text-slate-700">{{ __('messages.address') }}</label>
                                <input id="address" name="address" type="text" value="{{ old('address', $gymInfo->address) }}" class="mt-2 block w-full rounded-3xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-900 shadow-sm focus:border-sky-500 focus:ring-sky-500" required>
                                @error('address')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-slate-700">{{ __('messages.phone') }}</label>
                                <input id="phone" name="phone" type="tel" value="{{ old('phone', $gymInfo->phone) }}" class="mt-2 block w-full rounded-3xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-900 shadow-sm focus:border-sky-500 focus:ring-sky-500" required>
                                @error('phone')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-slate-700">{{ __('messages.email') }}</label>
                                <input id="email" name="email" type="email" value="{{ old('email', $gymInfo->email) }}" class="mt-2 block w-full rounded-3xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-900 shadow-sm focus:border-sky-500 focus:ring-sky-500" required>
                                @error('email')<p class="mt-2 text-sm text-rose-600">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 p-5">
                            <div class="flex flex-col gap-4 lg:flex-row lg:items-center">
                                <div class="grid place-items-center rounded-3xl border border-slate-200 bg-white p-4 w-full max-w-[180px]">
                                    <img id="logoPreview" src="{{ $gymInfo->hasLogo() ? $gymInfo->getLogoUrl() : '' }}" alt="Gym logo preview" class="max-h-32 object-contain {{ $gymInfo->hasLogo() ? '' : 'hidden' }}" />
                                    <div id="logoPlaceholder" class="text-center text-sm text-slate-500 {{ $gymInfo->hasLogo() ? 'hidden' : '' }}">No logo uploaded</div>
                                </div>
                                <div class="flex-1 space-y-3">
                                    <label for="logo" class="block text-sm font-medium text-slate-700">{{ __('messages.upload_logo') }}</label>
                                    <input id="logo" name="logo" type="file" accept="image/*" class="block w-full text-sm text-slate-700 file:mr-4 file:rounded-full file:border-0 file:bg-slate-100 file:px-4 file:py-2 file:text-slate-700" onchange="previewLogo(event)">
                                    @error('logo')<p class="text-sm text-rose-600">{{ $message }}</p>@enderror
                                    <p class="text-sm text-slate-500">{{ __('messages.logo_format') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                            <button type="submit" class="inline-flex items-center justify-center rounded-3xl bg-slate-900 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800">
                                💾 {{ __('messages.save_general_settings') }}
                            </button>
                            @if ($gymInfo->hasLogo())
                                <form action="{{ route('settings.deleteLogo') }}" method="POST" onsubmit="return confirm('Remove current logo?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-3xl border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                                        🗑 {{ __('messages.remove_logo') }}
                                    </button>
                                </form>
                            @endif
                        </div>
                    </form>
                </section>

                <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm {{ $activeSection !== 'currency' ? 'hidden' : '' }}" id="section-currency">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-slate-900">{{ __('messages.currency_settings') }}</h2>
                            <p class="mt-2 text-sm text-slate-600">{{ __('messages.set_default_currency') }}</p>
                        </div>
                        <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-slate-600">{{ __('messages.finance') }}</span>
                    </div>

                    <form action="{{ route('settings.update', ['section' => 'currency']) }}" method="POST" class="mt-6 space-y-6">
                        @csrf
                        <div class="grid gap-5 lg:grid-cols-3">
                            <div>
                                <label for="currency" class="block text-sm font-medium text-slate-700">{{ __('messages.currency') }}</label>
                                <select id="currency" name="currency" class="mt-2 block w-full rounded-3xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-900 shadow-sm focus:border-sky-500 focus:ring-sky-500">
                                    @foreach(['AFN', 'USD', 'EUR', 'GBP', 'AED'] as $currency)
                                        <option value="{{ $currency }}" {{ $settings['currency'] === $currency ? 'selected' : '' }}>{{ $currency }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="currency_symbol" class="block text-sm font-medium text-slate-700">{{ __('messages.symbol') }}</label>
                                <input id="currency_symbol" name="currency_symbol" type="text" value="{{ old('currency_symbol', $settings['currency_symbol']) }}" class="mt-2 block w-full rounded-3xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-900 shadow-sm focus:border-sky-500 focus:ring-sky-500" required>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700">{{ __('messages.position') }}</label>
                                <div class="mt-2 grid gap-2">
                                    @foreach(['before' => __('messages.before_amount'), 'after' => __('messages.after_amount')] as $position => $label)
                                        <label class="inline-flex items-center gap-3 rounded-3xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-700 shadow-sm">
                                            <input type="radio" name="currency_position" value="{{ $position }}" {{ $settings['currency_position'] === $position ? 'checked' : '' }} class="h-4 w-4 text-sky-600">
                                            <span>{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="inline-flex items-center justify-center rounded-3xl bg-slate-900 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800">
                            💾 {{ __('messages.save_currency_settings') }}
                        </button>
                    </form>
                </section>

                <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm {{ $activeSection !== 'membership' ? 'hidden' : '' }}" id="section-membership">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-slate-900">{{ __('messages.membership_settings') }}</h2>
                            <p class="mt-2 text-sm text-slate-600">{{ __('messages.default_duration_rules') }}</p>
                        </div>
                        <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-slate-600">{{ __('messages.plans') }}</span>
                    </div>

                    <form action="{{ route('settings.update', ['section' => 'membership']) }}" method="POST" class="mt-6 space-y-6">
                        @csrf
                        <div class="grid gap-5 lg:grid-cols-3">
                            <div>
                                <label for="default_plan_duration" class="block text-sm font-medium text-slate-700">{{ __('messages.default_plan_duration') }}</label>
                                <select id="default_plan_duration" name="default_plan_duration" class="mt-2 block w-full rounded-3xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-900 shadow-sm focus:border-sky-500 focus:ring-sky-500">
                                    @for ($i = 1; $i <= 24; $i++)
                                        <option value="{{ $i }}" {{ $settings['default_plan_duration'] == $i ? 'selected' : '' }}>{{ $i }} {{ __('messages.months') }}{{ $i > 1 ? 's' : '' }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="space-y-3">
                                <label class="block text-sm font-medium text-slate-700">{{ __('messages.payment_behavior') }}</label>
                                <label class="inline-flex items-center gap-3 rounded-3xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-700 shadow-sm">
                                    <input type="checkbox" id="allow_partial_payments" name="allow_partial_payments" value="1" {{ $settings['allow_partial_payments'] ? 'checked' : '' }} class="h-4 w-4 text-sky-600">
                                    <span>{{ __('messages.allow_partial_payments') }}</span>
                                </label>
                                <label class="inline-flex items-center gap-3 rounded-3xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-700 shadow-sm">
                                    <input type="checkbox" id="enable_debt_system" name="enable_debt_system" value="1" {{ $settings['enable_debt_system'] ? 'checked' : '' }} class="h-4 w-4 text-sky-600">
                                    <span>{{ __('messages.enable_debt_system') }}</span>
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="inline-flex items-center justify-center rounded-3xl bg-slate-900 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800">
                            💾 {{ __('messages.save_membership_settings') }}
                        </button>
                    </form>
                </section>

                <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm {{ $activeSection !== 'notifications' ? 'hidden' : '' }}" id="section-notifications">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-slate-900">{{ __('messages.notification_settings') }}</h2>
                            <p class="mt-2 text-sm text-slate-600">{{ __('messages.enable_disable_reminders') }}</p>
                        </div>
                        <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-slate-600">{{ __('messages.alerts') }}</span>
                    </div>

                    <form action="{{ route('settings.update', ['section' => 'notifications']) }}" method="POST" class="mt-6 space-y-6">
                        @csrf
                        <div class="space-y-4">
                            <label class="inline-flex items-center gap-3 rounded-3xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-700 shadow-sm">
                                <input type="checkbox" id="enable_email_notifications" name="enable_email_notifications" value="1" {{ $settings['enable_email_notifications'] ? 'checked' : '' }} class="h-4 w-4 text-sky-600">
                                <span>{{ __('messages.enable_email_notifications') }}</span>
                            </label>

                            <div class="grid gap-5 lg:grid-cols-2">
                                <div>
                                    <label for="notification_reminder_days" class="block text-sm font-medium text-slate-700">{{ __('messages.reminder_days_before_expiry') }}</label>
                                    <input id="notification_reminder_days" name="notification_reminder_days" type="number" min="1" max="30" value="{{ old('notification_reminder_days', $settings['notification_reminder_days']) }}" class="mt-2 block w-full rounded-3xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-900 shadow-sm focus:border-sky-500 focus:ring-sky-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700">{{ __('messages.whatsapp_alerts') }}</label>
                                    <label class="inline-flex items-center gap-3 rounded-3xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-700 shadow-sm">
                                        <input type="checkbox" id="enable_whatsapp_notifications" name="enable_whatsapp_notifications" value="1" {{ $settings['enable_whatsapp_notifications'] ? 'checked' : '' }} class="h-4 w-4 text-sky-600">
                                        <span>{{ __('messages.enable_whatsapp') }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="inline-flex items-center justify-center rounded-3xl bg-slate-900 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800">
                            💾 {{ __('messages.save_notification_settings') }}
                        </button>
                    </form>
                </section>

                <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm {{ $activeSection !== 'system' ? 'hidden' : '' }}" id="section-system">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-slate-900">{{ __('messages.system_settings') }}</h2>
                            <p class="mt-2 text-sm text-slate-600">{{ __('messages.configure_offline_backup') }}</p>
                        </div>
                        <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-slate-600">{{ __('messages.system') }}</span>
                    </div>

                    <form action="{{ route('settings.update', ['section' => 'system']) }}" method="POST" class="mt-6 space-y-6">
                        @csrf
                        <div class="grid gap-5 lg:grid-cols-3">
                            <label class="inline-flex items-center gap-3 rounded-3xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-700 shadow-sm">
                                <input type="checkbox" id="enable_offline_mode" name="enable_offline_mode" value="1" {{ $settings['enable_offline_mode'] ? 'checked' : '' }} class="h-4 w-4 text-sky-600">
                                <span>{{ __('messages.enable_offline_mode') }}</span>
                            </label>
                            <label class="inline-flex items-center gap-3 rounded-3xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-700 shadow-sm">
                                <input type="checkbox" id="auto_backup_enabled" name="auto_backup_enabled" value="1" {{ $settings['auto_backup_enabled'] ? 'checked' : '' }} class="h-4 w-4 text-sky-600">
                                <span>{{ __('messages.auto_backup') }}</span>
                            </label>
                            <div>
                                <label for="backup_retention_count" class="block text-sm font-medium text-slate-700">{{ __('messages.backups_to_keep') }}</label>
                                <input id="backup_retention_count" name="backup_retention_count" type="number" min="1" max="30" value="{{ old('backup_retention_count', $settings['backup_retention_count']) }}" class="mt-2 block w-full rounded-3xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-900 shadow-sm focus:border-sky-500 focus:ring-sky-500">
                            </div>
                        </div>

                        <button type="submit" class="inline-flex items-center justify-center rounded-3xl bg-slate-900 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800">
                            💾 {{ __('messages.save_system_settings') }}
                        </button>
                    </form>
                </section>

                <section class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm {{ $activeSection !== 'ui' ? 'hidden' : '' }}" id="section-ui">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-slate-900">{{ __('messages.ui_settings') }}</h2>
                            <p class="mt-2 text-sm text-slate-600">{{ __('messages.choose_theme_accent') }}</p>
                        </div>
                        <span class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold uppercase tracking-[0.2em] text-slate-600">{{ __('messages.appearance') }}</span>
                    </div>

                    <form action="{{ route('settings.update', ['section' => 'ui']) }}" method="POST" class="mt-6 space-y-6">
                        @csrf
                        <div class="grid gap-5 lg:grid-cols-2">
                            <div>
                                <label class="block text-sm font-medium text-slate-700">{{ __('messages.theme') }}</label>
                                <div class="mt-3 grid gap-3">
                                    @foreach(['light' => __('messages.light'), 'dark' => __('messages.dark')] as $key => $label)
                                        <label class="inline-flex items-center gap-3 rounded-3xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-700 shadow-sm">
                                            <input type="radio" name="theme" value="{{ $key }}" {{ $settings['theme'] === $key ? 'checked' : '' }} class="h-4 w-4 text-sky-600">
                                            <span>{{ $label }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            <div>
                                <label for="accent_color" class="block text-sm font-medium text-slate-700">{{ __('messages.accent_color') }}</label>
                                <select id="accent_color" name="accent_color" class="mt-2 block w-full rounded-3xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-900 shadow-sm focus:border-sky-500 focus:ring-sky-500">
                                    @foreach(['blue' => __('messages.blue'), 'green' => __('messages.green'), 'pink' => __('messages.pink')] as $value => $label)
                                        <option value="{{ $value }}" {{ $settings['accent_color'] === $value ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <button type="submit" class="inline-flex items-center justify-center rounded-3xl bg-slate-900 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800">
                            💾 {{ __('messages.save_ui_settings') }}
                        </button>
                    </form>
                </section>
            </main>
        </div>
    </div>
</div>

<script>
    function previewLogo(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('logoPreview');
        const placeholder = document.getElementById('logoPlaceholder');

        if (!file || !preview) {
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            preview.classList.remove('hidden');
            if (placeholder) {
                placeholder.classList.add('hidden');
            }
        };
        reader.readAsDataURL(file);
    }
</script>
@endsection
