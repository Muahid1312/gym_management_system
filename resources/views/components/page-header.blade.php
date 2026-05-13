@props(['title', 'subtitle' => null, 'actions' => []])

<div class="md:flex md:items-center md:justify-between">
    <div class="min-w-0 flex-1">
        <h1 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
            {{ $title }}
        </h1>
        @if($subtitle)
            <p class="mt-1 text-sm text-gray-500">{{ $subtitle }}</p>
        @endif
    </div>
    @if(!empty($actions))
        <div class="mt-4 flex md:mt-0 md:ml-4">
            @foreach($actions as $action)
                @if($action['type'] === 'button')
                    <x-button
                        href="{{ $action['url'] ?? '#' }}"
                        variant="{{ $action['variant'] ?? 'primary' }}"
                        class="ml-3"
                    >
                        {{ $action['label'] }}
                    </x-button>
                @elseif($action['type'] === 'link')
                    <a
                        href="{{ $action['url'] }}"
                        class="ml-3 inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        {{ $action['label'] }}
                    </a>
                @endif
            @endforeach
        </div>
    @endif
</div>