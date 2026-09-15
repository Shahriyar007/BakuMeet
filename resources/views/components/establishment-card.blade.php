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

<div class="bk-card" style="margin-top: 12px; padding: 12px;">
    <div style="display: flex; justify-content: space-between; align-items: start; gap: 12px;">
        <div style="flex: 1; min-width: 0;">
            <p class="heading" style="font-size: var(--text-card-title); margin-bottom: 6px;">
                @if ($index !== null)
                    #{{ $index + 1 }} ·
                @endif
                {{ $place->name }}
            </p>
            <div style="display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 6px;">
                <span class="bk-chip">
                    <i class="ti {{ $place->type === 'restaurant' ? 'ti-tools-kitchen-2' : 'ti-coffee' }}" aria-hidden="true"></i>
                    {{ $place->type === 'restaurant' ? 'Restoran' : 'Kafe' }}
                </span>
                @if ($showLocation)
                    <span class="bk-chip">
                        <i class="ti ti-map-pin" aria-hidden="true"></i>{{ $place->location ?? $place->neighborhood ?? 'Bakı' }}
                    </span>
                @endif
                <span class="bk-chip">{{ $place->mood ?? 'Genel' }}</span>
                @if ($place->price_range)
                    <span class="bk-chip">{{ str_repeat('₼', $place->price_range) }}</span>
                @endif

                @if ($showOpenStatus && method_exists($place, 'isOpenNow'))
                    <span class="bk-chip {{ $place->isOpenNow() ? 'bk-badge--success' : 'bk-badge--danger' }}">
                        {{ $place->statusText() }}
                    </span>
                @endif

                @if ($showDistance && isset($place->distance_km))
                    <span class="bk-chip">
                        <i class="ti ti-walk" aria-hidden="true"></i>{{ $place->distance_km }} km
                    </span>
                @endif

                @if ($showReviewStats)
                    <span class="bk-chip">
                        <i class="ti ti-message-circle" aria-hidden="true"></i>{{ $place->reviews_count ?? 0 }}
                    </span>
                    <span class="bk-chip">
                        <i class="ti ti-heart" aria-hidden="true"></i>{{ $place->favorited_by_count ?? 0 }}
                    </span>
                @endif

                @if ($showTags && $place->tags)
                    @foreach ($place->tags as $tag)
                        <span class="bk-chip">{{ $tag->emoji }} {{ $tag->name }}</span>
                    @endforeach
                @endif
            </div>
            <div style="display: flex; align-items: center; gap: 4px; margin-bottom: 6px;">
                <i class="ti ti-star" style="color: var(--color-accent); font-size: 14px;" aria-hidden="true"></i>
                <span style="font-size: var(--text-secondary); color: var(--color-text);">{{ $place->rating ?? 'Henüz puanlanmamış' }}</span>
            </div>
            @if ($showDescription && $place->description)
                <p style="font-size: var(--text-secondary); color: var(--color-text-muted); margin-bottom: 8px;">{{ Str::limit($place->description, 100) }}</p>
            @endif
            <a href="/establishments/{{ $place->id }}" class="bk-btn-secondary" style="display: inline-flex; min-height: auto; padding: 6px 14px; font-size: var(--text-meta);">Detaylar</a>
        </div>
        <div style="position: relative; flex-shrink: 0;">
            @if ($place->primaryPhoto)
                <img src="{{ $place->primaryPhoto->url() }}" alt="{{ $place->name }}" style="width: {{ $photoSize }}; height: {{ $photoSize }}; border-radius: var(--radius-photo); object-fit: cover;">
            @elseif ($place->image)
                <img src="{{ $place->image }}" alt="{{ $place->name }}" style="width: {{ $photoSize }}; height: {{ $photoSize }}; border-radius: var(--radius-photo); object-fit: cover;">
            @else
                <div class="bk-photo-placeholder" style="width: {{ $photoSize }}; height: {{ $photoSize }}; border-radius: var(--radius-photo); font-size: 24px;">
                    <i class="ti {{ $place->type === 'restaurant' ? 'ti-tools-kitchen-2' : 'ti-coffee' }}" aria-hidden="true"></i>
                </div>
            @endif
            @if ($place->photos && $place->photos->count() > 1)
                <span style="position: absolute; bottom: 4px; right: 4px; background: rgba(42,33,27,0.7); color: #fff; font-size: 10px; padding: 2px 6px; border-radius: 999px;">
                    <i class="ti ti-photo" style="font-size: 10px;" aria-hidden="true"></i> {{ $place->photos->count() }}
                </span>
            @endif
        </div>
    </div>
</div>
