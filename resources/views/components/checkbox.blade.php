@props(['label', 'name', 'value' => null, 'checked' => false, 'required' => false, 'error' => null])

<div class="mb-4">
    <div class="flex items-start">
        <div class="flex items-center h-5">
            <input
                id="{{ $name }}"
                name="{{ $name }}"
                type="checkbox"
                value="{{ $value ?? 1 }}"
                {{ $checked ? 'checked' : '' }}
                {{ $required ? 'required' : '' }}
                class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded"
                {{ $attributes }}
            >
        </div>
        @if($label)
            <div class="ml-3 text-sm">
                <label for="{{ $name }}" class="text-gray-700 font-medium">
                    {{ $label }}
                    @if($required)
                        <span class="text-red-500">*</span>
                    @endif
                </label>
            </div>
        @endif
    </div>

    @if($error)
        <p class="mt-1 text-sm text-red-600">{{ $error }}</p>
    @endif
</div>