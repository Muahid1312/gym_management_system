@props(['src' => null, 'alt' => '', 'name' => '', 'size' => 'md', 'initials' => null])

@php
    $sizeClasses = [
        'xs' => 'w-6 h-6 text-xs',
        'sm' => 'w-8 h-8 text-sm',
        'md' => 'w-10 h-10 text-base',
        'lg' => 'w-12 h-12 text-lg',
        'xl' => 'w-16 h-16 text-xl',
        '2xl' => 'w-20 h-20 text-2xl',
    ];

    $classes = 'inline-flex items-center justify-center rounded-full bg-gray-500 text-white font-medium ' . ($sizeClasses[$size] ?? $sizeClasses['md']);

    if (!$initials && $name) {
        $parts = explode(' ', trim($name));
        $initials = strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));
    }
@endphp

@if($src)
    <img
        {{ $attributes->merge(['class' => $classes, 'src' => $src, 'alt' => $alt ?: $name]) }}
    >
@else
    <div {{ $attributes->merge(['class' => $classes]) }}>
        {{ $initials ?: '?' }}
    </div>
@endif