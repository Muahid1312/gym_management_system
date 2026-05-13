@props(['status', 'variant' => null])

@php
    $statusVariants = [
        'active' => ['label' => 'Active', 'class' => 'bg-green-100 text-green-800'],
        'inactive' => ['label' => 'Inactive', 'class' => 'bg-gray-100 text-gray-800'],
        'pending' => ['label' => 'Pending', 'class' => 'bg-yellow-100 text-yellow-800'],
        'expired' => ['label' => 'Expired', 'class' => 'bg-red-100 text-red-800'],
        'paid' => ['label' => 'Paid', 'class' => 'bg-green-100 text-green-800'],
        'unpaid' => ['label' => 'Unpaid', 'class' => 'bg-red-100 text-red-800'],
        'overdue' => ['label' => 'Overdue', 'class' => 'bg-red-100 text-red-800'],
        'completed' => ['label' => 'Completed', 'class' => 'bg-blue-100 text-blue-800'],
        'cancelled' => ['label' => 'Cancelled', 'class' => 'bg-gray-100 text-gray-800'],
    ];

    $config = $statusVariants[strtolower($status)] ?? $statusVariants['inactive'];
    $label = is_array($status) ? ($status['label'] ?? $config['label']) : $config['label'];
    $class = is_array($status) ? ($status['class'] ?? $config['class']) : $config['class'];
@endphp

<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $class }}">
    {{ $label }}
</span>