@props(['count' => 0, 'max' => 99, 'size' => 'sm', 'color' => 'red'])

@php
    $displayCount = $count > $max ? $max . '+' : $count;
    $showBadge = $count > 0;

    $sizeClasses = [
        'xs' => 'text-xs px-1.5 py-0.5 min-w-[1rem] h-4',
        'sm' => 'text-xs px-2 py-0.5 min-w-[1.25rem] h-5',
        'md' => 'text-sm px-2.5 py-0.5 min-w-[1.5rem] h-6',
    ];

    $colorClasses = [
        'red' => 'bg-red-500 text-white',
        'blue' => 'bg-blue-500 text-white',
        'green' => 'bg-green-500 text-white',
        'yellow' => 'bg-yellow-500 text-white',
        'gray' => 'bg-gray-500 text-white',
        'indigo' => 'bg-indigo-500 text-white',
    ];

    $classes = 'inline-flex items-center justify-center rounded-full font-medium ' . ($sizeClasses[$size] ?? $sizeClasses['sm']) . ' ' . ($colorClasses[$color] ?? $colorClasses['red']);
@endphp

@if($showBadge)
    <span {{ $attributes->merge(['class' => $classes]) }}>
        {{ $displayCount }}
    </span>
@endif