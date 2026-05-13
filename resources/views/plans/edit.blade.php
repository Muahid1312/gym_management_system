@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>تصحیح پلان</h1>
        <form action="{{ route('plans.update', $plan) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">اسم پلان</label>
                <input id="name" name="name" value="{{ old('name', $plan->name) }}" required>
            </div>
            <div class="form-group">
                <label for="price">قیمت</label>
                <input id="price" name="price" type="number" step="0.01" value="{{ old('price', $plan->price) }}" required>
            </div>
            <div class="form-group">
                <label for="duration_days">مدت (روز)</label>
                <input id="duration_days" name="duration_days" type="number" value="{{ old('duration_days', $plan->duration_days) }}" required>
            </div>
            <div class="form-group">
                <label for="description">توضیحات</label>
                <textarea id="description" name="description">{{ old('description', $plan->description) }}</textarea>
            </div>
            <button class="button" type="submit">به روزرسانی پلان</button>
        </form>
    </div>
@endsection
