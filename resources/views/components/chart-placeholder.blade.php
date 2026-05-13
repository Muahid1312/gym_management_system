@props(['title', 'height' => '300px', 'type' => 'bar'])

<div class="bg-white p-6 rounded-lg shadow border border-gray-200">
    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ $title }}</h3>

    <div class="relative" style="height: {{ $height }}">
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Chart Coming Soon</h3>
                <p class="mt-1 text-sm text-gray-500">
                    @if($type === 'bar')
                        Bar chart visualization will be displayed here.
                    @elseif($type === 'line')
                        Line chart visualization will be displayed here.
                    @elseif($type === 'pie')
                        Pie chart visualization will be displayed here.
                    @else
                        Chart visualization will be displayed here.
                    @endif
                </p>
            </div>
        </div>

        <!-- Placeholder bars/lines for visual reference -->
        @if($type === 'bar')
            <div class="absolute bottom-0 left-0 right-0 flex items-end justify-around px-4 pb-4">
                @for($i = 0; $i < 5; $i++)
                    <div class="bg-gray-200 rounded-t animate-pulse" style="width: 20%; height: {{ rand(20, 80) }}%;"></div>
                @endfor
            </div>
        @elseif($type === 'line')
            <div class="absolute inset-0 p-4">
                <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <path d="M0,50 Q25,{{ rand(20, 80) }} 50,{{ rand(20, 80) }} T100,{{ rand(20, 80) }}" stroke="#e5e7eb" stroke-width="2" fill="none" class="animate-pulse"/>
                </svg>
            </div>
        @elseif($type === 'pie')
            <div class="absolute inset-0 flex items-center justify-center">
                <svg class="w-32 h-32" viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="40" fill="#e5e7eb" class="animate-pulse"/>
                    <circle cx="50" cy="50" r="40" fill="none" stroke="#d1d5db" stroke-width="2"/>
                </svg>
            </div>
        @endif
    </div>
</div>