@props(['columns' => 3, 'gap' => 'md'])

@php
    $columnClasses = [
        1 => 'grid-cols-1',
        2 => 'grid-cols-1 md:grid-cols-2',
        3 => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3',
        4 => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4',
        5 => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5',
        6 => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-6',
    ];

    $gapClasses = [
        'none' => 'gap-0',
        'sm' => 'gap-2',
        'md' => 'gap-4',
        'lg' => 'gap-6',
        'xl' => 'gap-8',
    ];

    $classes = 'grid ' . ($columnClasses[$columns] ?? $columnClasses[3]) . ' ' . ($gapClasses[$gap] ?? $gapClasses['md']);
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>