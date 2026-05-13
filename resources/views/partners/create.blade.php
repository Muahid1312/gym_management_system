@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h1 class="page-title">ساخت پارتنر</h1>
            <a class="button" href="{{ route('partners.index') }}">قبلی</a>
        </div>
    </div>

    <div class="card">
        <form action="{{ route('partners.store') }}" method="POST" style="max-width: 500px;">
            @csrf

            <div class="form-group">
                <label for="name">اسم پارتنر *</label>
                <input type="text" id="name" name="name" required value="{{ old('name') }}" placeholder="e.g., John Trainer">
                @error('name')<span style="color: #ef5350;">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="phone">شماره تماس *</label>
                <input type="tel" id="phone" name="phone" required value="{{ old('phone') }}" placeholder="e.g., +1 (555) 123-4567">
                @error('phone')<span style="color: #ef5350;">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="type">نوع پارتنر *</label>
                <select id="type" name="type" required>
                    <option value="">-- Select Type --</option>
                    <option value="trainer" @selected(old('type') === 'trainer')>ترینر</option>
                    <option value="affiliate" @selected(old('type') === 'affiliate')>همکار</option>
                    
                </select>
                @error('type')<span style="color: #ef5350;">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="commission_percentage">Commission Percentage (%) *</label>
                <input type="number" id="commission_percentage" name="commission_percentage" required step="0.01" min="0" max="100" value="{{ old('commission_percentage') }}" placeholder="e.g., 10.50">
                @error('commission_percentage')<span style="color: #ef5350;">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="is_active">
                    <input type="checkbox" id="is_active" name="is_active" value="1" @checked(old('is_active', true))>
                    Active
                </label>
            </div>

            <button type="submit" class="button" style="width: 100%;">ساختن</button>
        </form>
    </div>
</div>
@endsection

<style>
    input[type="checkbox"] {
        width: auto !important;
        margin-right: 8px;
    }
</style>
