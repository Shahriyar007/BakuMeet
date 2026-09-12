@extends('layouts.app')

@section('title', 'Trend Mekanlar - BakuMeet')

@section('content')
    <div>
        <h2>🔥 Trend Mekanlar</h2>
        <p style="color: #999; margin-bottom: 20px;">Puan, yorum ve favori sayısına göre en çok ilgi gören mekanlar.</p>

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
                        </p>
                        <p>
                            <span class="rating">⭐ {{ $place->rating }}</span>
                            <span class="badge">💬 {{ $place->reviews_count }} yorum</span>
                            <span class="badge">❤️ {{ $place->favorited_by_count }} favori</span>
                        </p>
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
    </div>
@endsection
