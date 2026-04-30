@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-slate-950 border border-slate-800 shadow-2xl rounded-[28px] overflow-hidden">
        <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-950 px-6 py-8 sm:px-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.32em] text-amber-400">Members</p>
                    <h1 class="mt-3 text-3xl font-semibold text-white">Gym Member Management</h1>
                    <p class="mt-2 max-w-2xl text-sm text-slate-400">A simple staff-friendly interface for managing members and actions.</p>
                </div>
                <a href="{{ route('members.create') }}" class="inline-flex items-center gap-2 rounded-full bg-amber-500 px-5 py-3 text-sm font-semibold text-slate-950 shadow-lg shadow-amber-500/20 hover:bg-amber-400 transition">Add Member</a>
            </div>
        </div>

        <div class="overflow-x-auto px-4 py-6 sm:px-6">
            <table class="min-w-full divide-y divide-slate-800 text-sm">
                <thead class="bg-slate-900 text-slate-400">
                    <tr>
                        <th class="px-4 py-3 text-left uppercase tracking-[0.18em]">Member</th>
                        <th class="px-4 py-3 text-left uppercase tracking-[0.18em]">Plan</th>
                        <th class="px-4 py-3 text-left uppercase tracking-[0.18em]">Expiry</th>
                        <th class="px-4 py-3 text-left uppercase tracking-[0.18em]">Workout</th>
                        <th class="px-4 py-3 text-left uppercase tracking-[0.18em]">Diet</th>
                        <th class="px-4 py-3 text-right uppercase tracking-[0.18em]">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800 bg-slate-950">
                    @foreach($members as $member)
                        <tr class="group hover:bg-slate-900/70 transition">
                            <td class="px-4 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-slate-800 text-sm font-bold text-slate-200">{{ strtoupper(substr($member->name, 0, 1)) }}</div>
                                    <div class="min-w-0">
                                        <p class="font-semibold text-white">{{ $member->name }}</p>
                                        <p class="text-xs text-slate-400 truncate">{{ $member->phone }} · {{ $member->email ?? 'No email' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-slate-300">{{ $member->plan->name }}</td>
                            <td class="px-4 py-4 text-slate-300">{{ $member->expiry_date->format('Y-m-d') }}</td>
                            <td class="px-4 py-4 text-slate-300">{{ ucfirst($member->workout_level) }}</td>
                            <td class="px-4 py-4 text-slate-300">{{ ucfirst($member->diet_level) }}</td>
                            <td class="px-4 py-4 text-right">
                                <button type="button" onclick="openModal({
                                    id: {{ $member->id }},
                                    name: '{{ addslashes($member->name) }}',
                                    editUrl: '{{ route('members.edit', $member) }}',
                                    qrUrl: '{{ route('members.qr', $member) }}',
                                    workoutUrl: '{{ route('ai.workout', $member) }}',
                                    dietUrl: '{{ route('ai.diet', $member) }}',
                                    deleteUrl: '{{ route('members.destroy', $member) }}'
                                })"
                                class="inline-flex items-center gap-2 rounded-full border border-slate-700 bg-slate-800 px-4 py-2 text-sm font-semibold text-slate-100 hover:bg-slate-700 transition">
                                    Actions
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 12a1 1 0 01-.707-.293l-3-3a1 1 0 011.414-1.414L10 9.586l2.293-2.293a1 1 0 011.414 1.414l-3 3A1 1 0 0110 12z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="action-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/80 px-4 py-6">
    <div class="w-full max-w-xl rounded-[32px] bg-slate-950 border border-slate-800 p-6 shadow-2xl shadow-black/40">
        <div class="flex items-start justify-between gap-4">
            <div>
                <p class="text-sm uppercase tracking-[0.3em] text-amber-400">Member actions</p>
                <h2 id="modal-member-name" class="mt-3 text-2xl font-semibold text-white">Member Name</h2>
                <p class="mt-2 text-sm text-slate-400">Choose a safe action for this member.</p>
            </div>
            <button type="button" onclick="closeModal()" class="rounded-full bg-slate-800 p-2 text-slate-300 hover:bg-slate-700 transition">
                <span class="sr-only">Close</span>
                ✕
            </button>
        </div>

        <div class="mt-6 grid gap-3 md:grid-cols-2">
            <a id="modal-edit-url" href="#" class="inline-flex items-center gap-2 rounded-3xl bg-slate-800 px-4 py-4 text-sm font-semibold text-sky-300 hover:bg-slate-900 transition">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-sky-500/10 text-sky-400">E</span>
                Edit Member
            </a>
            <a id="modal-qr-url" href="#" class="inline-flex items-center gap-2 rounded-3xl bg-slate-800 px-4 py-4 text-sm font-semibold text-emerald-300 hover:bg-slate-900 transition">
                <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-500/10 text-emerald-400">Q</span>
                Generate QR
            </a>
            <form id="modal-workout-form" action="#" method="POST" class="inline-flex">
                @csrf
                <button type="submit" class="inline-flex w-full items-center gap-2 rounded-3xl bg-slate-800 px-4 py-4 text-left text-sm font-semibold text-emerald-300 hover:bg-slate-900 transition">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-500/10 text-emerald-400">W</span>
                    Generate Workout Plan
                </button>
            </form>
            <form id="modal-diet-form" action="#" method="POST" class="inline-flex">
                @csrf
                <button type="submit" class="inline-flex w-full items-center gap-2 rounded-3xl bg-slate-800 px-4 py-4 text-left text-sm font-semibold text-emerald-300 hover:bg-slate-900 transition">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-emerald-500/10 text-emerald-400">D</span>
                    Generate Diet Plan
                </button>
            </form>
        </div>

        <div class="mt-6 border-t border-slate-800 pt-4">
            <form id="modal-delete-form" action="#" method="POST" onsubmit="return confirm('Delete this member? This action cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-3xl bg-rose-500 px-4 py-4 text-sm font-semibold text-white hover:bg-rose-400 transition">
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-rose-500/10 text-rose-200">D</span>
                    Delete Member
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function openModal(data) {
        const modal = document.getElementById('action-modal');
        modal.classList.remove('hidden');
        document.getElementById('modal-member-name').textContent = data.name;
        document.getElementById('modal-edit-url').href = data.editUrl;
        document.getElementById('modal-qr-url').href = data.qrUrl;
        document.getElementById('modal-workout-form').action = data.workoutUrl;
        document.getElementById('modal-diet-form').action = data.dietUrl;
        document.getElementById('modal-delete-form').action = data.deleteUrl;
    }

    function closeModal() {
        document.getElementById('action-modal').classList.add('hidden');
    }

    document.addEventListener('click', function(event) {
        if (event.target.closest('#action-modal .rounded-[32px]') === null && !event.target.closest('[onclick^="openModal"]')) {
            closeModal();
        }
    });
</script>
@endsection