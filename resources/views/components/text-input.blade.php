@props(['disabled' => false])

@php
    $fieldName = $attributes->get('name');
    $hasError = $fieldName && $errors->has($fieldName);
@endphp

<input @disabled($disabled) {!! $attributes->merge([
    'class' => 'bk-input',
    'style' => 'width: 100%; margin-bottom: 4px;' . ($hasError ? ' border-color: var(--color-danger);' : ''),
]) !!}>
