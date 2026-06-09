@extends('layouts.app-modern')

@section('content')
<div style="display:flex;align-items:center;justify-content:center;height:70vh;flex-direction:column;text-align:center;padding:24px;">
    <h1 style="font-size:56px;margin:0;color:var(--text-primary);">404</h1>
    <p style="font-size:20px;color:var(--text-secondary);margin:12px 0 24px;">Page not found — the resource you're looking for doesn't exist.</p>
    <a href="{{ url('/') }}" class="btn btn-primary" style="background:var(--primary);color:#fff;padding:10px 18px;border-radius:8px;text-decoration:none;">Go to Dashboard</a>
</div>
@endsection
