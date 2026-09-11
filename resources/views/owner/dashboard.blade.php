@extends('layouts.owner')

@section('title', 'Panel')

@section('content')
    <h1>Merhaba, {{ $account->name }}</h1>

    @if ($account->isPending())
        <div style="background: #fff8e1; padding: 16px; border-radius: 6px;">
            <p><strong>Başvurunuz inceleniyor.</strong></p>
            <p>Onaylandığında bu sayfadan işletmenizi ekleyebileceksiniz.</p>
        </div>
    @elseif (! $establishment)
        <div style="background: #e6f4ff; padding: 16px; border-radius: 6px;">
            <p>Hesabınız onaylandı. Henüz bir işletme eklemediniz.</p>
            <a href="#" style="display: inline-block; margin-top: 8px; padding: 10px 20px; background: #222; color: white; border-radius: 4px; text-decoration: none;">+ İşletme Ekle</a>
        </div>
    @else
        <div style="background: white; padding: 16px; border-radius: 6px;">
            <h2>{{ $establishment->name }}</h2>
            <p>Durum: {{ $establishment->status ?? 'Yayında' }}</p>
        </div>
    @endif
@endsection
