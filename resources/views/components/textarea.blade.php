@props(['label', 'placeholder' => '', 'required' => false, 'error' => null, 'value' => null, 'rows' => 3])

<div class="mb-4">
    @if($label)
        <label class="block text-sm font-medium text-gray-700 mb-2">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <textarea
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        {{ $required ? 'required' : '' }}
        {{ $attributes->merge(['class' => 'w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-vertical ' . ($error ? 'border-red-500' : '')]) }}
    >{{ $value }}</textarea>

    @if($error)
        <p class="mt-1 text-sm text-red-600">{{ $error }}</p>
    @endif
</div>