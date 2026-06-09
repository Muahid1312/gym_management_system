<?php /** @var string $title */ ?>
<?php /** @var string $value */ ?>
<?php /** @var string $trend */ ?>
<?php /** @var string $trendLabel */ ?>
<?php /** @var string $icon */ ?>
<?php /** @var string $color */ ?>

<div class="stat-card">
    <div class="stat-icon {{ $color }}">
        @switch($icon)
            @case('user')
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 001.591-.079 8.988 8.988 0 011.949 1.379M15 19.128v-.008a9.46 9.46 0 00-3.608-9.375m0 0a3.75 3.75 0 11-7.5 0m7.5 0a3.75 3.75 0 11-7.5 0m6 0h.008v.008h-.008v-.008zm0 0h6m-6 0v6m0-6v-6" />
                </svg>
                @break
            @case('check')
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.052-.143z" clip-rule="evenodd" />
                </svg>
                @break
            @case('card')
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm4.5-5.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm4.5-5.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm4.5-5.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008v-.008z" />
                </svg>
                @break
            @case('attendance')
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path fill-rule="evenodd" d="M9 9a3 3 0 119.194-1.045 1.5 1.5 0 01-1.02 1.97l-.464.093a1.5 1.5 0 00-1.262 1.889l.158 1.423a1.5 1.5 0 01-1.403 1.762h-.846a1.5 1.5 0 01-1.5-1.5V9a.75.75 0 00-.75-.75H9z" clip-rule="evenodd" />
                </svg>
                @break
            @default
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 001.591-.079 8.988 8.988 0 011.949 1.379M15 19.128v-.008a9.46 9.46 0 00-3.608-9.375m0 0a3.75 3.75 0 11-7.5 0m7.5 0a3.75 3.75 0 11-7.5 0m6 0h.008v.008h-.008v-.008zm0 0h6m-6 0v6m0-6v-6" />
                </svg>
        @endswitch
    </div>
    <div class="stat-content">
        <h3>{{ $title }}</h3>
        <p>{{ $value }}</p>
        <div class="stat-trend positive">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width: 14px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7 16.5h6m6-3H9.75m15-3v12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 16.5v-12m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V3m0 5.25v12" />
            </svg>
            {{ $trend }} {{ $trendLabel }}
        </div>
    </div>
</div>
