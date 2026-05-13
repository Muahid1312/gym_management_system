@props(['title' => 'No data found', 'description' => 'Get started by creating your first item.', 'icon' => null, 'action' => null])

<div class="text-center py-12">
    @if($icon)
        <div class="mx-auto h-12 w-12 text-gray-400">
            {!! $icon !!}
        </div>
    @else
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2M4 13h2m8-5v2m0 0v2m0-2h2m-2 0h-2"/>
        </svg>
    @endif

    <h3 class="mt-2 text-sm font-medium text-gray-900">{{ $title }}</h3>
    <p class="mt-1 text-sm text-gray-500">{{ $description }}</p>

    @if($action)
        <div class="mt-6">
            <x-button href="{{ $action['url'] }}" variant="{{ $action['variant'] ?? 'primary' }}">
                {{ $action['label'] }}
            </x-button>
        </div>
    @endif
</div>