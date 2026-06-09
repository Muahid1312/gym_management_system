@extends('layouts.app')

@section('title', 'Payment Details')

@section('content')
<div class="page-header">
    <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
        <div>
            <h1 class="page-title">جزئیات پرداخت</h1>
            <p class="page-subtitle">جزئیات و تاریخچه پرداخت</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('payments.edit', $payment) }}" class="button">ویرایش</a>
            <a href="{{ route('payments.index') }}" class="button button-secondary">بازگشت</a>
        </div>
    </div>
</div>

<x-card class="mt-6">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <p class="text-sm text-slate-500">عضو</p>
            <h3 class="text-lg font-semibold text-slate-900">{{ $payment->member->name }}</h3>
            <p class="text-sm text-slate-500">پلان: {{ $payment->plan->name }}</p>
            <p class="text-sm text-slate-500">پارتنر: {{ $payment->partner?->name ?? '-' }}</p>
        </div>

        <div>
            <p class="text-sm text-slate-500">مقدار</p>
            <h3 class="text-lg font-semibold text-emerald-500">${{ number_format($payment->amount, 2) }}</h3>
            <p class="text-sm text-slate-500">روش پرداخت: {{ ucfirst($payment->payment_method) }}</p>
            <p class="text-sm text-slate-500">تاریخ پرداخت: {{ $payment->paid_at->format('Y-m-d H:i') }}</p>
        </div>
    </div>

    <div class="mt-6">
        <h4 class="text-sm text-slate-500">یادداشت ها</h4>
        <p class="text-sm text-slate-700 mt-2">{{ $payment->notes ?: '-' }}</p>
    </div>
</x-card>

@endsection
