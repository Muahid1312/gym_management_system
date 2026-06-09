@props(['items' => [], 'currentRoute' => null])

<div class="space-y-1">
    @foreach($items as $item)
        @php
            $isActive = ($currentRoute && $currentRoute === $item['route']) ||
                       (isset($item['routes']) && in_array($currentRoute, $item['routes']));
            $hasChildren = isset($item['children']) && !empty($item['children']);
            $url = $item['url'] ?? ($item['route'] ? route($item['route']) : '#');
        @endphp

        @if($hasChildren)
            <div x-data="{ open: {{ $isActive ? 'true' : 'false' }} }">
                <button
                    @click="open = !open"
                    class="w-full flex items-center px-4 py-3 text-sm font-semibold rounded-2xl transition-all duration-200 {{ $isActive ? 'bg-gradient-to-r from-orange-500 to-red-600 text-white shadow-lg shadow-orange-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
                >
                    @if(isset($item['icon']))
                        <span class="mr-3 text-slate-500">{{ $item['icon'] }}</span>
                    @endif
                    <span class="flex-1 text-left">{{ $item['label'] }}</span>
                    <svg class="ml-2 h-4 w-4 transition-transform duration-200" :class="open ? 'rotate-90' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>

                <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 max-h-0" x-transition:enter-end="opacity-100 max-h-96" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 max-h-96" x-transition:leave-end="opacity-0 max-h-0" class="ml-6 space-y-1 overflow-hidden">
                    @foreach($item['children'] as $child)
                        @php
                            $childIsActive = ($currentRoute && $currentRoute === $child['route']) ||
                                           (isset($child['routes']) && in_array($currentRoute, $child['routes']));
                            $childUrl = $child['url'] ?? ($child['route'] ? route($child['route']) : '#');
                        @endphp

                        <a
                            href="{{ $childUrl }}"
                            class="block px-4 py-2 text-sm font-medium rounded-2xl transition-all duration-200 {{ $childIsActive ? 'bg-orange-50 text-orange-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
                        >
                            @if(isset($child['icon']))
                                <span class="mr-3">{{ $child['icon'] }}</span>
                            @endif
                            {{ $child['label'] }}
                        </a>
                    @endforeach
                </div>
            </div>
        @else
            <a
                href="{{ $url }}"
                class="flex items-center px-4 py-3 text-sm font-semibold rounded-2xl transition-all duration-200 {{ $isActive ? 'bg-gradient-to-r from-orange-500 to-red-600 text-white shadow-lg shadow-orange-200' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900' }}"
            >
                @if(isset($item['icon']))
                    <span class="mr-3">{{ $item['icon'] }}</span>
                @endif
                {{ $item['label'] }}

                @if(isset($item['badge']))
                    <x-notification-badge :count="$item['badge']" class="ml-auto"/>
                @endif
            </a>
        @endif
    @endforeach
</div>