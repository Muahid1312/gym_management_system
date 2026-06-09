@extends('layouts.app-modern')

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
            @include('payments._form', [
                'action' => route('payments.store'),
                'method' => 'POST',
                'payment' => null,
                'members' => $members,
                'plans' => $plans,
                'partners' => $partners ?? [],
            ])
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
