@extends('layouts.app')

@section('title', $location . ' - BakuMeet')

@section('content')
    <div style="padding-top: 16px;">
        <a href="/areas" style="display: inline-flex; align-items: center; gap: 4px; color: var(--color-text-secondary); text-decoration: none; font-size: var(--text-meta); margin-bottom: 8px;">
            <i class="ti ti-arrow-left" aria-hidden="true"></i>Bölgelere dön
        </a>
        <p class="heading" style="font-size: var(--text-title); margin-bottom: 14px;">{{ $location }}</p>

        <div class="bk-card" style="display: flex; justify-content: space-around; text-align: center; padding: 14px; margin-bottom: 16px;">
            <div>
                <p class="heading" style="font-size: 18px; color: var(--color-accent);">{{ $stats['total'] }}</p>
                <p style="font-size: var(--text-micro); color: var(--color-text-secondary);">Toplam mekan</p>
            </div>
            <div>
                <p class="heading" style="font-size: 18px; color: var(--color-accent);">{{ $stats['restaurants'] }}</p>
                <p style="font-size: var(--text-micro); color: var(--color-text-secondary);">Restoran</p>
            </div>
            <div>
                <p class="heading" style="font-size: 18px; color: var(--color-accent);">{{ $stats['cafes'] }}</p>
                <p style="font-size: var(--text-micro); color: var(--color-text-secondary);">Kafe</p>
            </div>
            <div>
                <p class="heading" style="font-size: 18px; color: var(--color-accent);">{{ $stats['avg_rating'] }}</p>
                <p style="font-size: var(--text-micro); color: var(--color-text-secondary);">Ort. puan</p>
            </div>
        </div>

        @if ($mapData->isNotEmpty())
            <div id="area-map" style="width: 100%; height: 200px; border-radius: var(--radius-card); margin-bottom: 16px;"></div>
        @endif

        @if ($collections->isNotEmpty())
            <p style="font-size: var(--text-secondary); font-weight: var(--weight-medium); color: var(--color-text); margin-bottom: 10px;">{{ $location }} için koleksiyonlar</p>
            @foreach ($collections as $collection)
                <a href="/collections/{{ $collection->id }}" style="text-decoration: none;">
                    <div class="bk-card" style="padding: 12px; margin-bottom: 10px; display: flex; align-items: center; gap: 12px;">
                        <div style="font-size: 24px;">{{ $collection->emoji }}</div>
                        <span style="font-size: var(--text-secondary); font-weight: var(--weight-medium); color: var(--color-text);">{{ $collection->title }}</span>
                    </div>
                </a>
            @endforeach
        @endif

        <p style="font-size: var(--text-secondary); font-weight: var(--weight-medium); color: var(--color-text); margin: 16px 0 10px;">Mekanlar</p>
        @foreach ($establishments as $place)
            <x-establishment-card :place="$place" :show-location="false" />
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
