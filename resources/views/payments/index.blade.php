@extends('layouts.app')

@section('title', 'Payments')

@section('content')
<div class="page-header">
    <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
        <div>
            <h1 class="page-title">ذخیره پرداخت</h1>
            <p class="page-subtitle">پروسه پرداخت های اعضا به طور خودکار در رسید و بدهی آنها به روز می شوند</p>
        </div>
        <div class="flex flex-wrap gap-3">
            <x-button href="{{ route('receipts.index') }}" variant="secondary">📄 دیدن بل رسید</x-button>
            <x-button href="{{ route('payments.create') }}" variant="primary">➕ ذخیره بل رسید</x-button>
        </div>
    </div>
</div>

<div class="overflow-x-auto rounded-3xl border border-slate-700 bg-slate-900/80 shadow-lg shadow-slate-900/10">
    <table class="min-w-full divide-y divide-slate-700 text-sm">
        <thead class="bg-slate-950 text-slate-400">
            <tr>
                <th class="px-4 py-3 text-left uppercase tracking-[0.18em] text-xs font-semibold">عضو</th>
                <th class="px-4 py-3 text-left uppercase tracking-[0.18em] text-xs font-semibold">پلان</th>
                <th class="px-4 py-3 text-left uppercase tracking-[0.18em] text-xs font-semibold">مقدار</th>
                <th class="px-4 py-3 text-left uppercase tracking-[0.18em] text-xs font-semibold">پارتنر</th>
                <th class="px-4 py-3 text-left uppercase tracking-[0.18em] text-xs font-semibold"> روش پرداخت</th>
                <th class="px-4 py-3 text-left uppercase tracking-[0.18em] text-xs font-semibold">پرداخت شده در</th>
                <th class="px-4 py-3 text-left uppercase tracking-[0.18em] text-xs font-semibold">یادداشت ها</th>
                <th class="px-4 py-3 text-right uppercase tracking-[0.18em] text-xs font-semibold">عملکرد ها</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-800 bg-slate-950">
            @foreach($payments as $payment)
                <tr class="group hover:bg-slate-900/70 transition">
                    <td class="px-4 py-4 text-slate-300 font-semibold">{{ $payment->member->name }}</td>
                    <td class="px-4 py-4 text-slate-300">{{ $payment->plan->name }}</td>
                    <td class="px-4 py-4 text-emerald-400 font-semibold">${{ number_format($payment->amount, 2) }}</td>
                    <td class="px-4 py-4 text-slate-300">
                        @if($payment->partner)
                            <a href="{{ route('partners.show', $payment->partner) }}" class="text-blue-400 hover:text-blue-300 transition">
                                {{ $payment->partner->name }}
                            </a>
                        @else
                            <span class="text-slate-500">-</span>
                        @endif
                    </td>
                    <td class="px-4 py-4 text-slate-300">
                        <span class="inline-flex items-center rounded-full bg-slate-800 px-3 py-1 text-xs font-semibold {{ $payment->payment_method === 'cash' ? 'text-amber-300' : 'text-blue-300' }}">
                            {{ ucfirst($payment->payment_method) }}
                        </span>
                    </td>
                    <td class="px-4 py-4 text-slate-300">{{ $payment->paid_at->format('Y-m-d H:i') }}</td>
                    <td class="px-4 py-4 text-slate-400 max-w-xs truncate">{{ $payment->notes ?: '-' }}</td>
                    <td class="px-4 py-4 text-right">
                        @if($payment->receipt)
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('receipts.show', $payment->receipt) }}" class="inline-flex items-center gap-1 rounded-lg bg-blue-600 px-3 py-2 text-xs font-semibold text-white hover:bg-blue-700 transition">
                                    📋 دیدن
                                </a>
                                <a href="{{ route('receipts.download', $payment->receipt) }}" class="inline-flex items-center gap-1 rounded-lg bg-slate-700 px-3 py-2 text-xs font-semibold text-slate-100 hover:bg-slate-600 transition">
                                    ⬇️ دانلود
                                </a>
                            </div>
                        @else
                            <span class="text-slate-500 text-xs">بل رسیدی موجود نیست</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
