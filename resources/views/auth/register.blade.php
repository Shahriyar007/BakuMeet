<x-guest-layout>
    <p class="heading" style="font-size: 22px; margin-bottom: 4px; text-align: center;">Hesap oluştur</p>
    <p style="font-size: var(--text-secondary); color: var(--color-text-secondary); text-align: center; margin-bottom: 20px;">Birkaç saniyede keşfetmeye başla</p>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div style="margin-bottom: 14px;">
            <x-input-label for="name" value="Ad" />
            <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" />
        </div>

        <div style="margin-bottom: 14px;">
            <x-input-label for="email" value="E-posta" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        <div style="margin-bottom: 14px;">
            <x-input-label for="password" value="Şifre" />
            <x-text-input id="password" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        <div style="margin-bottom: 18px;">
            <x-input-label for="password_confirmation" value="Şifre (tekrar)" />
            <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>

        <x-primary-button style="width: 100%; margin-bottom: 14px;">Kayıt ol</x-primary-button>
    </form>

    <p style="font-size: var(--text-secondary); color: var(--color-text-secondary); text-align: center;">
        Zaten hesabın var mı? <a href="{{ route('login') }}" style="color: var(--color-accent); font-weight: var(--weight-medium); text-decoration: none;">Giriş yap</a>
    </p>
</x-guest-layout>
