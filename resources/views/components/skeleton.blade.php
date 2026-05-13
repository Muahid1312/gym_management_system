@props(['lines' => 1, 'width' => '100%', 'height' => '1rem', 'class' => ''])

@php
    $baseClasses = 'animate-pulse bg-gray-200 rounded ' . $class;
@endphp

@if($lines === 1)
    <div class="{{ $baseClasses }}" style="width: {{ $width }}; height: {{ $height }};"></div>
@else
    <div class="space-y-2">
        @for($i = 0; $i < $lines; $i++)
            @php
                $lineWidth = $i === $lines - 1 ? '60%' : $width;
            @endphp
            <div class="{{ $baseClasses }}" style="width: {{ $lineWidth }}; height: {{ $height }};"></div>
        @endfor
    </div>
@endif