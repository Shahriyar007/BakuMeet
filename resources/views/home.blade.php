@extends('layouts.app')

@section('title', 'BakuMeet - Bakü\'de Bugün Nereye Gidelim?')

@section('content')
    <!-- HERO -->
    <div style="text-align: center; padding: 30px 15px; background: linear-gradient(135deg, #2c3e50, #3498db); border-radius: 8px; color: white; margin-bottom: 25px;">
        <h1 style="font-size: 24px; margin-bottom: 10px;">Bakü'de Bugün Nereye Gidelim?</h1>
        <p style="font-size: 14px; opacity: 0.9;">Ruh haline göre en iyi restoran ve kafeleri keşfet</p>
    </div>

    <!-- MOOD KARTLARI -->
    <h2 style="margin-bottom: 15px;">Bugün Ne Modundasın?</h2>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(130px, 1fr)); gap: 10px; margin-bottom: 30px;">
        <a href="/filter?mood=romantik" style="text-decoration: none;">
            <div class="card" style="text-align: center; padding: 20px 10px;">
                <div style="font-size: 32px;">💕</div>
                <p style="color: #333; margin-top: 8px; font-size: 14px;">Romantik</p>
            </div>
        </a>
        <a href="/filter?mood=sakin" style="text-decoration: none;">
            <div class="card" style="text-align: center; padding: 20px 10px;">
                <div style="font-size: 32px;">🧘</div>
                <p style="color: #333; margin-top: 8px; font-size: 14px;">Sakin</p>
            </div>
        </a>
        <a href="/filter?mood=canlı" style="text-decoration: none;">
            <div class="card" style="text-align: center; padding: 20px 10px;">
                <div style="font-size: 32px;">🎉</div>
                <p style="color: #333; margin-top: 8px; font-size: 14px;">Canlı</p>
            </div>
        </a>
        <a href="/filter?mood=lüks" style="text-decoration: none;">
            <div class="card" style="text-align: center; padding: 20px 10px;">
                <div style="font-size: 32px;">👑</div>
                <p style="color: #333; margin-top: 8px; font-size: 14px;">Lüks</p>
            </div>
        </a>
        <a href="/filter?mood=bütçedostu" style="text-decoration: none;">
            <div class="card" style="text-align: center; padding: 20px 10px;">
                <div style="font-size: 32px;">💰</div>
                <p style="color: #333; margin-top: 8px; font-size: 14px;">Bütçe Dostu</p>
            </div>
        </a>
    </div>

    <!-- ÖNE ÇIKANLAR -->
    <h2 style="margin-bottom: 15px;">⭐ Öne Çıkanlar</h2>
    @foreach ($featured as $place)
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center;">
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
                    </p>
                    <p><span class="rating">⭐ {{ $place->rating }}</span></p>
                    <a href="/establishments/{{ $place->id }}" class="btn">Detaylar</a>
                </div>
                <div style="width: 70px; height: 70px; border-radius: 8px; background-color: {{ $place->type === 'restaurant' ? '#fce4e4' : '#e4f7e9' }}; display: flex; align-items: center; justify-content: center; font-size: 32px; flex-shrink: 0;">
                    {{ $place->type === 'restaurant' ? '🍽️' : '☕' }}
                </div>
            </div>
        </div>
    @endforeach

    <div style="text-align: center; margin: 20px 0;">
        <a href="/establishments" class="btn">Tüm İşletmeleri Gör →</a>
    </div>
      
     <!-- KOLEKSİYONLAR ÖNİZLEME -->
    <h2 style="margin-bottom: 15px;">📚 Koleksiyonlar</h2>
    @foreach ($collections as $collection)
        <a href="/collections/{{ $collection->id }}" style="text-decoration: none;">
            <div class="card">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <div style="font-size: 32px;">{{ $collection->emoji }}</div>
                    <div>
                        <h3 style="font-size: 16px;">{{ $collection->title }}</h3>
                        <p style="color: #999; font-size: 12px;">{{ $collection->establishments->count() }} mekan</p>
                    </div>
                </div>
            </div>
        </a>
    @endforeach
    <div style="text-align: center; margin: 15px 0 25px;">
        <a href="/collections" class="btn">Tüm Koleksiyonları Gör →</a>
    </div>

    <!-- MİNİ HARİTA -->
    <h2 style="margin-bottom: 15px;">🗺️ Haritada Keşfet</h2>
    <div id="home-map" style="height: 250px; border-radius: 8px; margin-bottom: 10px;"></div>
    <div style="text-align: center; margin-bottom: 25px;">
        <a href="/establishments/map/view" class="btn">Tam Haritayı Aç →</a>
    </div>

    <!-- İSTATİSTİK ŞERİDİ -->
    <div class="card" style="display: flex; justify-content: space-around; text-align: center;">
        <div>
            <div style="font-size: 24px; font-weight: bold; color: #3498db;">{{ $stats['establishments'] }}</div>
            <div style="font-size: 12px; color: #999;">İşletme</div>
        </div>
        <div>
            <div style="font-size: 24px; font-weight: bold; color: #3498db;">{{ $stats['locations'] }}</div>
            <div style="font-size: 12px; color: #999;">Semt</div>
        </div>
        <div>
            <div style="font-size: 24px; font-weight: bold; color: #3498db;">{{ $stats['reviews'] }}</div>
            <div style="font-size: 12px; color: #999;">Yorum</div>
        </div>
    </div>
@endsection
@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const homeMap = L.map('home-map').setView([40.3777, 49.8920], 12);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap katkıda bulunanlar'
    }).addTo(homeMap);

    const homeMapData = @json($mapData);
    homeMapData.forEach(function(place) {
        const color = place.type === 'restaurant' ? 'red' : 'green';
        const icon = L.divIcon({
            className: 'custom-marker',
            html: `<div style="background-color: ${color}; width: 16px; height: 16px; border-radius: 50%; border: 2px solid white;"></div>`,
            iconSize: [16, 16]
        });
        L.marker([place.latitude, place.longitude], { icon: icon }).addTo(homeMap).bindPopup(place.name);
    });
</script>
@endpush
