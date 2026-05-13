@props(['label', 'options' => [], 'placeholder' => 'Select an option', 'required' => false, 'error' => null, 'value' => null])

<div class="mb-4">
    @if($label)
        <label class="block text-sm font-medium text-gray-700 mb-2">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <select {{ $required ? 'required' : '' }} {{ $attributes->merge(['class' => 'w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white ' . ($error ? 'border-red-500' : '')]) }}>
        @if($placeholder)
            <option value="" disabled {{ !$value ? 'selected' : '' }}>{{ $placeholder }}</option>
        @endif

        @foreach($options as $key => $option)
            @if(is_array($option))
                <optgroup label="{{ $key }}">
                    @foreach($option as $subKey => $subOption)
                        <option value="{{ $subKey }}" {{ $value == $subKey ? 'selected' : '' }}>
                            {{ $subOption }}
                        </option>
                    @endforeach
                </optgroup>
            @else
                <option value="{{ $key }}" {{ $value == $key ? 'selected' : '' }}>
                    {{ $option }}
                </option>
            @endif
        @endforeach
    </select>

    @if($error)
        <p class="mt-1 text-sm text-red-600">{{ $error }}</p>
    @endif
</div>