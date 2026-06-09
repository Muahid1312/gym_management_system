@extends('layouts.app-modern')

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

<div class="flex gap-2 mb-6">
    <x-button href="{{ route('members.index') }}" variant="outline">← Back to Members</x-button>
    <x-button href="{{ route('members.edit', $member) }}">Edit Member</x-button>
    <form action="{{ route('members.destroy', $member) }}" method="POST" class="inline-block">
        @csrf
        @method('DELETE')
        <x-button type="submit" variant="danger" onclick="return confirm('Are you sure you want to delete this member?');">Delete Member</x-button>
    </form>
</div>

@if($isAtRisk)
    <x-card class="border-red-200 dark:border-red-900 bg-red-50 dark:bg-red-900/20">
        <div class="flex gap-4">
            <div class="flex-shrink-0 w-12 h-12 rounded-md bg-red-600 dark:bg-red-700 text-white flex items-center justify-center">⚠️</div>
            <div>
                <h2 class="text-lg font-semibold text-red-700 dark:text-red-400">This member is at risk</h2>
                <p class="text-sm text-slate-600 dark:text-slate-400">Review the member's account and follow up before the next billing cycle.</p>
                <ul class="mt-2 ml-4 list-disc text-sm text-slate-600 dark:text-slate-400">
                    @if($daysUntilExpiry !== null && $daysUntilExpiry <= 3)
                        <li>Membership expires in {{ max(0, $daysUntilExpiry) }} day(s).</li>
                    @endif
                    @if($member->debt > 0)
                        <li>Outstanding debt: AF {{ number_format($member->debt, 2) }}.</li>
                    @endif
                </ul>
            </div>
        </div>
    </x-card>
