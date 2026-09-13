@extends('layouts.app')

@section('title', 'Senin İçin - BakuMeet')

@section('content')
    <div>
        <h2>💡 Beğendiklerine Benzer</h2>
        <p style="color: #999; margin-bottom: 20px;">Favorilerine bakarak seçtiğimiz öneriler.</p>

        @if ($establishments->isEmpty())
            <div class="card" style="background-color: #fff3cd; border-left: 4px solid #f39c12;">
                <p>Henüz yeterli favori mekanın yok. Birkaç mekanı favorile, sana özel öneriler burada görünecek.</p>
                <a href="/establishments" class="btn" style="margin-top: 10px; display: inline-block;">Mekanları Keşfet</a>
            </div>
        @else
            @foreach ($establishments as $place)
                <x-establishment-card :place="$place" />
            @endforeach
        @endif
    </div>
@endsection
