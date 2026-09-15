@props(['disabled' => false])

<input @disabled($disabled) {!! $attributes->merge(['class' => 'bk-input', 'style' => 'width: 100%; margin-bottom: 4px;']) !!}>
