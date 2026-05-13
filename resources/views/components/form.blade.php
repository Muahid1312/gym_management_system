@props(['method' => 'POST', 'action' => '', 'enctype' => null])

@php
    $method = strtoupper($method);
    $actualMethod = in_array($method, ['GET', 'POST']) ? $method : 'POST';
@endphp

<form method="{{ $actualMethod }}" action="{{ $action }}" {{ $enctype ? 'enctype="' . $enctype . '"' : '' }} {{ $attributes }}>
    @if($method !== $actualMethod)
        @method($method)
    @endif

    {{ $slot }}
</form>