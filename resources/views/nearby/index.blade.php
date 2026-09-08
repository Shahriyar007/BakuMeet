@extends('layouts.app')

@section('title', 'Yakınımdakiler - BakuMeet')

@section('content')
    <div>
        <h2>📍 Yakınımdakiler</h2>

        <div class="card" style="background-color: #ecf0f1; margin-bottom: 20px;">
            <p id="status-text">Konumunuz alınıyor...</p>
            <button id="retry-btn" onclick="getLocation()" style="display:none; padding: 10px; background-color: #3498db; color: white; border: none; border-radius: 4px; font-size: 14px; cursor: pointer;">
                📍 Konumu Tekrar Dene
            </button>

            @if ($lat && $lng)
                <form action="/nearby" method="GET" style="display: grid; gap: 10px; margin-top: 15px;">
                    <input type="hidden" name="lat" value="{{ $lat }}">
                    <input type="hidden" name="lng" value="{{ $lng }}">

                    <div>
                        <label for="radius"><strong>Mesafe:</strong></label><br>
                        <select name="radius" id="radius" style="padding: 8px; font-size: 14px; width: 100%; margin-top: 5px;">
                            <option value="1" {{ $radius == 1 ? 'selected' : '' }}>1 km</option>
                            <option value="2" {{ $radius == 2 ? 'selected' : '' }}>2 km</option>
                            <option value="5" {{ $radius == 5 ? 'selected' : '' }}>5 km</option>
                            <option value="10" {{ $radius == 10 ? 'selected' : '' }}>10 km</option>
                        </select>
                    </div>

                    <div>
                        <label for="type"><strong>Tür:</strong></label><br>
                        <select name="type" id="type" style="padding: 8px; font-size: 14px; width: 100%; margin-top: 5px;">
                            <option value="">-- Tümü --</option>
                            <option value="restaurant" {{ $type == 'restaurant' ? 'selected' : '' }}>🍽️ Restoran</option>
                            <option value="cafe" {{ $type == 'cafe' ? 'selected' : '' }}>☕ Kafe</option>
                        </select>
                    </div>

                    <button type="submit" style="padding: 10px; background-color: #3498db; color: white; border: none; border-radius: 4px; font-size: 14px; cursor: pointer;">
                        🔍 Filtrele
                    </button>
                </form>
            @endif
        </div>

        @if ($lat && $lng)
            <div id="map" style="width: 100%; height: 300px; border-radius: 8px; margin-bottom: 20px;"></div>

            @if ($establishments->isEmpty())
                <div class="card" style="background-color: #fff3cd; border-left: 4px solid #f39c12;">
                    <p>Bu mesafede işletme bulunamadı. Mesafeyi artırmayı deneyin.</p>
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
                                        @elseif ($place->type === 'cafe')
                                            ☕ Kafe
                                        @endif
                                    </span>
                                    <span class="badge">📍 {{ $place->location }}</span>
                                    <span class="badge">🎭 {{ $place->mood }}</span>
                                    <span class="badge">{{ str_repeat('₼', $place->price_range) }}</span>
                                    <span class="badge" style="background-color: #2ecc71; color: white;">🚶 {{ $place->distance_km }} km</span>
                                </p>

                                <p>
                                    <strong>Puanı:</strong>
                                    <span class="rating">⭐ {{ $place->rating ?? 'Henüz puanlanmamış' }}</span>
                                </p>

                                <a href="/establishments/{{ $place->id }}" class="btn">Detaylar</a>
                            </div>

                            <div>
                                @if ($place->image)
                                    <img src="{{ $place->image }}" alt="{{ $place->name }}" style="width: 150px; height: 150px; border-radius: 8px; object-fit: cover;">
                                @else
                                    <div style="width: 150px; height: 150px; border-radius: 8px; background-color: {{ $place->type === 'restaurant' ? '#fce4e4' : '#e4f7e9' }}; display: flex; al
