@extends('layouts.admin')

@section('title', 'Giriş')

@section('content')
    <p class="heading" style="font-size: var(--text-title); margin-bottom: 20px; text-align: center;">Admin girişi</p>

    @if ($errors->any())
        <div class="bk-card" style="background: var(--color-danger-tint); border-color: var(--color-danger); padding: 12px 14px; margin-bottom: 14px;">
            @foreach ($errors->all() as $error)
                <p style="font-size: var(--text-meta); color: var(--color-danger-text-on-tint);">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('admin.login.attempt') }}" class="bk-card" style="padding: 16px;">
        @csrf
        <div style="margin-bottom: 12px;">
            <label style="font-size: var(--text-micro); color: var(--color-text-secondary);">E-posta</label><br>
            <input type="email" name="email" required class="bk-input" style="width: 100%;">
        </div>
        <div style="margin-bottom: 16px;">
            <label style="font-size: var(--text-micro); color: var(--color-text-secondary);">Şifre</label><br>
            <input type="password" name="password" required class="bk-input" style="width: 100%;">
        </div>
        <button type="submit" class="bk-btn-primary" style="width: 100%;">Giriş yap</button>
    </form>
@endsection
