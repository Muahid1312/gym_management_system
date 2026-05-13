@props(['headers' => [], 'data' => [], 'mobileHeaders' => [], 'actions' => []])

<div class="bg-white shadow overflow-hidden sm:rounded-md">
    <!-- Desktop Table -->
    <div class="hidden md:block">
        <x-data-table :headers="$headers" :data="$data" :actions="$actions"/>
    </div>

    <!-- Mobile Cards -->
    <div class="md:hidden">
        <div class="divide-y divide-gray-200">
            @forelse($data as $row)
                <div class="p-4">
                    @foreach($row as $key => $value)
                        @if($key !== 'id' && $key !== 'actions')
                            @php
                                $mobileHeader = $mobileHeaders[$key] ?? ucfirst(str_replace('_', ' ', $key));
                            @endphp
                            <div class="flex justify-between py-1">
                                <span class="text-sm font-medium text-gray-500">{{ $mobileHeader }}:</span>
                                <span class="text-sm text-gray-900">{{ $value }}</span>
                            </div>
                        @endif
                    @endforeach

                    @if(!empty($actions))
                        <div class="flex justify-end space-x-2 mt-3 pt-3 border-t border-gray-200">
                            @foreach($actions as $action)
                                @if(isset($action['condition']) && !$action['condition']($row))
                                    @continue
                                @endif

                                @php
                                    $url = isset($action['url']) ? (is_callable($action['url']) ? $action['url']($row) : $action['url']) : '#';
                                    $method = $action['method'] ?? 'GET';
                                    $classes = $action['class'] ?? 'text-blue-600 hover:text-blue-900 text-sm';
                                @endphp

                                @if($method === 'DELETE')
                                    <form method="POST" action="{{ $url }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="{{ $classes }}" onclick="return confirm('{{ $action['confirm'] ?? 'Are you sure?' }}')">
                                            {{ $action['label'] }}
                                        </button>
                                    </form>
                                @elseif($method === 'GET')
                                    <a href="{{ $url }}" class="{{ $classes }}">
                                        {{ $action['label'] }}
                                    </a>
                                @else
                                    <form method="POST" action="{{ $url }}" class="inline">
                                        @csrf
                                        @method($method)
                                        <button type="submit" class="{{ $classes }}">
                                            {{ $action['label'] }}
                                        </button>
                                    </form>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            @empty
                <div class="p-4 text-center text-gray-500">
                    No data available
                </div>
            @endforelse
        </div>
    </div>
</div>