@extends('layouts.app')

@section('title', 'Hava Durumuna Göre - BakuMeet')

@section('content')
    <div>
        <h2>{{ $emoji }} Hava Durumuna Göre Öneriler</h2>

        <div class="card" style="background-color: #ecf0f1; text-align: center;">
            <p style="font-size: 18px; margin: 5px 0;">Bakü şu an: <strong>{{ $condition }}</strong></p>
            @if ($temperature !== null)
                <p style="font-size: 24px; margin: 5px 0;">🌡️ {{ $temperature }}°C</p>
            @endif
        </div>

        <h3 style="margin: 20px 0 10px;">Bugün İçin Önerilerimiz</h3>

        @if ($establishments->isEmpty())
            <div class="card" style="background-color: #fff3cd; border-left: 4px solid #f39c12;">
                <p>Şu an için uygun öneri bulunamadı.</p>
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
                            @if ($place->image)
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