@endif

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <div class="lg:col-span-2 space-y-6">
        <x-card>
            <div class="flex items-start gap-6 justify-between flex-wrap">
                <div class="flex items-center gap-4">
                    @if($member->photo)
                        <img src="{{ asset('storage/' . $member->photo) }}" alt="{{ $member->name }}" class="w-24 h-24 rounded-full object-cover" />
                    @else
                        <div class="w-24 h-24 rounded-full bg-blue-600 flex items-center justify-center text-white font-bold text-3xl">
                            {{ strtoupper(substr($member->name, 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wide">Member Profile</p>
                        <h2 class="text-2xl font-semibold">{{ $member->name }}</h2>
                        <p class="text-sm text-slate-500">Joined on {{ $member->join_date->format('M d, Y') }}</p>
                    </div>
                </div>

                <div class="grid gap-3 grid-cols-1 sm:grid-cols-2 md:grid-cols-2 w-full sm:w-auto">
                    <div class="bg-slate-50 dark:bg-slate-700 p-4 rounded-md">
                        <p class="text-xs text-slate-500 dark:text-slate-400">Current Plan</p>
                        <p class="text-lg font-semibold dark:text-slate-100">{{ $member->plan->name ?? 'N/A' }}</p>
                    </div>
                    <div class="bg-slate-50 dark:bg-slate-700 p-4 rounded-md">
                        <p class="text-xs text-slate-500 dark:text-slate-400">Membership Status</p>
                        <p class="text-lg font-semibold {{ $member->expiry_date && $member->expiry_date->isFuture() ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' }}">
                            {{ $member->expiry_date && $member->expiry_date->isFuture() ? 'Active' : 'Expired' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-6 grid gap-4 grid-cols-1 sm:grid-cols-2 md:grid-cols-4">
                <div class="bg-slate-50 dark:bg-slate-700 p-4 rounded-md">
                    <p class="text-xs text-slate-500 dark:text-slate-400 uppercase">Expiry Date</p>
                    <p class="text-lg font-semibold dark:text-slate-100">{{ $member->expiry_date?->format('M d, Y') ?? 'N/A' }}</p>
                </div>
                <div class="bg-slate-50 dark:bg-slate-700 p-4 rounded-md">
                    <p class="text-xs text-slate-500 dark:text-slate-400 uppercase">Debt</p>
                    <p class="text-lg font-semibold {{ $member->debt > 0 ? 'text-red-600 dark:text-red-400' : 'text-emerald-600 dark:text-emerald-400' }}">AF {{ number_format($member->debt, 2) }}</p>
                </div>
                <div class="bg-slate-50 dark:bg-slate-700 p-4 rounded-md">
                    <p class="text-xs text-slate-500 dark:text-slate-400 uppercase">Workout Level</p>
                    <p class="text-lg font-semibold capitalize dark:text-slate-100">{{ is_array($member->workout_level) ? implode(', ', $member->workout_level) : $member->workout_level }}</p>
                </div>
                <div class="bg-slate-50 dark:bg-slate-700 p-4 rounded-md">
                    <p class="text-xs text-slate-500 dark:text-slate-400 uppercase">Diet Level</p>
                    <p class="text-lg font-semibold capitalize dark:text-slate-100">{{ is_array($member->diet_level) ? implode(', ', $member->diet_level) : $member->diet_level }}</p>
                </div>
            </div>
        </x-card>

        <x-card>
            <h3 class="text-lg font-semibold mb-3">Payment History</h3>
            @if($member->payments->isNotEmpty())
                <x-table>
                    <thead>
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Plan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($member->payments->sortByDesc('paid_at') as $payment)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $payment->paid_at->format('M d, Y') }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">{{ $payment->plan->name ?? 'N/A' }}</td>
                                <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-gray-100">AF {{ number_format($payment->amount, 2) }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-semibold text-white {{ $payment->is_partial ? 'bg-yellow-500' : 'bg-emerald-500' }}">
                                        {{ $payment->is_partial ? 'Partial' : 'Complete' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </x-table>
            @else
                <p class="text-sm text-slate-500 dark:text-slate-400">No payment history found.</p>
            @endif
        </x-card>

        <x-card>
            <h3 class="text-lg font-semibold mb-3">Recent Attendance</h3>
            @if($member->attendances->isNotEmpty())
                <div class="grid gap-3">
                    @foreach($member->attendances->sortByDesc('check_in_time')->take(10) as $attendance)
                        <div class="bg-slate-50 dark:bg-slate-700 p-4 rounded-md">
                            <div class="flex justify-between items-center gap-4">
                                <div>
                                    <p class="mb-1 font-semibold dark:text-slate-100">{{ $attendance->check_in_time->format('M d, Y') }}</p>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">{{ $attendance->check_in_time->format('h:i A') }}</p>
                                </div>
                                <span class="inline-flex items-center rounded-full bg-emerald-500 text-white px-3 py-1 text-sm font-semibold">Checked In</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-slate-500 dark:text-slate-400">No attendance records found.</p>
            @endif
        </x-card>
    </div>

    <aside class="grid gap-6">
        <x-card>
            <h3 class="text-lg font-semibold mb-3">Membership Status</h3>
            <div class="grid gap-4">
                <div>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Status</p>
                    <p class="font-semibold dark:text-slate-100">{{ $member->expiry_date && $member->expiry_date->isFuture() ? 'Active' : 'Expired' }}</p>
                </div>
                @if($daysUntilExpiry !== null)
                    <div>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Days Until Expiry</p>
                        <p class="text-2xl font-semibold dark:text-slate-100">{{ max(0, $daysUntilExpiry) }}</p>
                    </div>
                @endif
                <div>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Expiry Date</p>
                    <p class="font-semibold dark:text-slate-100">{{ $member->expiry_date?->format('M d, Y') ?? 'N/A' }}</p>
                </div>
            </div>
        </x-card>

        <x-card>
            <h3 class="text-lg font-semibold mb-3">Locker Assignment</h3>
            @if($member->lockerAssignment)
                <p class="text-sm text-slate-500 dark:text-slate-400">Assigned locker</p>
                <p class="text-xl font-bold dark:text-slate-100">{{ $member->lockerAssignment->locker->locker_number }}</p>
                <p class="text-sm text-slate-500 dark:text-slate-400">Expires at {{ $member->lockerAssignment->expiry_date?->format('M d, Y') ?? 'No expiry' }}</p>
                <span class="inline-flex items-center rounded-full bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 px-3 py-1 font-semibold">Occupied</span>
            @else
                <p class="text-sm text-slate-500 dark:text-slate-400">No active locker assigned. Use the locker grid to assign a locker.</p>
            @endif
        </x-card>

        <x-card>
            <h3 class="text-lg font-semibold mb-3">Debt Status</h3>
            <div class="bg-slate-50 dark:bg-slate-700 p-4 rounded-md mb-4">
                <p class="text-xs text-slate-500 dark:text-slate-400">Total Debt</p>
                <p class="text-2xl font-semibold {{ $member->debt > 0 ? 'text-red-600 dark:text-red-400' : 'text-emerald-600 dark:text-emerald-400' }}">AF {{ number_format($member->debt, 2) }}</p>
            </div>
            @if($paymentStats)
                <div class="grid gap-2 text-sm">
                    <div class="flex justify-between"><span class="text-slate-500 dark:text-slate-400">Total Paid</span><span class="dark:text-slate-100">AF {{ number_format($paymentStats['total_paid'], 2) }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-500 dark:text-slate-400">Payments</span><span class="dark:text-slate-100">{{ $paymentStats['payment_count'] }}</span></div>
                    <div class="flex justify-between"><span class="text-slate-500 dark:text-slate-400">Avg Payment</span><span class="dark:text-slate-100">AF {{ number_format($paymentStats['average_payment'], 2) }}</span></div>
                    @if($paymentStats['last_payment_date'])
                        <div class="flex justify-between"><span class="text-slate-500 dark:text-slate-400">Last Payment</span><span class="dark:text-slate-100">{{ $paymentStats['last_payment_date']->format('M d') }}</span></div>
                    @endif
                </div>
            @endif
        </x-card>

        @if($member->workoutPlans->isNotEmpty() || $member->dietPlans->isNotEmpty())
            <x-card>
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-lg font-semibold">Assigned Plans</h3>
                    <x-button href="{{ route('ai.show-plans', $member) }}" variant="outline" size="sm">👁️ View Full Plans</x-button>
                </div>

                <div class="grid gap-4">
                    @if($member->workoutPlans->isNotEmpty())
                        <div>
                            <p class="text-xs text-sky-600 dark:text-sky-400 font-semibold uppercase">Workout Plans</p>
                            <div class="grid gap-3 mt-2">
                                @foreach($member->workoutPlans->take(3) as $plan)
                                    <div class="bg-slate-50 dark:bg-slate-700 p-4 rounded-md">
                                        <p class="font-semibold dark:text-slate-100">{{ ucfirst($plan->level) }} Workout Plan</p>
                                        <div class="mt-2 text-sm text-slate-500 dark:text-slate-400">
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
                            <p class="text-xs text-emerald-600 dark:text-emerald-400 font-semibold uppercase">Diet Plans</p>
                            <div class="grid gap-3 mt-2">
                                @foreach($member->dietPlans->take(3) as $plan)
                                    <div class="bg-slate-50 dark:bg-slate-700 p-4 rounded-md">
                                        <p class="font-semibold dark:text-slate-100">{{ ucfirst($plan->level) }} Diet Plan</p>
                                        <div class="mt-2 text-sm text-slate-500 dark:text-slate-400">
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
            </x-card>
        @endif
    </aside>
</div>
@endsection
