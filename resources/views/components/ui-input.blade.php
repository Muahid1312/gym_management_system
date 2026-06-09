@props(['name', 'label' => null, 'type' => 'text', 'placeholder' => null, 'value' => null, 'error' => null, 'disabled' => false])

<div class="form-group">
    @if($label)
        <label for="{{ $name }}">{{ $label }}</label>
    @endif
    <input 
        type="{{ $type }}" 
        id="{{ $name }}"
        name="{{ $name }}"
        placeholder="{{ $placeholder }}"
        value="{{ $value ?? old($name) }}"
        {{ $disabled ? 'disabled' : '' }}
        {{ $attributes }}
    >
    @if($error)
        <small style="color: var(--danger); display: block; margin-top: 4px;">{{ $error }}</small>
    @endif
</div>
