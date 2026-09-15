@props(['messages'])

@if ($messages)
    <ul {{ $attributes->merge(['style' => 'margin: 4px 0 0; padding-left: 16px;']) }}>
        @foreach ((array) $messages as $message)
            <li style="font-size: var(--text-micro); color: var(--color-danger);">{{ $message }}</li>
        @endforeach
    </ul>
@endif
