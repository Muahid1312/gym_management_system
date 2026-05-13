@props(['items' => []])

@if(!empty($items))
    <nav class="flex mb-4" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                    <svg class="w-3 h-3 mr-2.5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2A1 1 0 0 0 1 11h2v8a1 1 0 0 1-1 1H1a1 1 0 0 0 0 2h18a1 1 0 0 0 0-2h-.5a1 1 0 0 1-1-1v-8h2a1 1 0 0 0 .707-1.707Z"/>
                    </svg>
                    Dashboard
                </a>
            </li>

            @foreach($items as $index => $item)
                <li>
                    <div class="flex items-center">
                        <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
                        </svg>
                        @if(isset($item['url']) && $index < count($items) - 1)
                            <a href="{{ $item['url'] }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">
                                {{ $item['label'] }}
                            </a>
                        @else
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">
                                {{ $item['label'] }}
                            </span>
                        @endif
                    </div>
                </li>
            @endforeach
        </ol>
    </nav>
@endif