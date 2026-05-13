@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h1 class="page-title">بل رسید ها</h1>
            <a class="button" href="{{ route('payments.index') }}">Back to Payments</a>
        </div>
    </div>

    @if($receipts->count() > 0)
    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>بل رسیدی #</th>
                    <th>عضو</th>
                    <th>مقدار پرداخت</th>
                    <th>حساب باقی مانده</th>
                    <th>روش پرداخت</th>
                    <th>زمان</th>
                    <th>عملکرد ها</th>
                </tr>
            </thead>
            <tbody>
                @foreach($receipts as $receipt)
                <tr>
                    <td><strong>{{ $receipt->receipt_number }}</strong></td>
                    <td>{{ $receipt->member->name }}</td>
                    <td>${{ number_format($receipt->amount_paid, 2) }}</td>
                    <td>
                        @if($receipt->remaining_balance > 0)
                            <span style="color: #fca5a5;">${{ number_format($receipt->remaining_balance, 2) }}</span>
                        @else
                            <span style="color: #86efac;">پرداخت شده</span>
                        @endif
                    </td>
                    <td style="text-transform: capitalize;">{{ $receipt->payment_method }}</td>
                    <td>{{ $receipt->created_at->format('M d, Y') }}</td>
                    <td>
                        <div class="button-group" style="gap: 8px;">
                            <a href="{{ route('receipts.show', $receipt) }}" class="button" style="padding: 8px 12px; font-size: 0.9rem;">دیدن</a>
                            <a href="{{ route('receipts.download', $receipt) }}" class="button" style="padding: 8px 12px; font-size: 0.9rem;">دانلود</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div style="display: flex; justify-content: center; gap: 10px; margin-top: 20px;">
        {{ $receipts->links() }}
    </div>
    @else
    <div class="card">
        <p style="text-align: center; color: var(--muted);">بل رسیدی یافت نشد.</p>
    </div>
    @endif
</div>
@endsection
