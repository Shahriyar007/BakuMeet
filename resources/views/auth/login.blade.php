<x-guest-layout>
    <p class="heading" style="font-size: 22px; margin-bottom: 4px; text-align: center;">Tekrar hoş geldin</p>
    <p style="font-size: var(--text-secondary); color: var(--color-text-secondary); text-align: center; margin-bottom: 20px;">Favorilerin ve önerilerin seni bekliyor</p>

    <x-auth-session-status :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div style="margin-bottom: 14px;">
            <x-input-label for="email" value="E-posta" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div style="margin-bottom: 10px;">
            <x-input-label for="password" value="Şifre" />
            <x-text-input id="password" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div style="text-align: right; margin-bottom: 18px;">
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" style="font-size: var(--text-meta); color: var(--color-accent); text-decoration: none;">Şifremi unuttum</a>
            @endif
        </div>

        <x-primary-button style="width: 100%; margin-bottom: 14px;">Giriş yap</x-primary-button>

        <div style="text-align: center;">
            <label style="display: inline-flex; align-items: center; gap: 6px; font-size: var(--text-meta); color: var(--color-text-secondary);">
                <input type="checkbox" name="remember">Beni hatırla
            </label>
        </div>
    </form>

    <p style="font-size: var(--text-secondary); color: var(--color-text-secondary); text-align: center; margin-top: 18px;">
        Hesabın yok mu? <a href="{{ route('register') }}" style="color: var(--color-accent); font-weight: var(--weight-medium); text-decoration: none;">Kayıt ol</a>
    </p>
</x-guest-layout>
