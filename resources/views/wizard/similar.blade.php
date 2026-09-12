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
                <div class="card">
                    <div style="display: flex; justify-content: space-between; align-items: start;">
                        <div>
                            <h3>{{ $place->name }}</h3>
                            <p>
                                <span class="badge {{ $place->type }}">
                                    @if ($place->type === 'restaurant')
                                        🍽️ Restoran
                                    @else
                                        ☕ Kafe
                                    @endif
                                </span>
                                <span class="badge">📍 {{ $place->location }}</span>
                                <span class="badge">🎭 {{ $place->mood }}</span>
                            </p>
                            <p><span class="rating">⭐ {{ $place->rating ?? 'Henüz puanlanmamış' }}</span></p>
                            <a href="/establishments/{{ $place->id }}" class="btn">Detaylar</a>
                        </div>
                        <div>
			@if ($place->primaryPhoto)
                                <img src="{{ $place->primaryPhoto->url() }}" alt="{{ $place->name }}" style="width: 100px; height: 100px; border-radius: 8px; object-fit: cover;">
                            @elseif ($place->image)
                                <img src="{{ $place->image }}" alt="{{ $place->name }}" style="width: 100px; height: 100px; border-radius: 8px; object-fit: cover;">
                            @else
                                <div style="width: 100px; height: 100px; border-radius: 8px; background-color: {{ $place->type === 'restaurant' ? '#fce4e4' : '#e4f7e9' }}; display: flex; align-items: center; justify-content: center; font-size: 36px;">
                                    {{ $place->type === 'restaurant' ? '🍽️' : '☕' }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
@endsection
