@props(['title', 'value', 'change' => null, 'changeType' => 'positive', 'icon' => null])

<div class="bg-white overflow-hidden shadow rounded-lg">
    <div class="p-5">
        <div class="flex items-center">
            <div class="flex-1">
                <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">{{ $title }}</dt>
                    <dd class="text-lg font-medium text-gray-900">{{ $value }}</dd>
                </dl>
            </div>
            @if($icon)
                <div class="flex-shrink-0">
                    <div class="text-2xl text-gray-400">
                        {!! $icon !!}
                    </div>
                </div>
            @endif
        </div>
        @if($change)
            <div class="mt-4">
                <div class="flex items-center text-sm">
                    @if($changeType === 'positive')
                        <svg class="flex-shrink-0 h-4 w-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 9.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 7.414V15a1 1 0 11-2 0V7.414L6.707 9.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="ml-1 text-green-600">{{ $change }}</span>
                    @elseif($changeType === 'negative')
                        <svg class="flex-shrink-0 h-4 w-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M14.707 10.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 12.586V5a1 1 0 012 0v7.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="ml-1 text-red-600">{{ $change }}</span>
                    @else
                        <span class="text-gray-500">{{ $change }}</span>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>