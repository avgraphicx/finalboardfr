<div>
    <div class="card custom-card widget-cardl {{ $color ?? 'primary' }}">
        <div class="card-body">
            <div class="d-flex align-items-start justify-content-between mb-2">
                <div class="flex-fill">
                    <div class="mb-2">{{ $label }}</div>
                    <h4 class="fw-semibold {{ $color ?? 'primary' }} mb-0">
                        @if (!empty($is_money))
                            ${{ number_format($value ?? 0, 2) }}
                        @else
                            {{ $value ?? 0 }}
                        @endif
                    </h4>
                    @if (!empty($meta))
                        <div class="text-muted">{{ $meta }}</div>
                    @endif
                </div>
                <div>
                    <span class="avatar avatar-md bg-{{ $color ?? 'primary' }}">
                        <i class="{{ $icon ?? 'ri-dashboard-line' }} fs-5" aria-hidden="true"></i>
                    </span>
                </div>
            </div>
            <div class="text-muted">&nbsp;</div>
        </div>
    </div>
</div>
