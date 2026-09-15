<!DOCTYPE html>
<html lang="tr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'BakuMeet') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@400;500&family=Inter:wght@400;500&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">
        <link rel="stylesheet" href="{{ asset('css/design-system.css') }}">
    </head>
    <body>
        <div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; padding: 24px 16px;">
            <div style="width: 100%; max-width: 360px;">
                <div style="text-align: center; margin-bottom: 20px;">
                    <a href="/" class="heading" style="font-size: 22px; text-decoration: none;">BakuMeet</a>
                </div>
                <div class="bk-card" style="padding: 24px 20px;">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
