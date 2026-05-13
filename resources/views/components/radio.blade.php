@props(['label', 'name', 'options' => [], 'value' => null, 'required' => false, 'error' => null])

<div class="mb-4">
    @if($label)
        <fieldset>
            <legend class="text-sm font-medium text-gray-700 mb-2">
                {{ $label }}
                @if($required)
                    <span class="text-red-500">*</span>
                @endif
            </legend>
        @endif

        <div class="space-y-2">
            @foreach($options as $optionValue => $optionLabel)
                <div class="flex items-center">
                    <input
                        id="{{ $name }}_{{ $optionValue }}"
                        name="{{ $name }}"
                        type="radio"
                        value="{{ $optionValue }}"
                        {{ $value == $optionValue ? 'checked' : '' }}
                        {{ $required ? 'required' : '' }}
                        class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300"
                    >
                    <label for="{{ $name }}_{{ $optionValue }}" class="ml-3 block text-sm font-medium text-gray-700">
                        {{ $optionLabel }}
                    </label>
                </div>
            @endforeach
        </div>

        @if($label)
        </fieldset>
    @endif

    @if($error)
        <p class="mt-1 text-sm text-red-600">{{ $error }}</p>
    @endif
</div>