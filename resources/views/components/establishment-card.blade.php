@props([
    'place',
    'photoSize' => '100px',
    'showOpenStatus' => false,
    'showTags' => false,
    'showDistance' => false,
    'showReviewStats' => false,
    'index' => null,
    'showLocation' => true,
    'showDescription' => false,
])

<div class="card" style="margin-top: 15px;">
    <div style="display: flex; justify-content: space-between; align-items: start; gap: 12px;">
        <div>
            <h3>
                @if ($index !== null)
                    #{{ $index + 1 }} ·
                @endif
                {{ $place->name }}
            </h3>
            <p>
                <span class="badge {{ $place->type }}">
                    @if ($place->type === 'restaurant')
                        🍽️ Restoran
                    @else
                        ☕ Kafe
                    @endif
                </span>
		@if ($showLocation)
                    <span class="badge">📍 {{ $place->location ?? $place->neighborhood ?? 'Bakı' }}</span>
                @endif
                <span class="badge">🎭 {{ $place->mood ?? 'Genel' }}</span>
                @if ($place->price_range)
                    <span class="badge">{{ str_repeat('₼', $place->price_range) }}</span>
                @endif

                @if ($showOpenStatus && method_exists($place, 'isOpenNow'))
                    <span class="badge" style="background-color: {{ $place->isOpenNow() ? '#2ecc71' : '#e74c3c' }}; color: white;">
                        {{ $place->isOpenNow() ? '🟢' : '🔴' }} {{ $place->statusText() }}
                    </span>
                @endif

                @if ($showDistance && isset($place->distance_km))
                    <span class="badge">🚶 {{ $place->distance_km }} km</span>
                @endif

                @if ($showReviewStats)
                    <span class="badge">💬 {{ $place->reviews_count ?? 0 }} yorum</span>
                    <span class="badge">❤️ {{ $place->favorited_by_count ?? 0 }} favori</span>
                @endif

                @if ($showTags && $place->tags)
                    @foreach ($place->tags as $tag)
                        <span class="badge">{{ $tag->emoji }} {{ $tag->name }}</span>
                    @endforeach
                @endif
            </p>
            <p><span class="rating">⭐ {{ $place->rating ?? 'Henüz puanlanmamış' }}</span></p>
      	    @if ($showDescription && $place->description)
                <p><strong>Açıklama:</strong> {{ Str::limit($place->description, 100) }}</p>
            @endif
            <a href="/establishments/{{ $place->id }}" class="btn">Detaylar</a>
        </div>
        <div>
            @if ($place->primaryPhoto)
                <img src="{{ $place->primaryPhoto->url() }}" alt="{{ $place->name }}" style="width: {{ $photoSize }}; height: {{ $photoSize }}; border-radius: 8px; object-fit: cover; flex-shrink: 0;">
            @elseif ($place->image)
                <img src="{{ $place->image }}" alt="{{ $place->name }}" style="width: {{ $photoSize }}; height: {{ $photoSize }}; border-radius: 8px; object-fit: cover; flex-shrink: 0;">
            @else
                <div style="width: {{ $photoSize }}; height: {{ $photoSize }}; border-radius: 8px; background-color: {{ $place->type === 'restaurant' ? '#fce4e4' : '#e4f7e9' }}; display: flex; align-items: center; justify-content: center; font-size: 32px; flex-shrink: 0;">
                    {{ $place->type === 'restaurant' ? '🍽️' : '☕' }}
                </div>
            @endif
        </div>
    </div>
</div>
