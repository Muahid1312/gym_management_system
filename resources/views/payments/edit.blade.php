@extends('layouts.app-modern')

@section('title', 'Edit Payment')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">ویرایش پرداخت</h1>
        <p class="page-subtitle">به‌روزرسانی جزئیات پرداخت</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
        <x-card class="bg-slate-950 border-slate-700">
            @include('payments._form', [
                'action' => route('payments.update', $payment),
                'method' => 'PUT',
                'payment' => $payment,
                'members' => $members,
                'plans' => $plans,
                'partners' => $partners ?? [],
            ])
        </x-card>
    </div>

    <div class="lg:col-span-1">
        <x-card class="bg-slate-950 border-slate-700 sticky top-4">
            <p class="text-sm text-slate-400">توجه: تغییرات بر پرداخت ثبت‌شده اعمال می‌شود.</p>
        </x-card>
    </div>
</div>

@endsection
