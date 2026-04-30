@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>Add Member</h1>
        <form action="{{ route('members.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input id="name" name="name" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input id="phone" name="phone" value="{{ old('phone') }}" required>
            </div>
            <div class="form-group">
                <label for="photo">Photo</label>
                <input id="photo" name="photo" type="file" accept="image/*">
            </div>
            <div class="form-group">
                <label for="plan_id">Membership Plan</label>
                <select id="plan_id" name="plan_id" required>
                    <option value="">Select a plan</option>
                    @foreach($plans as $plan)
                        <option value="{{ $plan->id }}" {{ old('plan_id') == $plan->id ? 'selected' : '' }}>
                            {{ $plan->name }} ({{ $plan->duration_days }} days)
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="join_date">Join Date</label>
                <input id="join_date" name="join_date" type="date" value="{{ old('join_date', now()->toDateString()) }}" required>
            </div>
            <div class="form-group">
                <label for="workout_level">Workout Plan Level</label>
                <select id="workout_level" name="workout_level" required>
                    @foreach($levels as $level)
                        <option value="{{ $level }}" {{ old('workout_level') == $level ? 'selected' : '' }}>{{ ucfirst($level) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="diet_level">Diet Plan Level</label>
                <select id="diet_level" name="diet_level" required>
                    @foreach($levels as $level)
                        <option value="{{ $level }}" {{ old('diet_level') == $level ? 'selected' : '' }}>{{ ucfirst($level) }}</option>
                    @endforeach
                </select>
            </div>
            <button class="button" type="submit">Register Member</button>
        </form>
    </div>
@endsection
