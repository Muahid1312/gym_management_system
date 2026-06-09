@extends('layouts.app-modern')

@section('title', 'Edit Plan')

@section('content')
    <div class="card">
        <h1>Edit Plan</h1>
        <form action="{{ route('plans.update', $plan) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Name</label>
                <input id="name" name="name" value="{{ old('name', $plan->name) }}" required>
            </div>
            <div class="form-group">
                <label for="price">Value</label>
                <input id="price" name="price" type="number" step="0.01" value="{{ old('price', $plan->price) }}" required>
            </div>
            <div class="form-group">
                <label for="duration_days">Durations(day)</label>
                <input id="duration_days" name="duration_days" type="number" value="{{ old('duration_days', $plan->duration_days) }}" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description">{{ old('description', $plan->description) }}</textarea>
            </div>
            <button class="button" type="submit">Update Plan</button>
        </form>
    </div>
@endsection
