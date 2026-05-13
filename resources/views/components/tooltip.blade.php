@props(['content', 'position' => 'top'])

@php
    $positionClasses = [
        'top' => 'bottom-full left-1/2 transform -translate-x-1/2 mb-2',
        'bottom' => 'top-full left-1/2 transform -translate-x-1/2 mt-2',
        'left' => 'right-full top-1/2 transform -translate-y-1/2 mr-2',
        'right' => 'left-full top-1/2 transform -translate-y-1/2 ml-2',
    ];

    $tooltipId = 'tooltip-' . uniqid();
@endphp

<div class="relative inline-block" x-data="{ show: false }" @mouseenter="show = true" @mouseleave="show = false">
    {{ $slot }}

    <div
        x-show="show"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="absolute {{ $positionClasses[$position] ?? $positionClasses['top'] }} px-2 py-1 text-xs text-white bg-gray-900 rounded shadow-lg z-50 whitespace-nowrap"
        role="tooltip"
    >
        {{ $content }}
        <div class="absolute w-2 h-2 bg-gray-900 transform rotate-45
            @if($position === 'top') top-full left-1/2 -translate-x-1/2 -mt-1
            @elseif($position === 'bottom') bottom-full left-1/2 -translate-x-1/2 -mb-1
            @elseif($position === 'left') left-full top-1/2 -translate-y-1/2 -ml-1
            @elseif($position === 'right') right-full top-1/2 -translate-y-1/2 -mr-1
            @endif
        "></div>
    </div>
</div>