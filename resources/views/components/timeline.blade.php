@props(['items' => []])

<div class="flow-root">
    <ul class="-mb-8">
        @foreach($items as $index => $item)
            <li>
                <div class="relative pb-8">
                    @if(!$loop->last)
                        <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                    @endif

                    <div class="relative flex space-x-3">
                        <div>
                            <span class="h-8 w-8 rounded-full {{ $item['icon_bg'] ?? 'bg-blue-500' }} flex items-center justify-center ring-8 ring-white">
                                @if(isset($item['icon']))
                                    {!! $item['icon'] !!}
                                @else
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                @endif
                            </span>
                        </div>

                        <div class="min-w-0 flex-1 pt-1.5">
                            <div>
                                <p class="text-sm font-medium text-gray-900">
                                    {{ $item['title'] }}
                                </p>
                                @if(isset($item['subtitle']))
                                    <p class="text-sm text-gray-500">
                                        {{ $item['subtitle'] }}
                                    </p>
                                @endif
                            </div>

                            @if(isset($item['content']))
                                <div class="mt-2 text-sm text-gray-700">
                                    {{ $item['content'] }}
                                </div>
                            @endif

                            @if(isset($item['timestamp']))
                                <div class="mt-2 text-xs text-gray-500">
                                    {{ $item['timestamp'] }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</div>