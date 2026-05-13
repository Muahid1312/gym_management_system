@props(['headers' => [], 'data' => [], 'actions' => []])

<div class="bg-white shadow overflow-hidden sm:rounded-md">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    @foreach($headers as $header)
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            {{ $header }}
                        </th>
                    @endforeach
                    @if(!empty($actions))
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                    @endif
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($data as $row)
                    <tr class="hover:bg-gray-50">
                        @foreach($row as $key => $value)
                            @if($key !== 'id' && $key !== 'actions')
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $value }}
                                </td>
                            @endif
                        @endforeach
                        @if(!empty($actions))
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center space-x-2">
                                    @foreach($actions as $action)
                                        @if(isset($action['condition']) && !$action['condition']($row))
                                            @continue
                                        @endif

                                        @php
                                            $url = isset($action['url']) ? (is_callable($action['url']) ? $action['url']($row) : $action['url']) : '#';
                                            $method = $action['method'] ?? 'GET';
                                            $classes = $action['class'] ?? 'text-blue-600 hover:text-blue-900';
                                            $icon = $action['icon'] ?? '';
                                        @endphp

                                        @if($method === 'DELETE')
                                            <form method="POST" action="{{ $url }}" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="{{ $classes }} inline-flex items-center" onclick="return confirm('{{ $action['confirm'] ?? 'Are you sure?' }}')">
                                                    {!! $icon !!}
                                                    {{ $action['label'] }}
                                                </button>
                                            </form>
                                        @elseif($method === 'GET')
                                            <a href="{{ $url }}" class="{{ $classes }} inline-flex items-center">
                                                {!! $icon !!}
                                                {{ $action['label'] }}
                                            </a>
                                        @else
                                            <form method="POST" action="{{ $url }}" class="inline">
                                                @csrf
                                                @method($method)
                                                <button type="submit" class="{{ $classes }} inline-flex items-center">
                                                    {!! $icon !!}
                                                    {{ $action['label'] }}
                                                </button>
                                            </form>
                                        @endif
                                    @endforeach
                                </div>
                            </td>
                        @endif
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ count($headers) + (!empty($actions) ? 1 : 0) }}" class="px-6 py-4 text-center text-gray-500">
                            No data available
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>