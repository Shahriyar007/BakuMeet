@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['style' => 'background: var(--color-success-tint); color: var(--color-success-text-on-tint); padding: 10px 12px; border-radius: var(--radius-control); font-size: var(--text-secondary); margin-bottom: 12px;']) }}>
        {{ $status }}
    </div>
@endif
