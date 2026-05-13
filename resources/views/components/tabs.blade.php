@props(['tabs' => [], 'active' => null])

@if(!empty($tabs))
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            @foreach($tabs as $tab)
                @php
                    $isActive = ($active && $active === $tab['key']) || (!$active && $loop->first);
                    $url = $tab['url'] ?? '#';
                @endphp

                @if($url !== '#')
                    <a
                        href="{{ $url }}"
                        class="{{ $isActive ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm"
                        {{ $isActive ? 'aria-current="page"' : '' }}
                    >
                        {{ $tab['label'] }}
                    </a>
                @else
                    <button
                        type="button"
                        class="{{ $isActive ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} whitespace-nowrap py-2 px-1 border-b-2 font-medium text-sm"
                        {{ $isActive ? 'aria-current="page"' : '' }}
                    >
                        {{ $tab['label'] }}
                    </button>
                @endif
            @endforeach
        </nav>
    </div>
@endif