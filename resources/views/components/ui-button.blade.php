@props(['type' => 'primary', 'size' => 'md', 'href' => null, 'tag' => null, 'icon' => null])

@php
    $baseClass = 'button';
    $sizeClass = match($size) {
        'sm' => 'text-sm',
        'md' => 'text-sm',
        'lg' => 'text-base',
        default => 'text-sm'
    };
    
    $typeClass = match($type) {
        'primary' => 'button',
        'secondary' => 'button button-secondary',
        'success' => 'button button-success',
        'danger' => 'button button-danger',
        'outline' => 'button button-outline',
        default => 'button'
    };
    
    $classes = "$baseClass $typeClass $sizeClass";
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <span style="margin-right: 8px;">{!! $icon !!}</span>
        @endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $tag ?? 'button' }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon)
            <span style="margin-right: 8px;">{!! $icon !!}</span>
        @endif
        {{ $slot }}
    </button>
@endif
