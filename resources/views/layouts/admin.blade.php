<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Paneli') - BakuMeet</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@400;500&family=Inter:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/design-system.css') }}">
    <style>
        body { background: var(--color-bg-muted) !important; }
    </style>
</head>
<body>
    <header style="background: var(--color-bg-muted); padding: 14px 16px; display: flex; justify-content: space-between; align-items: center; border-bottom: 0.5px solid var(--color-border-muted);">
        <span class="heading" style="font-size: 16px;">BakuMeet admin paneli</span>
        @auth('admin')
            <form method="POST" action="{{ route('admin.logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="bk-btn-secondary" style="min-height: auto; padding: 6px 12px; font-size: var(--text-meta);">Çıkış yap</button>
            </form>
        @endauth
    </header>

    <main style="max-width: 600px; margin: 0 auto; padding: 16px;">
        @if (session('status'))
            <div class="bk-card" style="background: var(--color-success-tint); border-color: var(--color-success); padding: 12px 14px; margin-bottom: 14px;">
                <p style="font-size: var(--text-secondary); color: var(--color-success-text-on-tint);">{{ session('status') }}</p>
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
