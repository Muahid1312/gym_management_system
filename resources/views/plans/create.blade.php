@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>Add New Plan</h1>
        <form action="{{ route('plans.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Plan Name</label>
                <input id="name" name="name" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <label for="price">Price</label>
                <input id="price" name="price" type="number" step="0.01" value="{{ old('price') }}" required>
            </div>
            <div class="form-group">
                <label for="duration_days">Duration (days)</label>
                <input id="duration_days" name="duration_days" type="number" value="{{ old('duration_days', 30) }}" required>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description">{{ old('description') }}</textarea>
            </div>
            <button class="button" type="submit">Save Plan</button>
        </form>
    </div>
@endsection
