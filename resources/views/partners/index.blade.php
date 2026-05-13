@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h1 class="page-title">پارتنر ها</h1>
            <a class="button" href="{{ route('partners.create') }}">پارتنر جدید</a>
        </div>
    </div>

    @if($partners->count() > 0)
    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>اسم</th>
                    <th>نوع</th>
                    <th>شماره تماس</th>
                    <th>کمیشن %</th>
                    <th>مجموع درآمد</th>
                    <th>پرداخت شده</th>
                    <th>پرداخت نشده</th>
                    <th>وضعیت</th>
                    <th>اقدامات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($partners as $partner)
                <tr>
                    <td><strong>{{ $partner->name }}</strong></td>
                    <td>
                        <span style="background: rgba(234,179,8,0.2); color: var(--accent-soft); padding: 4px 10px; border-radius: 12px; font-size: 0.85rem; text-transform: capitalize;">
                            {{ $partner->type }}
                        </span>
                    </td>
                    <td>{{ $partner->phone }}</td>
                    <td>{{ number_format($partner->commission_percentage, 2) }}%</td>
                    <td>${{ number_format($partner->earnings_summary['total_earnings'], 2) }}</td>
                    <td>
                        <span style="color: #86efac;">${{ number_format($partner->earnings_summary['paid_earnings'], 2) }}</span>
                    </td>
                    <td>
                        <span style="color: #fca5a5;">${{ number_format($partner->earnings_summary['unpaid_earnings'], 2) }}</span>
                    </td>
                    <td>
                        @if($partner->is_active)
                            <span style="color: #86efac;">فعال</span>
                        @else
                            <span style="color: #fca5a5;">غیرفعال</span>
                        @endif
                    </td>
                    <td>
                        <div class="button-group" style="gap: 8px;">
                            <a href="{{ route('partners.show', $partner) }}" class="button" style="padding: 8px 12px; font-size: 0.9rem;">دیدن</a>
                            <a href="{{ route('partners.edit', $partner) }}" class="button" style="padding: 8px 12px; font-size: 0.9rem;">ویرایش</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div style="display: flex; justify-content: center; gap: 10px; margin-top: 20px;">
        {{ $partners->links() }}
    </div>
    @else
    <div class="card">
        <p style="text-align: center; color: var(--muted);">پارتنری یافت نشد! <a href="{{ route('partners.create') }}" class="button">Create one</a></p>
    </div>
    @endif
</div>
@endsection
