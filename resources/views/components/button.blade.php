@props(['variant' => 'primary', 'size' => 'md', 'href' => null, 'type' => 'button', 'disabled' => false, 'loading' => false, 'loadingText' => 'در حال پردازش...'])

@php
    $baseClasses = 'inline-flex items-center justify-center font-semibold rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';

    $variantClasses = [
        'primary' => 'bg-blue-600 hover:bg-blue-700 text-white focus:ring-blue-500 shadow-md hover:shadow-lg',
        'secondary' => 'bg-gray-600 hover:bg-gray-700 text-white focus:ring-gray-500 shadow-md hover:shadow-lg',
        'success' => 'bg-green-600 hover:bg-green-700 text-white focus:ring-green-500 shadow-md hover:shadow-lg',
        'danger' => 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500 shadow-md hover:shadow-lg',
        'warning' => 'bg-yellow-600 hover:bg-yellow-700 text-white focus:ring-yellow-500 shadow-md hover:shadow-lg',
        'outline' => 'border border-gray-300 bg-white hover:bg-gray-50 text-gray-700 focus:ring-blue-500',
        'ghost' => 'text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:ring-gray-500',
    ];

    $sizeClasses = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base',
        'xl' => 'px-8 py-4 text-lg',
    ];

    $classes = $baseClasses . ' ' . ($variantClasses[$variant] ?? $variantClasses['primary']) . ' ' . ($sizeClasses[$size] ?? $sizeClasses['md']);
    $isDisabled = $disabled || $loading;
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }} {{ $isDisabled ? 'aria-disabled="true"' : '' }}>
        @if($loading)
            {{ $loadingText }}
        @else
            {{ $slot }}
        @endif
    </a>
@else
    <button type="{{ $type }}" {{ $isDisabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => $classes]) }}>
        @if($loading)
            {{ $loadingText }}
        @else
            {{ $slot }}
        @endif
    </button>
@endif