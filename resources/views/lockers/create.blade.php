@extends('layouts.app-modern')

@section('title', 'Create Locker')

@section('content')
    <div class="page-header">
        <h1 class="page-title">ایجاد الماری جدید</h1>
        <p class="page-subtitle">الماری اضافه کنید و وضیعت آن را مشخض کنید!</p>
    </div>

    <div class="card" style="max-width: 640px;">
        <form action="{{ route('lockers.store') }}" method="POST" data-offline-sync="true" data-offline-sync-url="{{ route('lockers.store') }}">
            @csrf

            <div class="form-group">
                <label for="locker_number">نمبر الماری</label>
                <input type="text" name="locker_number" id="locker_number" value="{{ old('locker_number') }}" required />
                @error('locker_number')
                    <p style="color: var(--danger); margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">وضیعت</label>
                <select name="status" id="status" required>
                    @foreach($statuses as $status)
                        <option value="{{ $status }}" {{ old('status') === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                @error('status')
                    <p style="color: var(--danger); margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>

            <div class="button-group">
                <a href="{{ route('lockers.index') }}" class="button button-outline">← بازگشت به صفحه الماری</a>
                <button type="submit" class="button">ساخت الماری</button>
            </div>
        </form>
    </div>
@endsection
