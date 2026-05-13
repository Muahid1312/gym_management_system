@extends('layouts.app')

@section('content')
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h1>پلان ها</h1>
            <a class="button" href="{{ route('plans.create') }}">اضافه کردن پلان جدید</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>اسم</th>
                    <th>قیمت</th>
                    <th>مدت (روز)</th>
                    <th>توضیحات</th>
                    <th>عملکردها</th>
                </tr>
            </thead>
            <tbody>
                @foreach($plans as $plan)
                    <tr>
                        <td>{{ $plan->name }}</td>
                        <td>{{ number_format($plan->price, 2) }}</td>
                        <td>{{ $plan->duration_days }}</td>
                        <td>{{ $plan->description }}</td>
                        <td>
                            <a class="btn" href="{{ route('plans.edit', $plan) }}">تصحیح</a>
                            <form action="{{ route('plans.destroy', $plan) }}" method="POST" style="display:inline-block; margin-left: 8px;">
                                @csrf
                                @method('DELETE')
                                <button class="btn" style="background:#dc2626;">حذف</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
