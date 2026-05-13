@props(['size' => 'md', 'variant' => 'primary'])

@php
    $sizeClasses = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ];

    $variantClasses = [
        'primary' => 'bg-blue-600 hover:bg-blue-700 text-white focus:ring-blue-500',
        'secondary' => 'bg-gray-600 hover:bg-gray-700 text-white focus:ring-gray-500',
        'success' => 'bg-green-600 hover:bg-green-700 text-white focus:ring-green-500',
        'danger' => 'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500',
    ];

    $baseClasses = 'inline-flex items-center font-semibold border border-transparent rounded-md transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';

    $buttonClasses = $baseClasses . ' ' . ($variantClasses[$variant] ?? $variantClasses['primary']) . ' ' . ($sizeClasses[$size] ?? $sizeClasses['md']);
@endphp

<div class="inline-flex rounded-md shadow-sm" role="group">
    @foreach($slot->toArray() as $index => $button)
        @php
            $isFirst = $index === 0;
            $isLast = $index === count($slot->toArray()) - 1;
            $classes = $buttonClasses;

            if (!$isFirst) {
                $classes .= ' -ml-px';
            }

            if ($isFirst) {
                $classes .= ' rounded-r-none';
            } elseif ($isLast) {
                $classes .= ' rounded-l-none';
            } else {
                $classes .= ' rounded-none';
            }
        @endphp

        <button {{ $attributes->merge(['class' => $classes]) }}>
            {{ $button }}
        </button>
    @endforeach
</div>