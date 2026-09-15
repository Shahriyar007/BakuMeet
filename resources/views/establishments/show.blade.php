@extends('layouts.app')

@section('title', $establishment->name . ' - BakuMeet')

@section('content')
    <div style="margin: 0 -16px;">
        @if ($establishment->primaryPhoto)
            <img id="mainPhoto" src="{{ $establishment->primaryPhoto->url() }}" alt="{{ $establishment->name }}" style="width: 100%; height: 220px; object-fit: cover; cursor: zoom-in;" onclick="openLightbox(this.src)">
        @elseif ($establishment->image)
            <img id="mainPhoto" src="{{ $establishment->image }}" alt="{{ $establishment->name }}" style="width: 100%; height: 220px; object-fit: cover; cursor: zoom-in;" onclick="openLightbox(this.src)">
        @else
            <div class="bk-photo-placeholder" style="width: 100%; height: 220px;">
                <i class="ti {{ $establishment->type === 'restaurant' ? 'ti-tools-kitchen-2' : 'ti-coffee' }}" style="font-size: 40px;" aria-hidden="true"></i>
            </div>
        @endif

        @if ($establishment->photos->count() > 1)
            <div id="thumbStrip" style="display: flex; gap: 8px; overflow-x: auto; padding: 10px 16px; -webkit-overflow-scrolling: touch;">
                @foreach ($establishment->photos as $index => $photo)
                    <img src="{{ $photo->url() }}" alt="{{ $establishment->name }}" data-index="{{ $index }}" style="width: 64px; height: 64px; border-radius: 8px; object-fit: cover; flex-shrink: 0; cursor: pointer; {{ $photo->is_primary ? 'border: 2px solid var(--color-accent);' : '' }}" onclick="showPhoto({{ $index }})">
                @endforeach
            </div>
        @endif
    </div>

    <div id="lightboxOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.95); z-index: 1000; flex-direction: column; align-items: center; justify-content: center;">
        <span onclick="closeLightbox()" style="position: absolute; top: 16px; right: 20px; color: white; font-size: 32px; cursor: pointer; z-index: 1002;">&times;</span>
        <span onclick="prevPhoto(event)" style="position: absolute; left: 8px; top: 50%; transform: translateY(-50%); color: white; font-size: 40px; cursor: pointer; padding: 8px 16px; z-index: 1001; user-select: none;">‹</span>
        <img id="lightboxImg" src="" style="max-width: 90%; max-height: 75vh; object-fit: contain;">
        <span onclick="nextPhoto(event)" style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%); color: white; font-size: 40px; cursor: pointer; padding: 8px 16px; z-index: 1001; user-select: none;">›</span>
        <div id="lightboxThumbs" style="display: flex; gap: 6px; overflow-x: auto; margin-top: 16px; max-width: 90%; padding: 4px;"></div>
    </div>

    <div style="padding-top: 14px;">
        <div style="display: flex; align-items: start; justify-content: space-between; margin-bottom: 4px;">
            <p class="heading" style="font-size: var(--text-title); flex: 1;">{{ $establishment->name }}</p>
            <div style="display: flex; gap: 6px; flex-shrink: 0;">
                <div onclick="shareEstablishment()" style="width: 34px; height: 34px; border-radius: 50%; background: var(--color-bg-muted); display: flex; align-items: center; justify-content: center; cursor: pointer;">
                    <i class="ti ti-share" style="font-size: 16px; color: var(--color-text-secondary);" aria-hidden="true"></i>
                </div>
                @auth
                    @php $isFavorited = auth()->user()->favorites()->where('establishment_id', $establishment->id)->exists(); @endphp
                    <form action="/establishments/{{ $establishment->id }}/favorite" method="POST">
                        @csrf
                        <button type="submit" style="width: 34px; height: 34px; border-radius: 50%; background: {{ $isFavorited ? 'var(--color-accent-tint)' : 'var(--color-bg-muted)' }}; border: none; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                            <i class="ti {{ $isFavorited ? 'ti-heart-filled' : 'ti-heart' }}" style="font-size: 16px; color: var(--color-accent);" aria-hidden="true"></i>
                        </button>
                    </form>
                @endauth
            </div>
        </div>
        <p style="font-size: var(--text-secondary); color: var(--color-text-secondary); margin-bottom: 12px;">{{ $establishment->location }}</p>

        <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 14px;">
            <div style="display: flex; align-items: center; gap: 4px;">
                <i class="ti ti-star" style="color: var(--color-accent); font-size: 15px;" aria-hidden="true"></i>
                <span style="font-size: var(--text-secondary); font-weight: var(--weight-medium);">{{ $establishment->rating ?? '-' }}</span>
                <span style="font-size: var(--text-meta); color: var(--color-text-secondary);">({{ $establishment->reviews->count() }})</span>
            </div>
            @if ($establishment->price_range)
                <span style="font-size: var(--text-secondary); color: var(--color-text-secondary);">{{ str_repeat('₼', $establishment->price_range) }}</span>
            @endif
            @php $isOpen = $establishment->isOpenNow(); @endphp
            @if ($isOpen !== null)
                <span class="bk-chip {{ $isOpen ? 'bk-badge--success' : 'bk-badge--danger' }}">{{ $isOpen ? 'Şu an açık' : 'Şu an kapalı' }}</span>
            @endif
        </div>

        @if ($establishment->description)
            <div class="bk-reason-box" style="margin-bottom: 14px;">
                <div style="display: flex; align-items: center; gap: 6px; margin-bottom: 4px;">
                    <i class="ti ti-sparkles" style="font-size: 14px;" aria-hidden="true"></i>
                    <span style="font-size: var(--text-meta); font-weight: var(--weight-medium);">Neden BakuMeet öneriyor</span>
                </div>
                {{ $establishment->description }}
            </div>
        @endif

        <div style="display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 20px;">
            <span class="bk-chip">{{ $establishment->mood }}</span>
            @foreach ($establishment->tags as $tag)
                <span class="bk-chip">{{ $tag->emoji }} {{ $tag->name }}</span>
            @endforeach
        </div>

        @if ($establishment->opening_hours)
            @php
                $dayNames = ['monday' => 'Pazartesi', 'tuesday' => 'Salı', 'wednesday' => 'Çarşamba', 'thursday' => 'Perşembe', 'friday' => 'Cuma', 'saturday' => 'Cumartesi', 'sunday' => 'Pazar'];
            @endphp
            <div class="bk-card" style="padding: 12px 14px; margin-bottom: 14px;">
                @foreach ($dayNames as $key => $label)
                    @php $day = $establishment->opening_hours[$key] ?? null; @endphp
                    <div style="display: flex; justify-content: space-between; padding: 6px 0; {{ !$loop->last ? 'border-bottom: 0.5px solid var(--color-border);' : '' }}">
                        <span style="font-size: var(--text-secondary); color: var(--color-text);">{{ $label }}</span>
                        @if (!$day || ($day['closed'] ?? false))
                            <span style="font-size: var(--text-secondary); color: var(--color-text-secondary);">Kapalı</span>
                        @else
                            <span style="font-size: var(--text-secondary); color: var(--color-success);">{{ $day['open'] }} - {{ $day['close'] }}</span>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        @if ($establishment->latitude && $establishment->longitude)
            <div id="show-map" style="width: 100%; height: 160px; border-radius: var(--radius-card); margin-bottom: 12px;"></div>
            <a href="https://www.google.com/maps/dir/?api=1&destination={{ $establishment->latitude }},{{ $establishment->longitude }}" target="_blank" class="bk-btn-primary" style="width: 100%; margin-bottom: 24px;">
                <i class="ti ti-map-pin" aria-hidden="true"></i>Yol tarifi al
            </a>
        @endif

        <div style="display: flex; align-items: center; gap: 14px; background: var(--color-surface); border: 0.5px solid var(--color-border); border-radius: var(--radius-card); padding: 14px; margin-bottom: 14px;">
            <div style="text-align: center; flex-shrink: 0;">
                <p class="heading" style="font-size: 24px;">{{ $establishment->rating ?? '-' }}</p>
                <p style="font-size: var(--text-micro); color: var(--color-text-secondary);">{{ $establishment->reviews->count() }} yorum</p>
            </div>
        </div>

        @auth
            <form action="/establishments/{{ $establishment->id }}/reviews" method="POST" class="bk-card" style="padding: 14px; margin-bottom: 14px; display: grid; gap: 10px;">
                @csrf
                <div>
                    <p style="font-size: var(--text-meta); color: var(--color-text-muted); margin-bottom: 4px;">Atmosfer</p>
                    <select name="atmosphere_rating" required class="bk-input" style="width: 100%;">
                        <option value="5">5</option><option value="4">4</option><option value="3">3</option><option value="2">2</option><option value="1">1</option>
                    </select>
                </div>
                <div>
                    <p style="font-size: var(--text-meta); color: var(--color-text-muted); margin-bottom: 4px;">Yemek / ürün</p>
                    <select name="food_rating" required class="bk-input" style="width: 100%;">
                        <option value="5">5</option><option value="4">4</option><option value="3">3</option><option value="2">2</option><option value="1">1</option>
                    </select>
                </div>
                <div>
                    <p style="font-size: var(--text-meta); color: var(--color-text-muted); margin-bottom: 4px;">Servis</p>
                    <select name="service_rating" required class="bk-input" style="width: 100%;">
                        <option value="5">5</option><option value="4">4</option><option value="3">3</option><option value="2">2</option><option value="1">1</option>
                    </select>
                </div>
                <div>
                    <p style="font-size: var(--text-meta); color: var(--color-text-muted); margin-bottom: 4px;">Fiyat / performans</p>
                    <select name="value_rating" required class="bk-input" style="width: 100%;">
                        <option value="5">5</option><option value="4">4</option><option value="3">3</option><option value="2">2</option><option value="1">1</option>
                    </select>
                </div>
                <div>
                    <p style="font-size: var(--text-meta); color: var(--color-text-muted); margin-bottom: 4px;">Yorumun</p>
                    <textarea name="comment" required maxlength="500" rows="3" class="bk-input" style="width: 100%;"></textarea>
                </div>
                <button type="submit" class="bk-btn-primary" style="width: 100%;">Yorum yaz</button>
            </form>
        @else
            <div class="bk-card" style="padding: 14px; margin-bottom: 14px; text-align: center;">
                <p style="font-size: var(--text-secondary); color: var(--color-text-secondary);">Yorum yazmak için <a href="/login" style="color: var(--color-accent);">giriş yap</a></p>
            </div>
        @endauth

        @forelse ($establishment->reviews as $review)
            <div class="bk-card" style="padding: 12px 14px; margin-bottom: 10px;">
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 6px;">
                    <div style="width: 26px; height: 26px; border-radius: 50%; background: var(--color-bg-muted); display: flex; align-items: center; justify-content: center; font-size: 11px; color: var(--color-text-muted);">{{ strtoupper(substr($review->user->name, 0, 1)) }}</div>
                    <span style="font-size: var(--text-meta); font-weight: var(--weight-medium); color: var(--color-text);">{{ $review->user->name }}</span>
                    <span style="font-size: var(--text-micro); color: var(--color-text-secondary);">· {{ $review->created_at->diffForHumans() }}</span>
                </div>
                <div style="display: flex; align-items: center; gap: 3px; margin-bottom: 6px;">
                    <i class="ti ti-star" style="color: var(--color-accent); font-size: 12px;" aria-hidden="true"></i>
                    <span style="font-size: var(--text-meta); color: var(--color-text);">{{ $review->rating }}/5</span>
                </div>
                <p style="font-size: var(--text-secondary); color: var(--color-text-muted); margin-bottom: 6px;">{{ $review->comment }}</p>
                @auth
                    @if (auth()->id() === $review->user_id)
                        <form action="/reviews/{{ $review->id }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; color: var(--color-danger); font-size: var(--text-micro); cursor: pointer; padding: 0;">Sil</button>
                        </form>
                    @endif
                @endauth
            </div>
        @empty
            <div class="bk-card" style="padding: 20px; text-align: center; margin-bottom: 14px;">
                <p style="font-size: var(--text-secondary); color: var(--color-text-secondary);">Henüz yorum yok. İlk yorumu sen yaz!</p>
            </div>
        @endforelse
    </div>
