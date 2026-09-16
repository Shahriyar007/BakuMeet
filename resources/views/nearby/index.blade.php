@extends('layouts.app')

@section('title', 'Yakınımdakiler - BakuMeet')

@section('content')
<div style="padding-top: 16px;">
    <p class="heading" style="font-size: var(--text-title); margin-bottom: 14px;">Yakınımdakiler</p>

    <div class="bk-card" style="padding: 14px; margin-bottom: 16px;">
        <p id="status-text" style="font-size: var(--text-secondary); color: var(--color-text-muted); margin-bottom: 10px;">Konumunuz alınıyor...</p>

        <div id="retry-btn" onclick="getLocation()" class="bk-btn-secondary" style="display: none; margin-bottom: 10px;">
            <i class="ti ti-map-pin" aria-hidden="true"></i>Konumu tekrar dene
        </div>

        @if ($lat && $lng)
            <form action="/nearby" method="GET" style="display: flex; gap: 8px; flex-wrap: wrap; align-items: center;">
                <input type="hidden" name="lat" value="{{ $lat }}">
                <input type="hidden" name="lng" value="{{ $lng }}">

                <select name="radius" onchange="this.form.submit()" class="bk-chip" style="border: 0.5px solid var(--color-border);">
                    <option value="1" {{ $radius == 1 ? 'selected' : '' }}>1 km</option>
                    <option value="2" {{ $radius == 2 ? 'selected' : '' }}>2 km</option>
                    <option value="5" {{ $radius == 5 ? 'selected' : '' }}>5 km</option>
                    <option value="10" {{ $radius == 10 ? 'selected' : '' }}>10 km</option>
                </select>

                <select name="type" onchange="this.form.submit()" class="bk-chip" style="border: 0.5px solid var(--color-border);">
                    <option value="">Tümü</option>
                    <option value="restaurant" {{ $type == 'restaurant' ? 'selected' : '' }}>Restoran</option>
                    <option value="cafe" {{ $type == 'cafe' ? 'selected' : '' }}>Kafe</option>
                </select>
            </form>
        @endif
    </div>

    @if ($lat && $lng)
        <div id="map" style="width: 100%; height: 220px; border-radius: var(--radius-card); margin-bottom: 16px;"></div>

        @if ($establishments->isEmpty())
            <div class="bk-card" style="padding: 24px 20px; text-align: center;">
                <p style="font-size: var(--text-secondary); color: var(--color-text-secondary);">Bu mesafede işletme bulunamadı. Mesafeyi artırmayı deneyebilirsin.</p>
            </div>
        @else
            @foreach ($establishments as $place)
                <x-establishment-card :place="$place" photo-size="100px" :show-distance="true" />
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
            document.getElementById('status-text').innerText = 'Tarayıcınız konum özelliğini desteklemiyor.';
            return;
        }

        navigator.geolocation.getCurrentPosition(
            function (position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                window.location.href = '/nearby?lat=' + lat + '&lng=' + lng + '&radius={{ $radius }}' + '&type={{ $type }}' + '&mood={{ $mood }}';
            },
            function () {
                document.getElementById('status-text').innerText = 'Konum izni reddedildi. Yakınımdakiler özelliğini kullanmak için konum izni vermeniz gerekiyor.';
                document.getElementById('retry-btn').style.display = 'inline-flex';
            }
        );
    }

    @if (!$lat || !$lng)
        getLocation();
    @else
        document.getElementById('status-text').innerText = 'Konumunuz alındı';

        const map = L.map('map').setView([{{ $lat }}, {{ $lng }}], 14);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        L.marker([{{ $lat }}, {{ $lng }}], {
            icon: L.divIcon({ html: '📍', iconSize: [30, 30], className: '' })
        }).addTo(map).bindPopup('Siz buradasınız');

        @foreach ($establishments as $place)
            L.circleMarker([{{ $place->latitude }}, {{ $place->longitude }}], {
                radius: 8,
                fillColor: '{{ $place->type === "restaurant" ? "#C1502E" : "#3F7D58" }}',
                color: '#fff',
                weight: 2,
                fillOpacity: 0.9
            }).addTo(map).bindPopup('{{ $place->name }} ({{ $place->distance_km }} km)');
        @endforeach
    @endif
</script>
@endsection
