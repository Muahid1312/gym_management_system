@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="bg-slate-950 border border-slate-800 shadow-2xl rounded-[28px] overflow-hidden">
        <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-slate-950 px-6 py-8 sm:px-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm uppercase tracking-[0.32em] text-amber-400">Members</p>
                    <h1 class="mt-3 text-3xl font-semibold text-white">Gym Member Management</h1>
                    <p class="mt-2 max-w-2xl text-sm text-slate-400">Manage member profiles, membership plans, and actions in a clean, easy interface.</p>
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
                            <td class="px-4 py-4 text-right relative" data-dropdown>
                                <button type="button" onclick="toggleDropdown('dropdown-{{ $member->id }}')" class="inline-flex items-center gap-2 rounded-full border border-slate-700 bg-slate-800 px-4 py-2 text-sm font-semibold text-slate-100 hover:bg-slate-700 transition">
                                    Actions
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 12a1 1 0 01-.707-.293l-3-3a1 1 0 011.414-1.414L10 9.586l2.293-2.293a1 1 0 011.414 1.414l-3 3A1 1 0 0110 12z" clip-rule="evenodd" />
                                    </svg>
                                </button>

                                <div id="dropdown-{{ $member->id }}" class="hidden absolute right-0 z-20 mt-2 w-56 overflow-hidden rounded-3xl border border-slate-700 bg-slate-950 shadow-2xl shadow-black/40">
                                    <a href="{{ route('members.edit', $member) }}" class="flex items-center gap-2 px-4 py-3 text-sm text-slate-100 hover:bg-slate-900">
                                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-blue-500/10 text-blue-400">E</span>
                                        Edit
                                    </a>
                                    <a href="{{ route('members.qr', $member) }}" class="flex items-center gap-2 px-4 py-3 text-sm text-slate-100 hover:bg-slate-900">
                                        <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-400">Q</span>
                                        Generate QR
                                    </a>
                                    <form action="{{ route('ai.workout', $member) }}" method="POST" class="border-t border-slate-800">
                                        @csrf
                                        <input type="hidden" name="age" value="25">
                                        <input type="hidden" name="weight" value="70">
                                        <input type="hidden" name="height" value="175">
                                        <input type="hidden" name="goal" value="fitness">
                                        <input type="hidden" name="level" value="{{ $member->workout_level }}">
                                        <button type="submit" class="flex w-full items-center gap-2 px-4 py-3 text-left text-sm text-slate-100 hover:bg-slate-900">
                                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-400">W</span>
                                            Generate Workout
                                        </button>
                                    </form>
                                    <form action="{{ route('ai.diet', $member) }}" method="POST" class="border-t border-slate-800">
                                        @csrf
                                        <input type="hidden" name="age" value="25">
                                        <input type="hidden" name="weight" value="70">
                                        <input type="hidden" name="height" value="175">
                                        <input type="hidden" name="goal" value="fitness">
                                        <input type="hidden" name="level" value="{{ $member->diet_level }}">
                                        <button type="submit" class="flex w-full items-center gap-2 px-4 py-3 text-left text-sm text-slate-100 hover:bg-slate-900">
                                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-emerald-500/10 text-emerald-400">D</span>
                                            Generate Diet
                                        </button>
                                    </form>
                                    <form action="{{ route('members.destroy', $member) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this member?');" class="border-t border-slate-800">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="flex w-full items-center gap-2 px-4 py-3 text-left text-sm text-rose-300 hover:bg-slate-900">
                                            <span class="inline-flex h-8 w-8 items-center justify-center rounded-xl bg-rose-500/10 text-rose-400">D</span>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    function toggleDropdown(id) {
        document.querySelectorAll('[id^="dropdown-"]').forEach(menu => {
            if (menu.id !== id) {
                menu.classList.add('hidden');
            }
        });
        const dropdown = document.getElementById(id);
        if (dropdown) dropdown.classList.toggle('hidden');
    }

    document.addEventListener('click', function(event) {
        if (!event.target.closest('[data-dropdown]')) {
            document.querySelectorAll('[id^="dropdown-"]').forEach(menu => menu.classList.add('hidden'));
        }
    });
</script>
@endsection
