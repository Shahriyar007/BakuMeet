@extends('layouts.app')

@section('title', $location . ' - BakuMeet')

@section('content')
    <div>
        <a href="/areas" style="color: #3498db; text-decoration: none;">← Bölgelere Dön</a>
        <h2>📍 {{ $location }}</h2>

        <div class="card" style="display: flex; justify-content: space-around; text-align: center; margin: 15px 0;">
            <div>
                <div style="font-size: 22px; font-weight: bold; color: #3498db;">{{ $stats['total'] }}</div>
                <div style="font-size: 12px; color: #999;">Toplam Mekan</div>
            </div>
            <div>
                <div style="font-size: 22px; font-weight: bold; color: #3498db;">{{ $stats['restaurants'] }}</div>
                <div style="font-size: 12px; color: #999;">Restoran</div>
            </div>
            <div>
                <div style="font-size: 22px; font-weight: bold; color: #3498db;">{{ $stats['cafes'] }}</div>
                <div style="font-size: 12px; color: #999;">Kafe</div>
            </div>
            <div>
                <div style="font-size: 22px; font-weight: bold; color: #3498db;">⭐ {{ $stats['avg_rating'] }}</div>
                <div style="font-size: 12px; color: #999;">Ort. Puan</div>
            </div>
        </div>

        @if ($mapData->isNotEmpty())
            <div id="area-map" style="width: 100%; height: 250px; border-radius: 8px; margin-bottom: 20px;"></div>
        @endif

        @if ($collections->isNotEmpty())
            <h3 style="margin: 20px 0 10px;">📚 {{ $location }} İçin Koleksiyonlar</h3>
            @foreach ($collections as $collection)
                <a href="/collections/{{ $collection->id }}" style="text-decoration: none;">
                    <div class="card">
                        <div style="display: flex; align-items: center; gap: 15px;">
                            <div style="font-size: 28px;">{{ $collection->emoji }}</div>
                            <div>
                                <h3 style="font-size: 15px;">{{ $collection->title }}</h3>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        @endif

        <h3 style="margin: 20px 0 10px;">Mekanlar</h3>
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
                            <span class="badge">🎭 {{ $place->mood }}</span>
                            <span class="badge">{{ str_repeat('₼', $place->price_range) }}</span>
                        </p>
                        <p><span class="rating">⭐ {{ $place->rating ?? 'Henüz puanlanmamış' }}</span></p>
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

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@if ($mapData->isNotEmpty())
<script>
    const areaMap = L.map('area-map').setView([{{ $mapData->first()->latitude }}, {{ $mapData->first()->longitude }}], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(areaMap);

    @foreach ($mapData as $place)
        L.marker([{{ $place->latitude }}, {{ $place->longitude }}])
            .addTo(areaMap)
            .bindPopup('{{ addslashes($place->name) }}');
    @endforeach
</script>
@endif
@endpush
