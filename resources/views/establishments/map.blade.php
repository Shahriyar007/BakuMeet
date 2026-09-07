@extends('layouts.app')

@section('title', 'Harita - BakuMeet')

@section('content')
    <div>
        <h2>🗺️ İşletmeler Haritası</h2>
        <p style="margin: 10px 0; font-size: 14px;">
            <a href="/establishments">← Liste görünümüne dön</a>
        </p>
        
        <div id="map" style="height: 500px; border-radius: 8px; margin-top: 15px;"></div>
    </div>

    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    <script>
        // Bakü merkez koordinatları
        const bakuCenter = [40.3777, 49.8920];
        
        // Haritayı oluştur
        const map = L.map('map').setView(bakuCenter, 12);
        
        // OpenStreetMap tile layer ekle
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap katkıda bulunanlar'
        }).addTo(map);
        
        // Laravel'den gelen veri
        const establishments = @json($mapData);
        
        // Tür bazlı ikon renkleri
        function getMarkerColor(type) {
            return type === 'restaurant' ? 'red' : 'green';
        }
        
        // Her işletme için pin ekle
        establishments.forEach(function(place) {
            const icon = L.divIcon({
                className: 'custom-marker',
                html: `<div style="background-color: ${getMarkerColor(place.type)}; width: 20px; height: 20px; border-radius: 50%; border: 2px solid white; box-shadow: 0 0 4px rgba(0,0,0,0.5);"></div>`,
                iconSize: [20, 20]
            });
            
            const marker = L.marker([place.latitude, place.longitude], { icon: icon }).addTo(map);
            
            const typeLabel = place.type === 'restaurant' ? '🍽️ Restoran' : '☕ Kafe';
            
            marker.bindPopup(`
                <strong>${place.name}</strong><br>
                ${typeLabel}<br>
                📍 ${place.location}<br>
                🎭 ${place.mood}<br>
                ⭐ ${place.rating}<br>
                <a href="/establishments/${place.id}">Detaylar →</a>
            `);
        });
    </script>
@endsection
