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
            @endforeach
        @endif
    </div>
@endsection
