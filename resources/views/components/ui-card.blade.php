@props(['title' => null, 'subtitle' => null, 'noPadding' => false])

<div {{ $attributes->merge(['class' => 'card' . ($noPadding ? ' p-0' : '')]) }}>
    @if($title || $subtitle)
        <div class="card-header">
            @if($title)
                <h2 class="card-title">{{ $title }}</h2>
            @endif
            @if($subtitle)
                <p class="page-subtitle" style="margin: 8px 0 0 0;">{{ $subtitle }}</p>
            @endif
        </div>
    @endif
    {{ $slot }}
</div>
