@extends('layouts.app-modern')

@section('title', 'Workout Generator')

@section('content')
<div class="page-header">
    <div>
        <h1 class="page-title">Workout & Diet Generator</h1>
        <p class="page-subtitle">Select a member to generate a personalized workout and diet plan.</p>
    </div>
</div>

<div class="grid" style="grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 20px;">
    @forelse($members as $member)
        <div class="card">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-xl font-semibold text-slate-900">{{ $member->name }}</h3>
                    <p class="text-sm text-slate-500">{{ $member->email ?? 'No email' }}</p>
                </div>
                <span class="badge badge-info">{{ $member->plan?->name ?? 'No plan' }}</span>
            </div>

            <div class="text-sm text-slate-600 mb-4">
                <p><strong>Phone:</strong> {{ $member->phone ?? 'N/A' }}</p>
                <p><strong>Joined:</strong> {{ $member->join_date?->format('M d, Y') ?? 'N/A' }}</p>
            </div>

            <div class="flex gap-2 flex-wrap">
                <a href="{{ route('ai.generate', $member) }}" class="btn btn-primary">Generate Plans</a>
                <a href="{{ route('ai.show-plans', $member) }}" class="btn btn-secondary">View Plans</a>
            </div>
        </div>
    @empty
        <div class="card" style="grid-column: 1 / -1;">
            <p class="text-center text-slate-500">No members available yet. Add a member to start generating workout and diet plans.</p>
        </div>
    @endforelse
</div>
@endsection
