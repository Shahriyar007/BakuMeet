@extends('layouts.app')

@section('title', $establishment->name . ' - BakuMeet')

@section('content')
    <div>
        <a href="/establishments" style="color: #3498db; text-decoration: none;">← Geri Dön</a>
 
        <div style="margin-bottom: 20px;">
	     @if ($establishment->primaryPhoto)
                    <img src="{{ $establishment->primaryPhoto->url() }}" alt="{{ $establishment->name }}" style="width: 100%; max-height: 400px; border-radius: 8px; object-fit: cover;">
                @elseif ($establishment->image)
                    <img src="{{ $establishment->image }}" alt="{{ $establishment->name }}" style="width: 100%; max-height: 400px; border-radius: 8px; object-fit: cover;">
                @else
                    <div style="width: 100%; height: 250px; border-radius: 8px; background-color: {{ $establishment->type === 'restaurant' ? '#fce4e4' : '#e4f7e9' }}; display: flex; align-items: center; justify-content: center; font-size: 72px;">
                        {{ $establishment->type === 'restaurant' ? '🍽️' : '☕' }}
                    </div>
            @endif

            <h2>{{ $establishment->name }}</h2>

            <button onclick="shareEstablishment()" style="padding: 8px 15px; border-radius: 4px; border: none; cursor: pointer; font-size: 14px; background-color: #ecf0f1; color: #333; margin-bottom: 8px;">
                🔗 Paylaş
            </button>

                @auth
                <form action="/establishments/{{ $establishment->id }}/favorite" method="POST" style="display: inline;">
                    @csrf
                    @php
                        $isFavorited = auth()->user()->favorites()->where('establishment_id', $establishment->id)->exists();
                    @endphp
                    <button type="submit" style="padding: 8px 15px; border-radius: 4px; border: none; cursor: pointer; font-size: 14px; background-color: {{ $isFavorited ? '#e74c3c' : '#ecf0f1' }}; color: {{ $isFavorited ? 'white' : '#333' }};">
                        {{ $isFavorited ? '❤️ Favorilerde' : '🤍 Favorilere Ekle' }}
                    </button>
                </form>
            @endauth
            <div style="margin: 15px 0;">
                <span class="badge {{ $establishment->type }}">
                    @if ($establishment->type === 'restaurant')
                        🍽️ Restoran
                    @elseif ($establishment->type === 'cafe')
                        ☕ Kafe
                    @endif
                </span>
                <span class="badge">📍 {{ $establishment->location }}</span>
                <span class="badge">🎭 {{ $establishment->mood }}</span>
                @foreach ($establishment->tags as $tag)
                    <span class="badge">{{ $tag->emoji }} {{ $tag->name }}</span>
                @endforeach
  		</div>
            
            <p style="margin: 15px 0; font-size: 16px;">
                <strong>Puanı:</strong> 
                <span class="rating">⭐ {{ $establishment->rating ?? 'Henüz puanlanmamış' }}</span>
            </p>
            
            <h3 style="margin-top: 20px; margin-bottom: 10px;">Açıklama</h3>
            <p>{{ $establishment->description ?? 'Açıklama bulunmamaktadır.' }}</p>
            
<h3 style="margin-top: 20px; margin-bottom: 10px;">Konum Bilgileri</h3>
            <p>
                <strong>Semt:</strong> {{ $establishment->location }}<br>
            </p>

            <h3 style="margin-top: 20px; margin-bottom: 10px;">🕒 Çalışma Saatleri</h3>
            @if ($establishment->opening_hours)
                @php
                    $dayNames = [
                        'monday' => 'Pazartesi', 'tuesday' => 'Salı', 'wednesday' => 'Çarşamba',
                        'thursday' => 'Perşembe', 'friday' => 'Cuma', 'saturday' => 'Cumartesi', 'sunday' => 'Pazar',
                    ];
                    $isOpen = $establishment->isOpenNow();
                @endphp

                <p style="margin-bottom: 10px;">
                    @if ($isOpen === true)
                        <span class="badge" style="background-color: #2ecc71; color: white;">🟢 Şu an açık</span>
                    @elseif ($isOpen === false)
                        <span class="badge" style="background-color: #e74c3c; color: white;">🔴 Şu an kapalı</span>
                    @endif
                </p>

                <table style="width: 100%; border-collapse: collapse;">
                    @foreach ($dayNames as $key => $label)
                        @php $day = $establishment->opening_hours[$key] ?? null; @endphp
                        <tr style="border-bottom: 1px solid #eee;">
                            <td style="padding: 6px 0;">{{ $label }}</td>
                            <td style="padding: 6px 0; text-align: right;">
                                @if (!$day || ($day['closed'] ?? false))
                                    <span style="color: #999;">Kapalı</span>
                                @else
                                    {{ $day['open'] }} - {{ $day['close'] }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </table>
            @else
                <p style="color: #999;"><em>Çalışma saatleri henüz eklenmedi.</em></p>
            @endif

      @if ($establishment->latitude && $establishment->longitude)
                <h3 style="margin-top: 20px; margin-bottom: 10px;">🗺️ Haritada Konum</h3>
		<div id="show-map" style="width: 100%; max-width: 500px; height: 160px; border-radius: 8px; margin: 0 auto;"></div>
                <p style="text-align: center; margin-top: 6px; font-size: 13px;">
                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $establishment->latitude }},{{ $establishment->longitude }}" target="_blank" class="btn" style="display: inline-block; margin-top: 8px;">
                        🧭 Yol Tarifi Al
                    </a>
                </p>
            @endif
        </div>
    </div>
