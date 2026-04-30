@extends('layouts.app')

@section('content')
    <div class="card">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h1>Plans</h1>
            <a class="button" href="{{ route('plans.create') }}">Add Plan</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Duration (days)</th>
                    <th>Description</th>
                    <th>Actions</th>
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
                            <a class="btn" href="{{ route('plans.edit', $plan) }}">Edit</a>
                            <form action="{{ route('plans.destroy', $plan) }}" method="POST" style="display:inline-block; margin-left: 8px;">
                                @csrf
                                @method('DELETE')
                                <button class="btn" style="background:#dc2626;">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
