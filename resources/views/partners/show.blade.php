@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h1 class="page-title">{{ $partner->name }}</h1>
            <div class="button-group">
                <a href="{{ route('partners.index') }}" class="button">قبلی</a>
                <a href="{{ route('partners.earningsReport', $partner) }}" class="button">گزارش درآمد</a>
                <a href="{{ route('partners.edit', $partner) }}" class="button">ویرایش</a>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="grid">
        <div class="stat-card">
            <h3>مجموع درآمد</h3>
            <p style="font-size: 1.3rem; color: #86efac;">${{ number_format($earningsSummary['total_earnings'], 2) }}</p>
        </div>
        <div class="stat-card">
            <h3>پرداخت شده</h3>
            <p style="font-size: 1.3rem; color: #86efac;">${{ number_format($earningsSummary['paid_earnings'], 2) }}</p>
        </div>
        <div class="stat-card">
            <h3>پرداخت نشده</h3>
            <p style="font-size: 1.3rem; color: #fca5a5;">${{ number_format($earningsSummary['unpaid_earnings'], 2) }}</p>
        </div>
        <div class="stat-card">
            <h3>مجموع کمیشن</h3>
            <p style="font-size: 1.3rem;">{{ $earningsSummary['total_commissions'] }}</p>
        </div>
    </div>

    <!-- Partner Information -->
    <div class="card">
        <h3 style="color: var(--accent); margin-top: 0;">اطلاعات پارتنر</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px;">
            <div>
                <span style="color: var(--muted); font-size: 0.9rem;">اسم</span>
                <p style="margin: 6px 0 0; font-weight: 600;">{{ $partner->name }}</p>
            </div>
            <div>
                <span style="color: var(--muted); font-size: 0.9rem;">شماره تماس</span>
                <p style="margin: 6px 0 0; font-weight: 600;">{{ $partner->phone }}</p>
            </div>
            <div>
                <span style="color: var(--muted); font-size: 0.9rem;">نوع</span>
                <p style="margin: 6px 0 0; font-weight: 600; text-transform: capitalize;">{{ $partner->type }}</p>
            </div>
            <div>
                <span style="color: var(--muted); font-size: 0.9rem;">فیصدی کمیشن %</span>
                <p style="margin: 6px 0 0; font-weight: 600;">{{ number_format($partner->commission_percentage, 2) }}%</p>
            </div>
            <div>
                <span style="color: var(--muted); font-size: 0.9rem;">وضیعت</span>
                <p style="margin: 6px 0 0; font-weight: 600;">
                    @if($partner->is_active)
                        <span style="color: #86efac;">فعال</span>
                    @else
                        <span style="color: #fca5a5;">غیر قعال</span>
                    @endif
                </p>
            </div>
            <div>
                <span style="color: var(--muted); font-size: 0.9rem;">عضو معرفی شده</span>
                <p style="margin: 6px 0 0; font-weight: 600;">{{ $partner->members->count() }}</p>
            </div>
        </div>
    </div>

    <!-- Recent Commissions -->
    <div class="card">
        <h3 style="color: var(--accent); margin-top: 0;">کمیشن اخیر</h3>
        @if($commissions->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>عضو</th>
                    <th>مقدار پرداخت</th>
                    <th>کمیشن %</th>
                    <th>مقدار کمیشن</th>
                    <th>وضعیت</th>
                    <th>تاریخ</th>
                </tr>
            </thead>
            <tbody>
                @foreach($commissions as $commission)
                <tr>
                    <td>{{ $commission->member->name }}</td>
                    <td>${{ number_format($commission->payment->amount, 2) }}</td>
                    <td>{{ number_format($commission->commission_percentage, 2) }}%</td>
                    <td>${{ number_format($commission->commission_amount, 2) }}</td>
                    <td>
                        @if($commission->is_paid)
                            <span style="color: #86efac;">پرداخت شده</span>
                        @else
                            <span style="color: #fca5a5;">در انتظار</span>
                        @endif
                    </td>
                    <td>{{ $commission->created_at->format('M d, Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @else
        <p style="color: var(--muted); text-align: center;">هنوز کمیشنی ثبت نشده است.</p>
        @endif
    </div>
</div>
@endsection
