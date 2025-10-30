@props([
    'title',
    'value',
    'icon' => null,
    'color' => 'primary',
    'hint' => null,
    'href' => null,
])

@php
    $cardClasses = "card custom-card widget-cardl {$color}";
    $avatarClasses = "avatar avatar-md bg-{$color}";
    $valueClasses = "fw-semibold {$color} mb-0";
@endphp

<div {{ $attributes->merge(['class' => $cardClasses]) }}>
    <div class="card-body">
        <div class="d-flex align-items-start justify-content-between mb-2">
            <div class="flex-fill">
                <div class="mb-2">{{ $title }}</div>
                @if ($href)
                    <a href="{{ $href }}" class="text-reset text-decoration-none">
                        <h4 class="{{ $valueClasses }}">{{ $value }}</h4>
                    </a>
                @else
                    <h4 class="{{ $valueClasses }}">{{ $value }}</h4>
                @endif
            </div>
            @if ($icon)
                <div>
                    <span class="{{ $avatarClasses }}">
                        <i class="{{ $icon }} fs-5"></i>
                    </span>
                </div>
            @endif
        </div>
        @if ($hint)
            <div class="text-muted">{{ $hint }}</div>
        @else
            <div class="text-muted">&nbsp;</div>
        @endif
    </div>
</div>
