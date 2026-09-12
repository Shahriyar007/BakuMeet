@extends('layouts.app')

@section('title', 'Favorilerim - BakuMeet')

@section('content')
    <div>
        <h2>❤️ Favorilerim</h2>

        @if ($favorites->isEmpty())
            <div class="card" style="background-color: #fff3cd; border-left: 4px solid #f39c12; margin-top: 15px;">
                <p>Henüz favori işletmeniz yok.</p>
                <a href="/establishments" class="btn" style="margin-top: 10px;">İşletmeleri Keşfet</a>
            </div>
        @else
            @foreach ($favorites as $place)
                <div class="card" style="margin-top: 15px;">
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
                            <p><strong>Puanı:</strong> <span class="rating">⭐ {{ $place->rating }}</span></p>
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