@endsection

@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    const galleryUrls = @json($establishment->photos->map(fn($p) => $p->url())->values());
    let currentPhotoIndex = 0;

    function renderLightboxThumbs() {
        const container = document.getElementById('lightboxThumbs');
        if (!container) return;
        container.innerHTML = '';
        galleryUrls.forEach(function (url, i) {
            const thumb = document.createElement('img');
            thumb.src = url;
            thumb.style.cssText = 'width: 50px; height: 50px; border-radius: 4px; object-fit: cover; flex-shrink: 0; cursor: pointer;' + (i === currentPhotoIndex ? ' border: 2px solid var(--color-accent);' : ' opacity: 0.6;');
            thumb.onclick = function (e) { e.stopPropagation(); showPhoto(i); };
            container.appendChild(thumb);
        });
    }

    function showPhoto(index) {
        currentPhotoIndex = (index + galleryUrls.length) % galleryUrls.length;
        document.getElementById('lightboxImg').src = galleryUrls[currentPhotoIndex];
        document.getElementById('mainPhoto').src = galleryUrls[currentPhotoIndex];
        document.getElementById('lightboxOverlay').style.display = 'flex';
        renderLightboxThumbs();
    }

    function openLightbox(src) {
        const index = galleryUrls.indexOf(src);
        showPhoto(index >= 0 ? index : 0);
    }

    function closeLightbox() {
        document.getElementById('lightboxOverlay').style.display = 'none';
    }

    function nextPhoto(e) { e.stopPropagation(); showPhoto(currentPhotoIndex + 1); }
    function prevPhoto(e) { e.stopPropagation(); showPhoto(currentPhotoIndex - 1); }

    let touchStartX = 0;
    document.getElementById('lightboxOverlay').addEventListener('touchstart', function (e) {
        touchStartX = e.changedTouches[0].screenX;
    });
    document.getElementById('lightboxOverlay').addEventListener('touchend', function (e) {
        const touchEndX = e.changedTouches[0].screenX;
        const diff = touchEndX - touchStartX;
        if (Math.abs(diff) > 50) {
            if (diff < 0) { showPhoto(currentPhotoIndex + 1); } else { showPhoto(currentPhotoIndex - 1); }
        }
    });

    function shareEstablishment() {
        const shareData = {
            title: '{{ addslashes($establishment->name) }} - BakuMeet',
            text: '{{ addslashes($establishment->name) }} mekanına göz at!',
            url: window.location.href
        };
        if (navigator.share) {
            navigator.share(shareData).catch(() => {});
        } else {
            navigator.clipboard.writeText(window.location.href).then(() => { alert('Link kopyalandı!'); });
        }
    }

    @if ($establishment->latitude && $establishment->longitude)
    const showMap = L.map('show-map').setView([{{ $establishment->latitude }}, {{ $establishment->longitude }}], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(showMap);
    L.marker([{{ $establishment->latitude }}, {{ $establishment->longitude }}]).addTo(showMap)
        .bindPopup('{{ addslashes($establishment->name) }}');
    @endif
</script>
@endpush
