@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h1 class="page-title">{{ $partner->name }} - گزارش درآمد</h1>
            <div class="button-group">
                <a href="{{ route('partners.show', $partner) }}" class="button">Back</a>
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
            <h3>فیصدی کمیشن</h3>
            <p style="font-size: 1.3rem;">{{ number_format($partner->commission_percentage, 2) }}%</p>
        </div>
    </div>

    <!-- Commission Breakdown -->
    <div class="grid">
        <div class="stat-card">
            <h3>مجموع کمیشن</h3>
            <p style="font-size: 1.3rem;">{{ $earningsSummary['total_commissions'] }}</p>
        </div>
        <div class="stat-card">
            <h3>کمیشن پرداخت شده</h3>
            <p style="font-size: 1.3rem; color: #86efac;">{{ $earningsSummary['paid_commissions'] }}</p>
        </div>
        <div class="stat-card">
            <h3>کمیشن در انتظار</h3>
            <p style="font-size: 1.3rem; color: #fca5a5;">{{ $earningsSummary['unpaid_commissions'] }}</p>
        </div>
        <div class="stat-card">
            <h3>ایجاد شده در</h3>
            <p style="font-size: 0.9rem;">{{ now()->format('M d, Y H:i A') }}</p>
        </div>
    </div>

    <!-- Detailed Commission List -->
    <div class="card">
        <h3 style="color: var(--accent); margin-top: 0;">تفصیلات کمیشن</h3>

        @if($commissions->count() > 0)
        <form action="{{ route('partners.markCommissionsPaid', $partner) }}" method="POST" id="commissionForm">
            @csrf
            <div style="overflow-x: auto;">
                <table>
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="selectAll" onchange="toggleAll(this)">
                            </th>
                            <th>عضو</th>
                            <th>مقدار پرداخت</th>
                            <th>کمیشن %</th>
                            <th>مقدار کمیشن</th>
                            <th>وضیعت</th>
                            <th>تاریخ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($commissions as $commission)
                        <tr>
                            <td>
                                @if(!$commission->پرداخت شد)
                                <input type="checkbox" name="commission_ids[]" value="{{ $commission->id }}" class="commissionCheckbox">
                                @endif
                            </td>
                            <td>{{ $commission->member->name }}</td>
                            <td>${{ number_format($commission->payment->amount, 2) }}</td>
                            <td>{{ number_format($commission->commission_percentage, 2) }}%</td>
                            <td>${{ number_format($commission->commission_amount, 2) }}</td>
                            <td>
                                @if($commission->is_paid)
                                    <span style="color: #86efac;">پرداخت شده</span>
                                @else
                                    <span style="color: #fca5a5;">در حال انتظار</span>
                                @endif
                            </td>
                            <td>{{ $commission->created_at->format('M d, Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($earningsSummary['کمیشن پرداخت نشده'] > 0)
            <div class="button-group" style="margin-top: 18px;">
                <button type="submit" class="button">انتخاب شده را علامت پرداخت بزنید!</button>
            </div>
            @endif
        </form>

        <!-- Pagination -->
        <div style="display: flex; justify-content: center; gap: 10px; margin-top: 20px;">
            {{ $commissions->links() }}
        </div>
        @else
        <p style="color: var(--muted); text-align: center;">کمیسشنی ذخیره نشده!</p>
        @endif
    </div>
</div>

<script>
function toggleAll(checkbox) {
    const checkboxes = document.querySelectorAll('.commissionCheckbox');
    checkboxes.forEach(cb => cb.checked = checkbox.checked);
}
</script>
@endsection
