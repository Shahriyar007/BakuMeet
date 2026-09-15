<button {{ $attributes->merge(['type' => 'submit', 'class' => 'bk-btn-primary']) }}>
    {{ $slot }}
</button>
