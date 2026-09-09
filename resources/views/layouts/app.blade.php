<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BakuMeet')</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }

        header {
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            text-align: center;
        }

        header h1 {
            font-size: 28px;
        }

        nav {
            background-color: #34495e;
            padding: 10px 20px;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-right: 20px;
            font-size: 14px;
        }

        nav a:hover {
            color: #f39c12;
        }

        .container {
            max-width: 1000px;
            margin: 20px auto;
            padding: 0 20px;
        }

        .card {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .card h3 {
            color: #2c3e50;
            margin-bottom: 10px;
        }

        .card p {
            margin-bottom: 8px;
            font-size: 14px;
        }

        .badge {
            display: inline-block;
            background-color: #3498db;
            color: white;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            margin-right: 5px;
        }

        .badge.restaurant {
            background-color: #e74c3c;
        }

        .badge.cafe {
            background-color: #27ae60;
        }

        .rating {
            color: #f39c12;
            font-weight: bold;
        }

        a.btn {
            display: inline-block;
            background-color: #3498db;
            color: white;
            padding: 8px 15px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            margin-top: 10px;
        }

        a.btn:hover {
            background-color: #2980b9;
        }

        footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 15px;
            margin-top: 40px;
        }
    </style>
</head>

<body>
    <header>
        <h1>🍽️ BakuMeet</h1>
        <p>Bakü'deki Restoranlar ve Kafeler</p>
    </header>

   <nav>
        <a href="/">Anasayfa</a>
        <a href="/establishments">Tüm İşletmeler</a>
        <a href="/establishments/map/view">🗺️ Harita</a>
        <a href="/collections">📚 Koleksiyonlar</a>
        <a href="/nearby">📍 Yakınımdakiler</a>
	<a href="/areas">🗺️ Bölgeler</a>
        <a href="/trending">🔥 Trend</a>
	@auth
            <a href="/favorites">❤️ Favorilerim</a>
            <a href="/logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Çıkış Yap</a>
            <form id="logout-form" action="/logout" method="POST" style="display: none;">
                @csrf
            </form>
        @else
            <a href="/login">Giriş Yap</a>
            <a href="/register">Kayıt Ol</a>
        @endauth
    </nav>

    <div class="container">

        @if ($errors->any())
            <div class="card" style="background-color: #ffebee; border-left: 4px solid #e74c3c;">
                <strong style="color: #e74c3c;">Hata:</strong>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')

    </div>

    <footer>
        <p>&copy; 2026 BakuMeet. Tüm hakları saklıdır.</p>
    </footer>
@stack('scripts')
</body>
</html>
