@extends('layouts.app')

@section('title', 'Karşılaştır - BakuMeet')

@section('content')
    <div style="padding-top: 16px;">
        <a href="/establishments" style="display: inline-flex; align-items: center; gap: 4px; color: var(--color-text-secondary); text-decoration: none; font-size: var(--text-meta); margin-bottom: 8px;">
            <i class="ti ti-arrow-left" aria-hidden="true"></i>Geri dön
        </a>
        <p class="heading" style="font-size: var(--text-title); margin-bottom: 16px;">
            <i class="ti ti-arrows-left-right" style="color: var(--color-accent); font-size: 18px;" aria-hidden="true"></i> Karşılaştırma
        </p>

        @if ($establishments->count() < 2)
            <div class="bk-card" style="padding: 24px 20px; text-align: center;">
                <p style="font-size: var(--text-secondary); color: var(--color-text-secondary);">Karşılaştırmak için en az 2 mekan seçmelisin.</p>
            </div>
        @else
            <div class="bk-card" style="overflow-x: auto; padding: 0;">
                <table style="width: 100%; border-collapse: collapse; min-width: 480px; font-size: var(--text-meta);">
                    <tr>
                        <td style="padding: 12px; border-bottom: 0.5px solid var(--color-border);"></td>
                        @foreach ($establishments as $place)
                            <td style="padding: 12px; text-align: center; border-bottom: 0.5px solid var(--color-border); font-weight: var(--weight-medium); color: var(--color-text);">{{ $place->name }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td style="padding: 10px 12px; color: var(--color-text-secondary);">Tür</td>
                        @foreach ($establishments as $place)
                            <td style="padding: 10px 12px; text-align: center; color: var(--color-text-muted);">{{ $place->type === 'restaurant' ? 'Restoran' : 'Kafe' }}</td>
                        @endforeach
                    </tr>
                    <tr style="background: var(--color-bg-muted);">
                        <td style="padding: 10px 12px; color: var(--color-text-secondary);">Puan</td>
                        @foreach ($establishments as $place)
                            <td style="padding: 10px 12px; text-align: center; color: var(--color-accent); font-weight: var(--weight-medium);">{{ $place->rating ?? '-' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td style="padding: 10px 12px; color: var(--color-text-secondary);">Fiyat</td>
                        @foreach ($establishments as $place)
                            <td style="padding: 10px 12px; text-align: center; color: var(--color-text-muted);">{{ str_repeat('₼', $place->price_range) }}</td>
                        @endforeach
                    </tr>
                    <tr style="background: var(--color-bg-muted);">
                        <td style="padding: 10px 12px; color: var(--color-text-secondary);">Semt</td>
                        @foreach ($establishments as $place)
                            <td style="padding: 10px 12px; text-align: center; color: var(--color-text-muted);">{{ $place->location }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td style="padding: 10px 12px; color: var(--color-text-secondary);">Ruh hali</td>
                        @foreach ($establishments as $place)
                            <td style="padding: 10px 12px; text-align: center; color: var(--color-text-muted);">{{ $place->mood }}</td>
                        @endforeach
                    </tr>
                    @if ($establishments->contains(fn($p) => isset($p->distance_km)))
                        <tr style="background: var(--color-bg-muted);">
                            <td style="padding: 10px 12px; color: var(--color-text-secondary);">Mesafe</td>
                            @foreach ($establishments as $place)
                                <td style="padding: 10px 12px; text-align: center; color: var(--color-text-muted);">
                                    {{ isset($place->distance_km) ? $place->distance_km . ' km' : '-' }}
                                </td>
                            @endforeach
                        </tr>
                    @endif
                    <tr>
                        <td style="padding: 10px 12px; color: var(--color-text-secondary); vertical-align: top;">Özellikler</td>
                        @foreach ($establishments as $place)
                            <td style="padding: 10px 12px; text-align: center; color: var(--color-text-muted); font-size: var(--text-micro);">
                                @forelse ($place->tags as $tag)
                                    {{ $tag->emoji }} {{ $tag->name }}<br>
                                @empty
                                    -
                                @endforelse
                            </td>
                        @endforeach
                    </tr>
                    <tr style="background: var(--color-bg-muted);">
                        <td style="padding: 10px 12px;"></td>
                        @foreach ($establishments as $place)
                            <td style="padding: 10px 12px; text-align: center;">
                                <a href="/establishments/{{ $place->id }}" class="bk-btn-primary" style="min-height: auto; padding: 6px 12px; font-size: var(--text-micro); display: inline-flex;">Detaylar</a>
                            </td>
                        @endforeach
                    </tr>
                </table>
            </div>
        @endif
    </div>
@endsection
