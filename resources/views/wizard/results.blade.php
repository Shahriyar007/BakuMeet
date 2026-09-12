@extends('layouts.app')

@section('title', 'Önerilerin - BakuMeet')

@section('content')
    <div>
        <a href="/wizard" style="color: #3498db; text-decoration: none;">← Tekrar Dene</a>
        <h2>✨ Senin İçin Önerdiklerimiz</h2>

        @if ($establishments->isEmpty())
            <div class="card" style="background-color: #fff3cd; border-left: 4px solid #f39c12;">
                <p>Bu kriterlere uygun mekan bulunamadı. Farklı seçeneklerle tekrar dene.</p>
            </div>
        @else
            @foreach ($establishments as $index => $place)
                <div class="card">
                    <div style="display: flex; justify-content: space-between; align-items: start;">
                        <div>
                            <h3>#{{ $index + 1 }} · {{ $place->name }}</h3>
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
                                <span class="badge">{{ str_repeat('₼', $place->price_range) }}</span>
                                @if (isset($place->distance_km))
                                    <span class="badge">🚶 {{ $place->distance_km }} km</span>
                                @endif
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
