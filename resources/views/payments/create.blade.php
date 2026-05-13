@extends('layouts.app')

@section('title', 'Record Payment')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">ذخیره پرداخت</h1>
        <p class="page-subtitle">پروسه پرداخت های اعضا به طور خودکار در رسید و بدهی آنها به روز می شوند</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <x-card class="bg-slate-950 border-slate-700">
            <form action="{{ route('payments.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="member_id" class="block text-gray-400 font-semibold mb-2">انتخاب  عضو</label>
                    <select id="member_id" name="member_id" required class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                        <option value="">انتخاب عضو...</option>
                        @foreach($members as $member)
                            <option value="{{ $member->id }}" {{ (is_array(old('member_id')) ? false : old('member_id')) == $member->id ? 'selected' : '' }}>
                                {{ $member->name }} ({{ $member->phone ?? 'N/A' }})
                            </option>
                        @endforeach
                    </select>
                    @error('member_id')
                        <p class="text-rose-400 text-sm mt-1">{{ is_array($message) ? implode(', ', $message) : $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="plan_id" class="block text-gray-400 font-semibold mb-2">انتخاب پلان</label>
                    <select id="plan_id" name="plan_id" required class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                        <option value="">انتخاب پلان...</option>
                        @foreach($plans as $plan)
                            <option value="{{ $plan->id }}" {{ (is_array(old('plan_id')) ? false : old('plan_id')) == $plan->id ? 'selected' : '' }}>
                                {{ $plan->name }} - ${{ number_format($plan->price, 2) }}
                            </option>
                        @endforeach
                    </select>
                    @error('plan_id')
                        <p class="text-rose-400 text-sm mt-1">{{ is_array($message) ? implode(', ', $message) : $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="amount" class="block text-gray-400 font-semibold mb-2">مقدار ($)</label>
                        <input id="amount" name="amount" type="number" step="0.01" value="{{ is_array(old('amount')) ? '' : old('amount') }}" required class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500" placeholder="0.00" />
                        @error('amount')
                            <p class="text-rose-400 text-sm mt-1">{{ is_array($message) ? implode(', ', $message) : $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="payment_method" class="block text-gray-400 font-semibold mb-2">روش پرداخت</label>
                        <select id="payment_method" name="payment_method" required class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                            <option value="cash" {{ (is_array(old('payment_method')) ? 'cash' : (old('payment_method') ?: 'cash')) == 'cash' ? 'selected' : '' }}>💵 نقد</option>
                            <option value="online" {{ (is_array(old('payment_method')) ? false : old('payment_method')) == 'online' ? 'selected' : '' }}>💳 آنلاین</option>
                        </select>
                        @error('payment_method')
                            <p class="text-rose-400 text-sm mt-1">{{ is_array($message) ? implode(', ', $message) : $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="paid_at" class="block text-gray-400 font-semibold mb-2">تاریخ و ساعت پرداخت</label>
                    <input id="paid_at" name="paid_at" type="datetime-local" value="{{ is_array(old('paid_at')) ? now()->format('Y-m-d\TH:i') : (old('paid_at') ?: now()->format('Y-m-d\TH:i')) }}" required class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500" />
                    @error('paid_at')
                        <p class="text-rose-400 text-sm mt-1">{{ is_array($message) ? implode(', ', $message) : $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="partner_id" class="block text-gray-400 font-semibold mb-2">شریک (اختیاری)</label>
                    <select id="partner_id" name="partner_id" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                        <option value="">-- بدون کمیسشن پارتنرک --</option>
                        @foreach($partners ?? [] as $partner)
                            <option value="{{ $partner->id }}" {{ (is_array(old('partner_id')) ? false : old('partner_id')) == $partner->id ? 'selected' : '' }}>
                                {{ $partner->name }} ({{ number_format($partner->commission_percentage, 2) }}%)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="notes" class="block text-gray-400 font-semibold mb-2">یاداشت برای پرداخت</label>
                    <textarea id="notes" name="notes" rows="3" class="w-full rounded-xl border border-slate-700 bg-slate-950 px-4 py-3 text-white shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-500" placeholder="یادداشت  برای این پرداخت اضافه کنید!">{{ is_array(old('notes')) ? '' : old('notes') }}</textarea>
                </div>

                <div class="flex items-center gap-3">
                    <input id="is_partial" name="is_partial" type="checkbox" value="1" {{ (old('is_partial') && !is_array(old('is_partial'))) ? 'checked' : '' }} class="h-4 w-4 rounded border-slate-700 bg-slate-950 text-blue-600 transition focus:ring-2 focus:ring-blue-500" />
                    <label for="is_partial" class="text-gray-400 font-semibold cursor-pointer">علامت گذاری به عنوان پرداخت جزئی</label>
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="submit" class="flex-1 rounded-xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-blue-700">💾 ذخیره پرداخت</button>
                    <a href="{{ route('payments.index') }}" class="flex-1 rounded-xl bg-slate-700 px-6 py-3 text-center text-sm font-semibold text-white transition hover:bg-slate-600">Cancel</a>
                </div>
            </form>
        </x-card>
    </div>

    <div class="lg:col-span-1">
        <x-card class="bg-slate-950 border-slate-700 sticky top-4">
            <div class="space-y-4">
                <div>
                    <p class="text-sm uppercase tracking-[0.18em] text-blue-400 font-semibold">زمان</p>
                    <h3 id="afghanistan-time" class="text-4xl font-bold text-white mt-2">--:--:--</h3>
                    <p id="afghanistan-date" class="text-sm text-slate-400 mt-1">Loading date…</p>
                </div>

                <div class="border-t border-slate-700 pt-4">
                    <p class="text-xs uppercase tracking-[0.18em] text-slate-500 font-semibold mb-2">نکات کلیدی</p>
                    <ul class="space-y-2 text-sm text-slate-400">
                        <li class="flex gap-2">
                            <span>✓</span>
                            <span>پرداخت ها  بدهی اعضا را به طور خودکار به روز می کنند</span>
                        </li>
                        <li class="flex gap-2">
                            <span>✓</span>
                            <span>از پرداخت قسطی استفاده کنید</span>
                        </li>
                        <li class="flex gap-2">
                            <span>✓</span>
                            <span>کمیسشن شریک به طور خودکار محاسبه می‌شود</span>
                        </li>
                        <li class="flex gap-2">
                            <span>✓</span>
                            <span>بل رسید برای تمام پرداخت ها ساخته میشود</span>
                        </li>
                    </ul>
                </div>
            </div>
        </x-card>
    </div>
</div>

<script>
    function updateAfghanistanTime() {
        const timeOptions = {
            timeZone: 'Asia/Kabul',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: false,
        };
        const dateOptions = {
            timeZone: 'Asia/Kabul',
            weekday: 'short',
            year: 'numeric',
            month: 'short',
            day: 'numeric',
        };

        const now = new Date();
        const timeElement = document.getElementById('afghanistan-time');
        const dateElement = document.getElementById('afghanistan-date');

        if (timeElement && dateElement) {
            timeElement.textContent = now.toLocaleTimeString('en-GB', timeOptions);
            dateElement.textContent = now.toLocaleDateString('en-GB', dateOptions);
        }
    }

    updateAfghanistanTime();
    setInterval(updateAfghanistanTime, 1000);
</script>
@endsection
