<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>İşletme Girişi - BakuMeet</title>
</head>
<body style="font-family: sans-serif; max-width: 400px; margin: 40px auto; padding: 0 16px;">
    <h1>İşletme Girişi</h1>

    @if (session('status'))
        <p style="background: #e6ffed; padding: 10px; border-radius: 4px;">{{ session('status') }}</p>
    @endif

    @if ($errors->any())
        <div style="background: #ffe6e6; padding: 10px; border-radius: 4px;">
            @foreach ($errors->all() as $error)
                <p style="margin: 0;">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('owner.login.attempt') }}">
        @csrf
        <div style="margin-bottom: 12px;">
            <label>E-posta</label><br>
            <input type="email" name="email" value="{{ old('email') }}" required style="width: 100%; padding: 8px;">
        </div>
        <div style="margin-bottom: 12px;">
            <label>Şifre</label><br>
            <input type="password" name="password" required style="width: 100%; padding: 8px;">
        </div>
        <div style="margin-bottom: 12px;">
            <label><input type="checkbox" name="remember"> Beni hatırla</label>
        </div>
        <button type="submit" style="padding: 10px 20px;">Giriş Yap</button>
    </form>

    <p><a href="{{ route('owner.register') }}">İşletmeniz mi var? Başvuru yapın</a></p>
</body>
</html>
