@props(['trigger', 'items' => [], 'position' => 'bottom-left'])

@php
    $positionClasses = [
        'top-left' => 'bottom-full left-0 mb-2',
        'top-right' => 'bottom-full right-0 mb-2',
        'bottom-left' => 'top-full left-0 mt-2',
        'bottom-right' => 'top-full right-0 mt-2',
        'left-top' => 'right-full top-0 mr-2',
        'left-bottom' => 'right-full bottom-0 mr-2',
        'right-top' => 'left-full top-0 ml-2',
        'right-bottom' => 'left-full bottom-0 ml-2',
    ];

    $dropdownId = 'dropdown-' . uniqid();
@endphp

<div class="relative inline-block text-left" x-data="{ open: false }" @click.away="open = false">
    <div @click="open = !open">
        {{ $trigger }}
    </div>

    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-100"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        class="absolute {{ $positionClasses[$position] ?? $positionClasses['bottom-left'] }} w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 z-10"
        role="menu"
        aria-orientation="vertical"
    >
        <div class="py-1" role="none">
            @foreach($items as $item)
                @if($item['type'] === 'divider')
                    <div class="border-t border-gray-100"></div>
                @elseif($item['type'] === 'header')
                    <div class="px-4 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        {{ $item['label'] }}
                    </div>
                @else
                    @php
                        $url = $item['url'] ?? '#';
                        $method = $item['method'] ?? 'GET';
                        $classes = $item['class'] ?? 'text-gray-700 hover:bg-gray-100 hover:text-gray-900';
                        $icon = $item['icon'] ?? '';
                    @endphp

                    @if($method === 'DELETE')
                        <form method="POST" action="{{ $url }}" class="block">
                            @csrf
                            @method('DELETE')
                            <button
                                type="submit"
                                class="w-full text-left px-4 py-2 text-sm {{ $classes }} flex items-center"
                                role="menuitem"
                                onclick="return confirm('{{ $item['confirm'] ?? 'Are you sure?' }}')"
                            >
                                @if($icon)
                                    <span class="mr-3">{{ $icon }}</span>
                                @endif
                                {{ $item['label'] }}
                            </button>
                        </form>
                    @elseif($method === 'GET')
                        <a
                            href="{{ $url }}"
                            class="px-4 py-2 text-sm {{ $classes }} flex items-center"
                            role="menuitem"
                        >
                            @if($icon)
                                <span class="mr-3">{{ $icon }}</span>
                            @endif
                            {{ $item['label'] }}
                        </a>
                    @else
                        <form method="POST" action="{{ $url }}" class="block">
                            @csrf
                            @method($method)
                            <button
                                type="submit"
                                class="w-full text-left px-4 py-2 text-sm {{ $classes }} flex items-center"
                                role="menuitem"
                            >
                                @if($icon)
                                    <span class="mr-3">{{ $icon }}</span>
                                @endif
                                {{ $item['label'] }}
                            </button>
                        </form>
                    @endif
                @endif
            @endforeach
        </div>
    </div>
</div>