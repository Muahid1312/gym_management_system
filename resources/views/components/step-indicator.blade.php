@props(['steps' => [], 'current' => 1])

<div class="py-4">
    <nav aria-label="Progress">
        <ol class="flex items-center">
            @foreach($steps as $index => $step)
                @php
                    $stepNumber = $index + 1;
                    $isCompleted = $stepNumber < $current;
                    $isCurrent = $stepNumber === $current;
                    $isUpcoming = $stepNumber > $current;
                @endphp

                <li class="relative {{ !$loop->last ? 'pr-8 sm:pr-20' : '' }}">
                    @if(!$loop->last)
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="h-0.5 w-full bg-gray-200"></div>
                        </div>
                    @endif

                    <div class="relative flex h-8 w-8 items-center justify-center rounded-full
                        @if($isCompleted) bg-blue-600
                        @elseif($isCurrent) bg-white border-2 border-blue-600
                        @else bg-gray-200
                        @endif
                    ">
                        @if($isCompleted)
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        @elseif($isCurrent)
                            <span class="text-blue-600 text-sm font-medium">{{ $stepNumber }}</span>
                        @else
                            <span class="text-gray-500 text-sm font-medium">{{ $stepNumber }}</span>
                        @endif
                    </div>

                    <div class="mt-2">
                        <p class="text-xs font-medium
                            @if($isCompleted) text-blue-600
                            @elseif($isCurrent) text-blue-600
                            @else text-gray-500
                            @endif
                        ">
                            {{ $step['title'] }}
                        </p>
                        @if(isset($step['description']))
                            <p class="text-xs text-gray-500 mt-1">{{ $step['description'] }}</p>
                        @endif
                    </div>
                </li>
            @endforeach
        </ol>
    </nav>
</div>