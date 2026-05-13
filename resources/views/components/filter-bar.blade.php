@props(['filters' => []])

@if(!empty($filters))
    <div class="bg-white px-4 py-3 border-b border-gray-200 sm:px-6">
        <div class="flex flex-wrap items-center gap-4">
            @foreach($filters as $filter)
                <div class="flex items-center space-x-2">
                    @if($filter['type'] === 'select')
                        <label for="{{ $filter['name'] }}" class="text-sm font-medium text-gray-700">
                            {{ $filter['label'] }}:
                        </label>
                        <select
                            name="{{ $filter['name'] }}"
                            id="{{ $filter['name'] }}"
                            class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"
                            onchange="this.form.submit()"
                        >
                            @if(isset($filter['placeholder']))
                                <option value="">{{ $filter['placeholder'] }}</option>
                            @endif
                            @foreach($filter['options'] as $value => $label)
                                <option value="{{ $value }}" {{ request($filter['name']) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    @elseif($filter['type'] === 'search')
                        <x-search-input
                            name="{{ $filter['name'] }}"
                            placeholder="{{ $filter['placeholder'] ?? 'Search...' }}"
                            value="{{ request($filter['name']) }}"
                            class="w-64"
                        />
                    @elseif($filter['type'] === 'date')
                        <label for="{{ $filter['name'] }}" class="text-sm font-medium text-gray-700">
                            {{ $filter['label'] }}:
                        </label>
                        <input
                            type="date"
                            name="{{ $filter['name'] }}"
                            id="{{ $filter['name'] }}"
                            value="{{ request($filter['name']) }}"
                            class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm"
                            onchange="this.form.submit()"
                        >
                    @endif
                </div>
            @endforeach

            @if(request()->hasAny(array_column($filters, 'name')))
                <a href="{{ request()->url() }}" class="text-sm text-blue-600 hover:text-blue-500">
                    Clear filters
                </a>
            @endif
        </div>
    </div>
@endif