<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'İşletme Paneli') - BakuMeet</title>
</head>
<body style="font-family: sans-serif; margin: 0; background: #f5f5f5;">
    <header style="background: #222; color: white; padding: 12px 16px; display: flex; justify-content: space-between; align-items: center;">
        <strong>BakuMeet İşletme Paneli</strong>
        @auth('business')
            <form method="POST" action="{{ route('owner.logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" style="background: none; border: 1px solid white; color: white; padding: 6px 12px; border-radius: 4px;">Çıkış Yap</button>
            </form>
        @endauth
    </header>

    <main style="max-width: 600px; margin: 20px auto; padding: 0 16px;">
        @if (session('status'))
            <p style="background: #e6ffed; padding: 10px; border-radius: 4px;">{{ session('status') }}</p>
        @endif

        @yield('content')
    </main>
</body>
</html>
