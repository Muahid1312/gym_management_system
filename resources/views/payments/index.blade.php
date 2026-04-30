@extends('layouts.app')

@section('content')
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h1>Payments</h1>
            <a class="button" href="{{ route('payments.create') }}">Add Payment</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Member</th>
                    <th>Plan</th>
                    <th>Amount</th>
                    <th>Paid At</th>
                    <th>Notes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                    <tr>
                        <td>{{ $payment->member->name }}</td>
                        <td>{{ $payment->plan->name }}</td>
                        <td>{{ number_format($payment->amount, 2) }}</td>
                        <td>{{ $payment->paid_at->format('Y-m-d H:i') }}</td>
                        <td>{{ $payment->notes }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
