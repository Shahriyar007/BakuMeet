@extends('layouts.app')

@section('title', 'Harita - BakuMeet')

@section('content')
    <div style="margin: 0 -16px; padding-top: 12px;">
        <div style="padding: 0 16px 10px;">
            <a href="/establishments" style="display: inline-flex; align-items: center; gap: 4px; color: var(--color-text-secondary); text-decoration: none; font-size: var(--text-meta);">
                <i class="ti ti-arrow-left" aria-hidden="true"></i>Liste görünümüne dön
            </a>
        </div>
        <div id="map" style="height: 65vh;"></div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        const bakuCenter = [40.3777, 49.8920];
        const map = L.map('map').setView(bakuCenter, 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap katkıda bulunanlar'
        }).addTo(map);

        const establishments = @json($mapData);

        function getMarkerColor(type) {
            return type === 'restaurant' ? '#C1502E' : '#3F7D58';
        }

        establishments.forEach(function(place) {
            const icon = L.divIcon({
                className: 'custom-marker',
                html: `<div style="background-color: ${getMarkerColor(place.type)}; width: 18px; height: 18px; border-radius: 50%; border: 2px solid white; box-shadow: 0 1px 3px rgba(42,33,27,0.3);"></div>`,
                iconSize: [18, 18]
            });

            const marker = L.marker([place.latitude, place.longitude], { icon: icon }).addTo(map);
            const typeLabel = place.type === 'restaurant' ? 'Restoran' : 'Kafe';

            marker.bindPopup(`
                <strong>${place.name}</strong><br>
                ${typeLabel}<br>
                ${place.location}<br>
                ${place.mood}<br>
                ⭐ ${place.rating ?? '-'}<br>
                <a href="/establishments/${place.id}" style="color: #C1502E;">Detaylar →</a>
            `);
        });
    </script>
@endsection
