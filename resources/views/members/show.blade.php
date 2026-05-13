@extends('layouts.app')

@section('title', $member->name)

@section('content')
<div class="page-header">
    <h1 class="page-title">{{ $member->name }}</h1>
    <p class="page-subtitle">
        @if($member->expiry_date && $member->expiry_date->isFuture())
            Active • Expires {{ $member->expiry_date->format('M d, Y') }}
        @else
            Expired
        @endif
    </p>
</div>

<div class="button-group" style="margin-bottom: 2rem;">
    <a href="{{ route('members.index') }}" class="button button-outline">← Back to Members</a>
    <a href="{{ route('members.edit', $member) }}" class="button">Edit Member</a>
    <form action="{{ route('members.destroy', $member) }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="button" style="background-color: var(--danger); border-color: var(--danger);" onclick="return confirm('Are you sure you want to delete this member?');">Delete Member</button>
    </form>
</div>

@if($isAtRisk)
    <div class="card" style="border-color: var(--danger); background-color: rgba(239, 68, 68, 0.1);">
        <div class="card-body">
            <div style="display: flex; gap: 1rem;">
                <div style="flex-shrink: 0; width: 3rem; height: 3rem; border-radius: 0.5rem; background-color: var(--danger); color: white; display: flex; align-items: center; justify-content: center;">
                    ⚠️
                </div>
                <div>
                    <h2 style="margin: 0 0 0.5rem 0; font-size: 1.125rem; font-weight: 600; color: var(--danger);">This member is at risk</h2>
                    <p style="margin: 0 0 1rem 0; color: var(--text-muted);">Review the member's account and follow up before the next billing cycle.</p>
                    <ul style="margin: 0; padding-left: 1.5rem; list-style-type: disc; color: var(--text-muted);">
                        @if($daysUntilExpiry !== null && $daysUntilExpiry <= 3)
                            <li>Membership expires in {{ max(0, $daysUntilExpiry) }} day(s).</li>
                        @endif
                        @if($member->debt > 0)
                            <li>Outstanding debt: AF {{ number_format($member->debt, 2) }}.</li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endif