<!-- YORUMLAR BÖLÜMÜ -->
        <div class="card" style="margin-top: 20px;">
            <h3>💬 Yorumlar</h3>
            
            @auth
<form action="/establishments/{{ $establishment->id }}/reviews" method="POST" style="margin: 15px 0; display: grid; gap: 10px;">
                    @csrf
                    <div>
                        <label><strong>🎭 Atmosfer:</strong></label><br>
                        <select name="atmosphere_rating" required style="padding: 8px; width: 100%;">
                            <option value="5">⭐⭐⭐⭐⭐ (5)</option>
                            <option value="4">⭐⭐⭐⭐ (4)</option>
                            <option value="3">⭐⭐⭐ (3)</option>
                            <option value="2">⭐⭐ (2)</option>
                            <option value="1">⭐ (1)</option>
                        </select>
                    </div>
                    <div>
                        <label><strong>🍽️ Yemek/Ürün:</strong></label><br>
                        <select name="food_rating" required style="padding: 8px; width: 100%;">
                            <option value="5">⭐⭐⭐⭐⭐ (5)</option>
                            <option value="4">⭐⭐⭐⭐ (4)</option>
                            <option value="3">⭐⭐⭐ (3)</option>
                            <option value="2">⭐⭐ (2)</option>
                            <option value="1">⭐ (1)</option>
                        </select>
                    </div>
                    <div>
                        <label><strong>🙋 Servis:</strong></label><br>
                        <select name="service_rating" required style="padding: 8px; width: 100%;">
                            <option value="5">⭐⭐⭐⭐⭐ (5)</option>
                            <option value="4">⭐⭐⭐⭐ (4)</option>
                            <option value="3">⭐⭐⭐ (3)</option>
                            <option value="2">⭐⭐ (2)</option>
                            <option value="1">⭐ (1)</option>
                        </select>
                    </div>
                    <div>
                        <label><strong>💰 Fiyat/Performans:</strong></label><br>
                        <select name="value_rating" required style="padding: 8px; width: 100%;">
                            <option value="5">⭐⭐⭐⭐⭐ (5)</option>
                            <option value="4">⭐⭐⭐⭐ (4)</option>
                            <option value="3">⭐⭐⭐ (3)</option>
                            <option value="2">⭐⭐ (2)</option>
                            <option value="1">⭐ (1)</option>
                        </select>
                    </div>
                    <div>
                        <label><strong>Yorumunuz:</strong></label><br>
                        <textarea name="comment" required maxlength="500" rows="3" style="padding: 8px; width: 100%;"></textarea>
                    </div>
                    <button type="submit" style="padding: 10px; background-color: #27ae60; color: white; border: none; border-radius: 4px; cursor: pointer;">
                        Yorum Ekle
                    </button>
                </form> 
        
			@else
                              <p style="margin: 15px 0;">
                    Yorum yazmak için <a href="/login">giriş yapın</a>.
                </p>
            @endauth
            
              @forelse ($establishment->reviews as $review)
                <div style="border-top: 1px solid #eee; padding: 15px 0;">
                    <strong>{{ $review->user->name }}</strong>
                    <span class="rating">{{ str_repeat('⭐', $review->rating) }} ({{ $review->rating }}/5)</span>
                    @if ($review->atmosphere_rating)
                        <p style="font-size: 12px; color: #999; margin-top: 4px;">
                            🎭 Atmosfer: {{ $review->atmosphere_rating }} ·
                            🍽️ Yemek: {{ $review->food_rating }} ·
                            🙋 Servis: {{ $review->service_rating }} ·
                            💰 Fiyat: {{ $review->value_rating }}
                        </p>
                    @endif
                    <p style="margin-top: 5px;">{{ $review->comment }}</p>
                    <small style="color: #999;">{{ $review->created_at->diffForHumans() }}</small>                    
                    @auth
                        @if (auth()->id() === $review->user_id)
                            <form action="/reviews/{{ $review->id }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: none; border: none; color: #e74c3c; cursor: pointer; font-size: 12px;">Sil</button>
                            </form>
                        @endif
                    @endauth
                </div>
            @empty
                <p style="color: #999; margin: 15px 0;">Henüz yorum yapılmamış. İlk yorumu sen yap!</p>
            @endforelse
        </div>
@endsection
@push('scripts')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
@if ($establishment->latitude && $establishment->longitude)
<script>
    const showMap = L.map('show-map').setView([{{ $establishment->latitude }}, {{ $establishment->longitude }}], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(showMap);
    L.marker([{{ $establishment->latitude }}, {{ $establishment->longitude }}]).addTo(showMap)
        .bindPopup('{{ addslashes($establishment->name) }}');
</script>
@endif
<script>
    function shareEstablishment() {
        const shareData = {
            title: '{{ addslashes($establishment->name) }} - BakuMeet',
            text: '{{ addslashes($establishment->name) }} mekanına göz at!',
            url: window.location.href
        };

        if (navigator.share) {
            navigator.share(shareData).catch(() => {});
        } else {
            navigator.clipboard.writeText(window.location.href).then(() => {
                alert('Link kopyalandı!');
            });
        }
    }
</script>
@endpush
