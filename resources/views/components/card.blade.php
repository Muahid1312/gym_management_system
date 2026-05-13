@props(['padding' => 'md', 'shadow' => 'md', 'bordered' => true])

@php
    $paddingClasses = [
        'none' => '',
        'sm' => 'p-4',
        'md' => 'p-6',
        'lg' => 'p-8',
    ];

    $shadowClasses = [
        'none' => '',
        'sm' => 'shadow-sm',
        'md' => 'shadow-md',
        'lg' => 'shadow-lg',
        'xl' => 'shadow-xl',
    ];

    $classes = 'bg-white rounded-lg ' . ($paddingClasses[$padding] ?? $paddingClasses['md']) . ' ' . ($shadowClasses[$shadow] ?? $shadowClasses['md']);

    if ($bordered) {
        $classes .= ' border border-gray-200';
    }
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>