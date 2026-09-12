@extends('layouts.app')

@section('title', 'Yakınımdakiler - BakuMeet')

@section('content')
<div>
<h2>📍 Yakınımdakiler</h2>

    <div class="card" style="background-color: #ecf0f1; margin-bottom: 20px;">
        <p id="status-text">Konumunuz alınıyor...</p>

        <button id="retry-btn" onclick="getLocation()" style="display: none; padding: 10px 20px;">
            📍 Konumu Tekrar Dene
        </button>

        @if ($lat && $lng)
            <form action="/nearby" method="GET" style="display: flex; gap: 15px; flex-wrap: wrap; align-items: end;">
                <input type="hidden" name="lat" value="{{ $lat }}">
                <input type="hidden" name="lng" value="{{ $lng }}">

                <div>
                    <label for="radius"><strong>Mesafe:</strong></label>
                    <select name="radius" id="radius" style="padding: 8px;">
                        <option value="1" {{ $radius == 1 ? 'selected' : '' }}>1 km</option>
                        <option value="2" {{ $radius == 2 ? 'selected' : '' }}>2 km</option>
                        <option value="5" {{ $radius == 5 ? 'selected' : '' }}>5 km</option>
                        <option value="10" {{ $radius == 10 ? 'selected' : '' }}>10 km</option>
                    </select>
                </div>

                <div>
                    <label for="type"><strong>Tür:</strong></label>
                    <select name="type" id="type" style="padding: 8px;">
                        <option value="">-- Tümü --</option>
                        <option value="restaurant" {{ $type == 'restaurant' ? 'selected' : '' }}>🍽️ Restoran</option>
                        <option value="cafe" {{ $type == 'cafe' ? 'selected' : '' }}>☕ Kafe</option>
                    </select>
                </div>

                <button type="submit" style="padding: 10px 20px;">
                    🔍 Filtrele
                </button>
            </form>
        @endif
    </div>

    @if ($lat && $lng)
        <div id="map" style="width: 100%; height: 300px; margin-bottom: 20px; border-radius: 8px;"></div>

        @if ($establishments->isEmpty())
            <div class="card" style="background-color: #fce4e4;">
                <p>Bu mesafede işletme bulunamadı. Mesafeyi artırmayı deneyebilirsiniz.</p>
            </div>
        @else
            @foreach ($establishments as $place)
                <div class="card">
                    <div style="display: flex; justify-content: space-between; gap: 20px; flex-wrap: wrap;">
                        <div>
                            <h3>{{ $place->name }}</h3>

                            <p>
                                <span class="badge {{ $place->type === 'restaurant' ? 'restaurant' : 'cafe' }}">
                                    @if ($place->type === 'restaurant')
                                        🍽️ Restoran
                                    @elseif ($place->type === 'cafe')
                                        ☕ Kafe
                                    @else
                                        📍 {{ ucfirst($place->type) }}
                                    @endif
                                </span>

                                <span class="badge">📍 {{ $place->neighborhood ?? 'Baku' }}</span>

                                <span class="badge">🎭 {{ $place->mood ?? 'Genel' }}</span>

                                <span class="badge">{{ str_repeat('₼', $place->price_range) }}</span>

                                <span class="badge" style="background-color: #2ecc71; color: white;">
                                    🚶 {{ $place->distance_km }} km
                                </span>
                            </p>

                            <p>
                                <strong>Puanı:</strong>
                                <span class="rating">
                                    ⭐ {{ $place->rating ?? 'Henüz puanlanmamış' }}
                                </span>
                            </p>

                            <a href="/establishments/{{ $place->id }}" class="btn">
                                Detaylar
                            </a>
                        </div>

                        <div>
			@if ($place->primaryPhoto)
                                <img
                                    src="{{ $place->primaryPhoto->url() }}"
                                    alt="{{ $place->name }}"
                                    style="width: 150px; height: 150px; border-radius: 8px; object-fit: cover;"
                                >
                            @elseif ($place->image)
                                <img
                                    src="{{ $place->image }}"
                                    alt="{{ $place->name }}"
                                    style="width: 150px; height: 150px; border-radius: 8px; object-fit: cover;"
                                >
                            @else
                                <div style="width: 150px; height: 150px; border-radius: 8px; background-color: {{ $place->type === 'restaurant' ? '#fce4e4' : '#e4f7e9' }}; display: flex; align-items: center; justify-content: center; font-size: 48px;">
                                    {{ $place->type === 'restaurant' ? '🍽️' : '☕' }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    @endif
</div>

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css">

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    function getLocation() {
        document.getElementById('status-text').innerText = 'Konumunuz alınıyor...';
        document.getElementById('retry-btn').style.display = 'none';

        if (!navigator.geolocation) {
            document.getElementById('status-text').innerText =
                'Tarayıcınız konum özelliğini desteklemiyor.';
            return;
        }

        navigator.geolocation.getCurrentPosition(
            function (position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;

                window.location.href =
                    '/nearby?lat=' + lat +
                    '&lng=' + lng +
                    '&radius={{ $radius }}' +
                    '&type={{ $type }}' +
                    '&mood={{ $mood }}';
            },
            function () {
                document.getElementById('status-text').innerText =
                    '⚠️ Konum izni reddedildi. Yakınımdakiler özelliğini kullanmak için konum izni vermeniz gerekiyor.';

                document.getElementById('retry-btn').style.display =
                    'inline-block';
            }
        );
    }

    @if (!$lat || !$lng)
        getLocation();
    @else
        document.getElementById('status-text').innerText =
            '✅ Konumunuz alındı';

        const map = L.map('map').setView(
            [{{ $lat }}, {{ $lng }}],
            14
        );

        L.tileLayer(
            'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
            {
                attribution: '&copy; OpenStreetMap contributors'
            }
        ).addTo(map);

        L.marker(
            [{{ $lat }}, {{ $lng }}],
            {
                icon: L.divIcon({
                    html: '📍',
                    iconSize: [30, 30],
                    className: ''
                })
            }
        )
        .addTo(map)
        .bindPopup('Siz buradasınız');

        @foreach ($establishments as $place)
            L.circleMarker(
                [{{ $place->latitude }}, {{ $place->longitude }}],
                {
                    radius: 8,
                    fillColor: '{{ $place->type === "restaurant" ? "#e74c3c" : "#2ecc71" }}',
                    color: '#fff',
                    weight: 2,
                    fillOpacity: 0.9
                }
            )
            .addTo(map)
            .bindPopup('{{ $place->name }} ({{ $place->distance_km }} km)');
        @endforeach
    @endif
</script>

@endsection
