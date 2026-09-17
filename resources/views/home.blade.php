@extends('layouts.app')

@section('title', 'BakuMeet - Bakü\'de Bugün Nereye Gidelim?')

@section('content')

    <div style="padding-top: 16px;">
        <p class="heading" style="font-size: var(--text-hero); line-height: 1.3; margin-bottom: 4px;">Bu akşam nereye gidelim?</p>
        <p style="font-size: var(--text-secondary); color: var(--color-text-secondary); margin-bottom: 14px;">Ruh haline göre en iyi yerleri bul</p>

        <form action="/establishments" method="GET" style="margin-bottom: 16px;">
            <div class="bk-input" style="display: flex; align-items: center; gap: 8px;">
                <i class="ti ti-search" style="color: var(--color-accent); font-size: 18px;" aria-hidden="true"></i>
                <input type="text" name="q" placeholder="Kafe, restoran ya da bölge ara" style="border: none; outline: none; background: transparent; flex: 1; font-size: var(--text-secondary); font-family: var(--font-body); color: var(--color-text);">
            </div>
        </form>
    </div>

   <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; margin-bottom: 20px;">
        <a href="/filter?mood=romantik" style="text-decoration: none; background: var(--color-accent-tint); border-radius: var(--radius-card); padding: 14px; display: flex; align-items: center; gap: 10px;">
            <i class="ti ti-heart" style="font-size: 22px; color: var(--color-accent);" aria-hidden="true"></i>
            <span style="font-size: var(--text-secondary); font-weight: var(--weight-medium); color: var(--color-accent-text-on-tint);">Randevu gecesi</span>
        </a>
        <a href="/filter?mood=canlı" style="text-decoration: none; background: var(--color-surface); border: 0.5px solid var(--color-border); border-radius: var(--radius-card); padding: 14px; display: flex; align-items: center; gap: 10px;">
            <i class="ti ti-users" style="font-size: 22px; color: var(--color-text-muted);" aria-hidden="true"></i>
            <span style="font-size: var(--text-secondary); font-weight: var(--weight-medium); color: var(--color-text);">Arkadaşlarla</span>
        </a>
        <a href="/wizard" style="text-decoration: none; background: var(--color-surface); border: 0.5px solid var(--color-border); border-radius: var(--radius-card); padding: 14px; display: flex; align-items: center; gap: 10px;">
            <i class="ti ti-wand" style="font-size: 22px; color: var(--color-text-muted);" aria-hidden="true"></i>
            <span style="font-size: var(--text-secondary); font-weight: var(--weight-medium); color: var(--color-text);">Bana yardım et</span>
        </a>
        <a href="/filter?mood=bütçedostu" style="text-decoration: none; background: var(--color-surface); border: 0.5px solid var(--color-border); border-radius: var(--radius-card); padding: 14px; display: flex; align-items: center; gap: 10px;">
            <i class="ti ti-coin" style="font-size: 22px; color: var(--color-text-muted);" aria-hidden="true"></i>
            <span style="font-size: var(--text-secondary); font-weight: var(--weight-medium); color: var(--color-text);">Bütçe dostu</span>
        </a>
    </div>

    @if ($featured->isNotEmpty())
        @php $spotlight = $featured->first(); @endphp
        <div style="margin-bottom: 10px;">
            <span class="heading" style="font-size: var(--text-title);">BakuMeet seçtikleri</span>
        </div>
        <a href="/establishments/{{ $spotlight->id }}" style="text-decoration: none;">
            <div class="bk-card" style="margin-bottom: 20px;">
                @if ($spotlight->primaryPhoto)
                    <img src="{{ $spotlight->primaryPhoto->url() }}" alt="{{ $spotlight->name }}" style="width: 100%; height: 150px; object-fit: cover;">
                @else
                    <div class="bk-photo-placeholder" style="width: 100%; height: 150px;">
                        <i class="ti {{ $spotlight->type === 'restaurant' ? 'ti-tools-kitchen-2' : 'ti-coffee' }}" style="font-size: 30px;" aria-hidden="true"></i>
                    </div>
                @endif
                <div style="padding: 14px;">
                    <p class="heading" style="font-size: 16px; margin-bottom: 8px;">{{ $spotlight->name }}</p>
                    <div style="display: flex; gap: 6px; margin-bottom: 10px; flex-wrap: wrap;">
                        <span class="bk-chip">{{ $spotlight->type === 'restaurant' ? 'Restoran' : 'Kafe' }}</span>
                        @if ($spotlight->price_range)
                            <span class="bk-chip">{{ str_repeat('₼', $spotlight->price_range) }}</span>
                        @endif
                        <span class="bk-chip">
                            <i class="ti ti-star" style="color: var(--color-accent);" aria-hidden="true"></i>{{ $spotlight->rating ?? '-' }}
                        </span>
                    </div>
                    @if ($spotlight->description)
                        <div class="bk-reason-box">{{ Str::limit($spotlight->description, 90) }}</div>
                    @endif
                </div>
            </div>
        </a>
    @endif

    <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
        <span class="heading" style="font-size: var(--text-title);">Öne çıkanlar</span>
        <a href="/establishments" style="font-size: var(--text-meta); color: var(--color-accent); text-decoration: none;">Tümünü gör</a>
    </div>
    @foreach ($featured->skip(1) as $place)
        <x-establishment-card :place="$place" photo-size="80px" :show-open-status="true" />
    @endforeach

    <div style="display: flex; align-items: center; justify-content: space-between; margin: 20px 0 10px;">
        <span class="heading" style="font-size: var(--text-title);">
            <i class="ti ti-flame" style="color: var(--color-accent); font-size: 18px;" aria-hidden="true"></i> Trend mekanlar
        </span>
        <a href="/trending" style="font-size: var(--text-meta); color: var(--color-accent); text-decoration: none;">Tümünü gör</a>
    </div>
    <div style="display: flex; gap: 10px; overflow-x: auto; padding-bottom: 4px; margin-bottom: 20px;">
        @foreach ($trending->take(4) as $place)
            <a href="/establishments/{{ $place->id }}" style="text-decoration: none; flex-shrink: 0; width: 140px;">
                <div class="bk-card">
                    @if ($place->primaryPhoto)
                        <img src="{{ $place->primaryPhoto->url() }}" alt="{{ $place->name }}" style="width: 100%; height: 90px; object-fit: cover;">
                    @else
                        <div class="bk-photo-placeholder" style="width: 100%; height: 90px;">
                            <i class="ti {{ $place->type === 'restaurant' ? 'ti-tools-kitchen-2' : 'ti-coffee' }}" style="font-size: 22px;" aria-hidden="true"></i>
                        </div>
                    @endif
                    <div style="padding: 8px;">
                        <p style="font-size: var(--text-meta); font-weight: var(--weight-medium); color: var(--color-text); margin-bottom: 2px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $place->name }}</p>
                        <div style="display: flex; align-items: center; gap: 3px;">
                            <i class="ti ti-star" style="color: var(--color-accent); font-size: 11px;" aria-hidden="true"></i>
                            <span style="font-size: var(--text-micro); color: var(--color-text-secondary);">{{ $place->rating ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>

    <a href="/surprise" style="text-decoration: none;">
        <div class="bk-card" style="display: flex; align-items: center; gap: 12px; padding: 14px; margin-bottom: 20px; background: var(--color-accent-tint); border: none;">
            <div style="width: 40px; height: 40px; border-radius: 12px; background: var(--color-surface); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <i class="ti ti-dice" style="color: var(--color-accent); font-size: 20px;" aria-hidden="true"></i>
            </div>
            <div style="flex: 1;">
                <p style="font-size: var(--text-secondary); font-weight: var(--weight-medium); color: var(--color-accent-text-on-tint); margin-bottom: 2px;">Karar veremedin mi?</p>
                <p style="font-size: var(--text-meta); color: var(--color-accent-text-on-tint);">Sürpriz Bana ile tek bir öneri al</p>
            </div>
            <i class="ti ti-chevron-right" style="color: var(--color-accent-text-on-tint);" aria-hidden="true"></i>
        </div>
    </a>

    <a href="/weather" style="text-decoration: none;">
        <div class="bk-card" style="display: flex; align-items: center; gap: 12px; padding: 14px; margin-bottom: 20px;">
            <div style="width: 40px; height: 40px; border-radius: 12px; background: var(--color-bg-muted); display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                <i class="ti ti-sun" style="color: var(--color-accent); font-size: 20px;" aria-hidden="true"></i>
            </div>
            <div style="flex: 1;">
                <p style="font-size: var(--text-secondary); font-weight: var(--weight-medium); color: var(--color-text); margin-bottom: 2px;">Bugün hava için öneriler</p>
                <p style="font-size: var(--text-meta); color: var(--color-text-secondary);">Hava durumuna göre en uygun yerler</p>
            </div>
            <i class="ti ti-chevron-right" style="color: var(--color-text-secondary);" aria-hidden="true"></i>
        </div>
    </a>

    @if ($collections->isNotEmpty())
        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 10px;">
            <span class="heading" style="font-size: var(--text-title);">Koleksiyonlar</span>
            <a href="/collections" style="font-size: var(--text-meta); color: var(--color-accent); text-decoration: none;">Tümünü gör</a>
        </div>
        @foreach ($collections as $collection)
            <a href="/collections/{{ $collection->id }}" style="text-decoration: none;">
                <div class="bk-card" style="display: flex; align-items: center; gap: 12px; padding: 12px; margin-bottom: 10px;">
                    <div style="font-size: 26px;">{{ $collection->emoji }}</div>
                    <div>
                        <p style="font-size: var(--text-secondary); font-weight: var(--weight-medium); color: var(--color-text);">{{ $collection->title }}</p>
                        <p style="font-size: var(--text-micro); color: var(--color-text-secondary);">{{ $collection->establishments->count() }} mekan</p>
                    </div>
                </div>
            </a>
        @endforeach
    @endif

    <div style="margin: 20px 0 10px;">
        <span class="heading" style="font-size: var(--text-title);">Haritada keşfet</span>
    </div>
    <div id="home-map" style="height: 220px; border-radius: var(--radius-card); margin-bottom: 10px;"></div>
    <div style="text-align: center; margin-bottom: 20px;">
        <a href="/establishments/map/view" class="bk-btn-secondary" style="display: inline-flex;">Tam haritayı aç</a>
    </div>

    <div class="bk-card" style="display: flex; justify-content: space-around; text-align: center; padding: 14px;">
        <div>
            <p style="font-size: 18px; font-weight: var(--weight-medium); color: var(--color-accent);">{{ $stats['establishments'] }}</p>
            <p style="font-size: var(--text-micro); color: var(--color-text-secondary);">İşletme</p>
        </div>
        <div>
            <p style="font-size: 18px; font-weight: var(--weight-medium); color: var(--color-accent);">{{ $stats['locations'] }}</p>
            <p style="font-size: var(--text-micro); color: var(--color-text-secondary);">Semt</p>
        </div>
        <div>
            <p style="font-size: 18px; font-weight: var(--weight-medium); color: var(--color-accent);">{{ $stats['reviews'] }}</p>
            <p style="font-size: var(--text-micro); color: var(--color-text-secondary);">Yorum</p>
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
        const color = place.type === 'restaurant' ? '#C1502E' : '#3F7D58';
        const icon = L.divIcon({
            className: 'custom-marker',
            html: `<div style="background-color: ${color}; width: 16px; height: 16px; border-radius: 50%; border: 2px solid white;"></div>`,
            iconSize: [16, 16]
        });
        L.marker([place.latitude, place.longitude], { icon: icon }).addTo(homeMap).bindPopup(place.name);
    });
</script>
@endpush
