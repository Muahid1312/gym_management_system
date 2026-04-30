@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>{{ __('messages.attendance') }}</h1>
        <table>
            <thead>
                <tr>
                    <th>{{ __('messages.name') }}</th>
                    <th>{{ __('messages.check_in') }} Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendances as $attendance)
                    <tr>
                        <td>{{ $attendance->member->name }}</td>
                        <td>{{ $attendance->check_in_time->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection