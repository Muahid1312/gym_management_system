@props(['links' => [], 'copyright' => null])

@if($copyright || !empty($links))
    <footer class="bg-white border-t border-gray-200">
        <div class="px-4 py-6 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                @if($copyright)
                    <div class="text-sm text-gray-500">
                        {{ $copyright }}
                    </div>
                @endif

                @if(!empty($links))
                    <div class="flex space-x-6 mt-4 md:mt-0">
                        @foreach($links as $link)
                            <a href="{{ $link['url'] }}" class="text-sm text-gray-500 hover:text-gray-900">
                                {{ $link['label'] }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </footer>
@endif