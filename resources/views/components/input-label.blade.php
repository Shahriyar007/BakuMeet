@props(['value'])

<label {{ $attributes->merge(['style' => 'font-size: var(--text-micro); color: var(--color-text-secondary); display: block; margin-bottom: 4px;']) }}>
    {{ $value ?? $slot }}
</label>
