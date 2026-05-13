@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h1 class="page-title">Receipt Details</h1>
            <div class="button-group">
                <a href="{{ route('receipts.index') }}" class="button">Back</a>
                <a href="{{ route('receipts.print', $receipt) }}" class="button" target="_blank">🖨️ Print</a>
                <a href="{{ route('receipts.download', $receipt) }}" class="button">Download PDF</a>
            </div>
        </div>
    </div>

    <div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));">
        <div class="stat-card">
            <h3>Receipt Number</h3>
            <p style="font-size: 1.3rem;">{{ $receipt->receipt_number }}</p>
        </div>
        <div class="stat-card">
            <h3>Amount Paid</h3>
            <p style="font-size: 1.3rem; color: #86efac;">${{ number_format($receipt->amount_paid, 2) }}</p>
        </div>
        <div class="stat-card">
            <h3>Remaining Balance</h3>
            <p style="font-size: 1.3rem; color: @if($receipt->remaining_balance > 0)#fca5a5 @else #86efac @endif;">
                ${{ number_format($receipt->remaining_balance, 2) }}
            </p>
        </div>
        <div class="stat-card">
            <h3>Payment Method</h3>
            <p style="font-size: 1.3rem; text-transform: capitalize;">{{ $receipt->payment_method }}</p>
        </div>
    </div>

    <div class="card">
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px;">
            <!-- Member Information -->
            <div>
                <h3 style="color: var(--accent); margin-top: 0;">Member Information</h3>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <div>
                        <span style="color: var(--muted); font-size: 0.9rem;">Name</span>
                        <p style="margin: 6px 0 0; font-weight: 600;">{{ $receipt->member->name }}</p>
                    </div>
                    <div>
                        <span style="color: var(--muted); font-size: 0.9rem;">Email</span>
                        <p style="margin: 6px 0 0; font-weight: 600;">{{ $receipt->member->email }}</p>
                    </div>
                    <div>
                        <span style="color: var(--muted); font-size: 0.9rem;">Phone</span>
                        <p style="margin: 6px 0 0; font-weight: 600;">{{ $receipt->member->phone }}</p>
                    </div>
                    <div>
                        <span style="color: var(--muted); font-size: 0.9rem;">Membership Plan</span>
                        <p style="margin: 6px 0 0; font-weight: 600;">{{ $receipt->payment->plan->name }}</p>
                    </div>
                </div>
            </div>

            <!-- Payment Information -->
            <div>
                <h3 style="color: var(--accent); margin-top: 0;">Payment Information</h3>
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    <div>
                        <span style="color: var(--muted); font-size: 0.9rem;">Date & Time</span>
                        <p style="margin: 6px 0 0; font-weight: 600;">{{ $receipt->created_at->format('M d, Y H:i A') }}</p>
                    </div>
                    <div>
                        <span style="color: var(--muted); font-size: 0.9rem;">Payment Method</span>
                        <p style="margin: 6px 0 0; font-weight: 600; text-transform: capitalize;">{{ $receipt->payment_method }}</p>
                    </div>
                    <div>
                        <span style="color: var(--muted); font-size: 0.9rem;">Amount Paid</span>
                        <p style="margin: 6px 0 0; font-weight: 600; color: #86efac; font-size: 1.1rem;">${{ number_format($receipt->amount_paid, 2) }}</p>
                    </div>
                    @if($receipt->notes)
                    <div>
                        <span style="color: var(--muted); font-size: 0.9rem;">Notes</span>
                        <p style="margin: 6px 0 0; font-weight: 600;">{{ $receipt->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($receipt->remaining_balance > 0)
    <div class="alert">
        <strong>Outstanding Balance:</strong> This member has a remaining balance of ${{ number_format($receipt->remaining_balance, 2) }}.
    </div>
    @else
    <div class="alert-success">
        <strong>✓ Paid in Full:</strong> This member has no outstanding balance.
    </div>
    @endif
</div>
@endsection
