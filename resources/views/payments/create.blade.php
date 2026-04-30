@extends('layouts.app')

@section('content')
    <div class="card hero">
        <div>
            <h1 class="page-title">Record Payment</h1>
            <p class="subtitle">Add a payment for a member and track partial or full balance payments.</p>
        </div>
    </div>

    <div class="card">
        <form action="{{ route('payments.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="member_id">Member</label>
                <select id="member_id" name="member_id" required>
                    <option value="">Select member</option>
                    @foreach($members as $member)
                        <option value="{{ $member->id }}" {{ old('member_id') == $member->id ? 'selected' : '' }}>
                            {{ $member->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="plan_id">Plan</label>
                <select id="plan_id" name="plan_id" required>
                    <option value="">Select plan</option>
                    @foreach($plans as $plan)
                        <option value="{{ $plan->id }}" {{ old('plan_id') == $plan->id ? 'selected' : '' }}>
                            {{ $plan->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="amount">Amount</label>
                <input id="amount" name="amount" type="number" step="0.01" value="{{ old('amount') }}" required>
            </div>
            <div class="form-group">
                <label for="paid_at">Paid At</label>
                <input id="paid_at" name="paid_at" type="datetime-local" value="{{ old('paid_at', now()->format('Y-m-d\TH:i')) }}" required>
            </div>
            <div class="form-group">
                <label for="is_partial">
                    <input id="is_partial" name="is_partial" type="checkbox" value="1" {{ old('is_partial') ? 'checked' : '' }}>
                    Partial Payment
                </label>
            </div>
            <div class="form-group">
                <label for="notes">Notes</label>
                <textarea id="notes" name="notes">{{ old('notes') }}</textarea>
            </div>
            <button class="button" type="submit">Record Payment</button>
        </form>
    </div>
@endsection
