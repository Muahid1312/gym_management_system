@extends('layouts.app')

@section('content')
    <div class="card">
        <h1>QR Code for {{ $member->name }}</h1>
        <div style="text-align: center;">
            {!! $qrImage !!}
        </div>
        <p>Scan this QR code to check in.</p>
    </div>
@endsection