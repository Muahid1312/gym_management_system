@props(['value' => 0, 'max' => 100, 'color' => 'blue', 'size' => 'md', 'showLabel' => false])

@php
    $percentage = min(100, max(0, ($value / $max) * 100));

    $colorClasses = [
        'blue' => 'bg-blue-600',
        'green' => 'bg-green-600',
        'red' => 'bg-red-600',
        'yellow' => 'bg-yellow-600',
        'gray' => 'bg-gray-600',
    ];

    $sizeClasses = [
        'sm' => 'h-1',
        'md' => 'h-2',
        'lg' => 'h-3',
        'xl' => 'h-4',
    ];

    $bgClass = $colorClasses[$color] ?? $colorClasses['blue'];
    $heightClass = $sizeClasses[$size] ?? $sizeClasses['md'];
@endphp

<div class="w-full bg-gray-200 rounded-full {{ $heightClass }}">
    <div
        class="{{ $bgClass }} {{ $heightClass }} rounded-full transition-all duration-300 ease-out"
        style="width: {{ $percentage }}%"
    ></div>
</div>

@if($showLabel)
    <div class="mt-1 text-xs text-gray-600 text-center">
        {{ number_format($percentage, 1) }}% ({{ $value }}/{{ $max }})
    </div>
@endif