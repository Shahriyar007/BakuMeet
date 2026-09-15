<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BakuMeet')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@400;500&family=Inter:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/design-system.css') }}">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        a { color: inherit; }
        .container { max-width: 480px; margin: 0 auto; padding: 0 16px 90px; }
        .top-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 16px; background: var(--color-bg); position: sticky; top: 0; z-index: 10;
            border-bottom: 0.5px solid var(--color-border);
        }
        .bottom-nav-fixed {
            position: fixed; bottom: 0; left: 0; right: 0; max-width: 480px; margin: 0 auto;
            background: var(--color-bg); z-index: 20;
        }
        .rating { color: var(--color-accent); font-weight: var(--weight-medium); }
        a.btn { display: inline-flex; align-items: center; gap: 6px; background: var(--color-accent); color: #fff; padding: 10px 16px; border-radius: var(--radius-control); text-decoration: none; font-size: var(--text-secondary); font-weight: var(--weight-medium); }
        .badge { display: inline-flex; align-items: center; gap: 4px; background: #F1E9DE; color: var(--color-text-muted); padding: 4px 10px; border-radius: var(--radius-chip); font-size: var(--text-meta); margin-right: 5px; }
    </style>
</head>

<body>
    <header class="top-header">
        <a href="{{ route('home') }}" class="heading" style="font-size: 18px; text-decoration: none;">BakuMeet</a>
        @auth
            <a href="{{ route('profile.edit') }}" style="width: 32px; height: 32px; border-radius: 50%; background: var(--color-accent-tint); color: var(--color-accent-text-on-tint); display: flex; align-items: center; justify-content: center; font-weight: var(--weight-medium); font-size: 13px; text-decoration: none;">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </a>
        @else
	<a href="{{ route('auth.gate') }}" class="bk-chip bk-chip--active" style="text-decoration: none;">Giriş yap</a>
        @endauth
    </header>

    <div class="container">

        @if ($errors->any())
            <div class="bk-card" style="background: var(--color-danger-tint); border-color: var(--color-danger); padding: 14px; margin-top: 12px;">
                <strong style="color: var(--color-danger-text-on-tint);">Hata:</strong>
                <ul style="margin-left: 18px; color: var(--color-danger-text-on-tint);">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')

    </div>

    <nav class="bottom-nav-fixed">
        <div class="bk-bottom-nav">
            <a href="{{ route('home') }}" class="bk-bottom-nav__item {{ request()->routeIs('home') ? 'bk-bottom-nav__item--active' : '' }}" style="text-decoration: none;">
                <i class="ti ti-home" style="font-size: 20px;" aria-hidden="true"></i>Keşfet
            </a>
            <a href="{{ url('/establishments/map/view') }}" class="bk-bottom-nav__item" style="text-decoration: none;">
                <i class="ti ti-map" style="font-size: 20px;" aria-hidden="true"></i>Harita
            </a>
            <a href="{{ route('favorites.index') }}" class="bk-bottom-nav__item {{ request()->routeIs('favorites.index') ? 'bk-bottom-nav__item--active' : '' }}" style="text-decoration: none;">
                <i class="ti ti-heart" style="font-size: 20px;" aria-hidden="true"></i>Kaydedilen
            </a>
            @auth
                <a href="{{ route('profile.edit') }}" class="bk-bottom-nav__item {{ request()->routeIs('profile.edit') ? 'bk-bottom-nav__item--active' : '' }}" style="text-decoration: none;">
                    <i class="ti ti-user" style="font-size: 20px;" aria-hidden="true"></i>Profil
                </a>
            @else
		<a href="{{ route('auth.gate') }}" class="bk-bottom-nav__item" style="text-decoration: none;">
                    <i class="ti ti-user" style="font-size: 20px;" aria-hidden="true"></i>Giriş
                </a>
            @endauth
        </div>
    </nav>

@stack('scripts')
</body>
</html>
