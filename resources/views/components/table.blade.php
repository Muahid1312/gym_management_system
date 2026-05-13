@props(['striped' => true, 'hover' => true])

@php
    $classes = 'min-w-full divide-y divide-gray-200';

    if ($striped) {
        $classes .= ' striped';
    }

    if ($hover) {
        $classes .= ' hover';
    }
@endphp

<div class="overflow-x-auto">
    <table {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </table>
</div>

<style>
    .striped tbody tr:nth-child(even) {
        background-color: #f9fafb;
    }

    .hover tbody tr:hover {
        background-color: #f3f4f6;
    }
</style>