<div style="display: grid; grid-template-columns: 1fr; gap: 1.5rem;" class="lg:grid-cols-3">
    <div style="grid-column: span 2;" class="space-y-6">
        <div class="card">
            <div class="card-body">
                <div style="display: flex; gap: 1.5rem; align-items: center; justify-content: space-between; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 1rem;">
                        @if($member->photo)
                            <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}" style="width: 6rem; height: 6rem; border-radius: 50%; object-fit: cover;" />
                        @else
                            <div style="width: 6rem; height: 6rem; border-radius: 50%; background-color: var(--primary); color: white; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.875rem;">
                                {{ strtoupper(substr($member->name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <p style="margin: 0 0 0.25rem 0; color: var(--text-muted); font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em;">Member Profile</p>
                            <h2 style="margin: 0 0 0.5rem 0; font-size: 1.875rem; font-weight: 600;">{{ $member->name }}</h2>
                            <p style="margin: 0; color: var(--text-muted);">Joined on {{ $member->join_date->format('M d, Y') }}</p>
                        </div>
                    </div>
                    <div style="display: grid; gap: 0.75rem; grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));">
                        <div style="background-color: var(--surface-soft); padding: 1rem; border-radius: 0.5rem;">
                            <p style="margin: 0 0 0.5rem 0; color: var(--text-muted); font-size: 0.875rem;">Current Plan</p>
                            <p style="margin: 0; font-size: 1.25rem; font-weight: 600;">{{ $member->plan->name ?? 'N/A' }}</p>
                        </div>
                        <div style="background-color: var(--surface-soft); padding: 1rem; border-radius: 0.5rem;">
                            <p style="margin: 0 0 0.5rem 0; color: var(--text-muted); font-size: 0.875rem;">Membership Status</p>
                            <p style="margin: 0; font-size: 1.25rem; font-weight: 600; color: {{ $member->expiry_date && $member->expiry_date->isFuture() ? 'var(--success)' : 'var(--danger)' }};">
                                {{ $member->expiry_date && $member->expiry_date->isFuture() ? 'Active' : 'Expired' }}
                            </p>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 2rem; display: grid; gap: 1.5rem; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));">
                    <div style="background-color: var(--surface-soft); padding: 1rem; border-radius: 0.5rem;">
                        <p style="margin: 0 0 1rem 0; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em;">Expiry Date</p>
                        <p style="margin: 0; font-size: 1.125rem; font-weight: 600;">{{ $member->expiry_date?->format('M d, Y') ?? 'N/A' }}</p>
                    </div>
                    <div style="background-color: var(--surface-soft); padding: 1rem; border-radius: 0.5rem;">
                        <p style="margin: 0 0 1rem 0; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em;">Debt</p>
                        <p style="margin: 0; font-size: 1.125rem; font-weight: 600; color: {{ $member->debt > 0 ? 'var(--danger)' : 'var(--success)' }};">AF {{ number_format($member->debt, 2) }}</p>
                    </div>
                    <div style="background-color: var(--surface-soft); padding: 1rem; border-radius: 0.5rem;">
                        <p style="margin: 0 0 1rem 0; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em;">Workout Level</p>
                        <p style="margin: 0; font-size: 1.125rem; font-weight: 600; text-transform: capitalize;">{{ is_array($member->workout_level) ? implode(', ', $member->workout_level) : $member->workout_level }}</p>
                    </div>
                    <div style="background-color: var(--surface-soft); padding: 1rem; border-radius: 0.5rem;">
                        <p style="margin: 0 0 1rem 0; color: var(--text-muted); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.1em;">Diet Level</p>
                        <p style="margin: 0; font-size: 1.125rem; font-weight: 600; text-transform: capitalize;">{{ is_array($member->diet_level) ? implode(', ', $member->diet_level) : $member->diet_level }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Payment History</h2>
            </div>
            <div class="card-body">
                @if($member->payments->isNotEmpty())
                    <table>
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Plan</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($member->payments->sortByDesc('paid_at') as $payment)
                                <tr>
                                    <td>{{ $payment->paid_at->format('M d, Y') }}</td>
                                    <td>{{ $payment->plan->name ?? 'N/A' }}</td>
                                    <td style="font-weight: 600;">AF {{ number_format($payment->amount, 2) }}</td>
                                    <td>
                                        <span style="background-color: {{ $payment->is_partial ? 'var(--warning)' : 'var(--success)' }}; color: white; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600;">
                                            {{ $payment->is_partial ? 'Partial' : 'Complete' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p style="color: var(--text-muted);">No payment history found.</p>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Recent Attendance</h2>
            </div>
            <div class="card-body">
                @if($member->attendances->isNotEmpty())
                    <div style="display: grid; gap: 0.75rem;">
                        @foreach($member->attendances->sortByDesc('check_in_time')->take(10) as $attendance)
                            <div style="background-color: var(--surface-soft); padding: 1rem; border-radius: 0.75rem;">
                                <div style="display: flex; justify-content: space-between; align-items: center; gap: 1rem;">
                                    <div>
                                        <p style="margin: 0 0 0.25rem 0; font-weight: 600;">{{ $attendance->check_in_time->format('M d, Y') }}</p>
                                        <p style="margin: 0; color: var(--text-muted); font-size: 0.875rem;">{{ $attendance->check_in_time->format('h:i A') }}</p>
                                    </div>
                                    <span style="background-color: var(--success); color: white; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 600;">Checked In</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p style="color: var(--text-muted);">No attendance records found.</p>
                @endif
            </div>
        </div>
    </div>

    <aside style="display: grid; gap: 1.5rem;">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Membership Status</h2>
            </div>
            <div class="card-body">
                <div style="display: grid; gap: 1rem;">
                    <div>
                        <p style="margin: 0 0 0.5rem 0; color: var(--text-muted); font-size: 0.875rem;">Status</p>
                        <p style="margin: 0; font-weight: 600;">{{ $member->expiry_date && $member->expiry_date->isFuture() ? 'Active' : 'Expired' }}</p>
                    </div>
                    @if($daysUntilExpiry !== null)
                        <div>
                            <p style="margin: 0 0 0.5rem 0; color: var(--text-muted); font-size: 0.875rem;">Days Until Expiry</p>
                            <p style="margin: 0; font-size: 1.5rem; font-weight: 600;">{{ max(0, $daysUntilExpiry) }}</p>
                        </div>
                    @endif
                    <div>
                        <p style="margin: 0 0 0.5rem 0; color: var(--text-muted); font-size: 0.875rem;">Expiry Date</p>
                        <p style="margin: 0; font-weight: 600;">{{ $member->expiry_date?->format('M d, Y') ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Locker Assignment</h2>
            </div>
            <div class="card-body">
                @if($member->lockerAssignment)
                    <p style="margin: 0 0 0.75rem 0; color: var(--text-muted);">Assigned locker</p>
                    <p style="margin: 0 0 0.5rem 0; font-size: 1.25rem; font-weight: 700;">{{ $member->lockerAssignment->locker->locker_number }}</p>
                    <p style="margin: 0 0 0.75rem 0; color: var(--text-muted);">Expires at {{ $member->lockerAssignment->expiry_date?->format('M d, Y') ?? 'No expiry' }}</p>
                    <span style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 0.75rem; border-radius: 9999px; background: rgba(239, 68, 68, 0.08); color: var(--danger); font-weight: 600;">Occupied</span>
                @else
                    <p style="margin: 0; color: var(--text-muted);">No active locker assigned. Use the locker grid to assign a locker.</p>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Debt Status</h2>
            </div>
            <div class="card-body">
                <div style="background-color: var(--surface-soft); padding: 1rem; border-radius: 0.75rem; margin-bottom: 1rem;">
                    <p style="margin: 0 0 0.5rem 0; color: var(--text-muted); font-size: 0.875rem;">Total Debt</p>
                    <p style="margin: 0; font-size: 1.875rem; font-weight: 600; color: {{ $member->debt > 0 ? 'var(--danger)' : 'var(--success)' }};">AF {{ number_format($member->debt, 2) }}</p>
                </div>
                @if($paymentStats)
                    <div style="display: grid; gap: 0.5rem; font-size: 0.875rem;">
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--text-muted);">Total Paid</span>
                            <span>AF {{ number_format($paymentStats['total_paid'], 2) }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--text-muted);">Payments</span>
                            <span>{{ $paymentStats['payment_count'] }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--text-muted);">Avg Payment</span>
                            <span>AF {{ number_format($paymentStats['average_payment'], 2) }}</span>
                        </div>
                        @if($paymentStats['last_payment_date'])
                            <div style="display: flex; justify-content: space-between;">
                                <span style="color: var(--text-muted);">Last Payment</span>
                                <span>{{ $paymentStats['last_payment_date']->format('M d') }}</span>
                            </div>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        @if($member->workoutPlans->isNotEmpty() || $member->dietPlans->isNotEmpty())
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Assigned Plans</h2>
                    <div style="margin-top: 0.5rem;">
                        <a href="{{ route('ai.show-plans', $member) }}" class="button button-outline" style="font-size: 0.875rem; padding: 0.5rem 1rem;">👁️ View Full Plans</a>
                    </div>
                </div>
                <div class="card-body">
                    <div style="display: grid; gap: 1.5rem;">
                        @if($member->workoutPlans->isNotEmpty())
                            <div>
                                <p style="margin: 0 0 0.75rem 0; color: var(--primary); font-size: 0.875rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.075em;">Workout Plans</p>
                                <div style="display: grid; gap: 0.75rem;">
                                    @foreach($member->workoutPlans->take(3) as $plan)
                                        <div style="background-color: var(--surface-soft); padding: 1rem; border-radius: 0.75rem;">
                                            <p style="margin: 0 0 0.75rem 0; font-weight: 600;">{{ ucfirst($plan->level) }} Workout Plan</p>
                                            <div style="display: grid; gap: 0.25rem; font-size: 0.75rem; color: var(--text-muted);">
                                                @foreach((array) $plan->plan_data as $day => $detail)
                                                    <div>
                                                        <strong>{{ is_iterable($day) ? 'Multiple' : $day }}:</strong>
                                                        
                                                        @if(is_iterable($detail))
                                                            {{ implode(', ', collect($detail)->flatten()->toArray()) }}
                                                        @else
                                                            {{ $detail }}
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if($member->dietPlans->isNotEmpty())
                            <div>
                                <p style="margin: 0 0 0.75rem 0; color: var(--success); font-size: 0.875rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.075em;">Diet Plans</p>
                                <div style="display: grid; gap: 0.75rem;">
                                    @foreach($member->dietPlans->take(3) as $plan)
                                        <div style="background-color: var(--surface-soft); padding: 1rem; border-radius: 0.75rem;">
                                            <p style="margin: 0 0 0.75rem 0; font-weight: 600;">{{ ucfirst($plan->level) }} Diet Plan</p>
                                            <div style="display: grid; gap: 0.25rem; font-size: 0.75rem; color: var(--text-muted);">
                                                @foreach((array) $plan->plan_data as $meal => $detail)
                                                    @php
                                                        $mealKey = is_array($meal) ? implode(', ', array_filter(array_map('strval', $meal))) : (string)$meal;
                                                        if (is_array($detail)) {
                                                            $detailValue = implode(', ', array_filter(array_map(function($item) {
                                                                return is_array($item) ? json_encode($item) : (string)$item;
                                                            }, $detail)));
                                                        } else {
                                                            $detailValue = (string)$detail;
                                                        }
                                                    @endphp
                                                    <div>{{ $mealKey }}: {{ $detailValue }}</div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </aside>
</div>
@endsection
