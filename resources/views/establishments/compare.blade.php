@extends('layouts.app')

@section('title', 'Karşılaştır - BakuMeet')

@section('content')
    <div>
        <a href="/establishments" style="color: #3498db; text-decoration: none;">← Geri Dön</a>
        <h2>⚖️ Karşılaştırma</h2>

        @if ($establishments->count() < 2)
            <div class="card" style="background-color: #fff3cd; border-left: 4px solid #f39c12;">
                <p>Karşılaştırmak için en az 2 mekan seçmelisin.</p>
            </div>
        @else
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse; min-width: 500px;">
                    <tr>
                        <td style="padding: 8px; font-weight: bold; border-bottom: 2px solid #eee;"></td>
                        @foreach ($establishments as $place)
                            <td style="padding: 8px; text-align: center; border-bottom: 2px solid #eee;">
                                <strong>{{ $place->name }}</strong>
                            </td>
                        @endforeach
                    </tr>
                    <tr>
                        <td style="padding: 8px; color: #999;">Tür</td>
                        @foreach ($establishments as $place)
                            <td style="padding: 8px; text-align: center;">{{ $place->type === 'restaurant' ? '🍽️ Restoran' : '☕ Kafe' }}</td>
                        @endforeach
                    </tr>
                    <tr style="background: #f9f9f9;">
                        <td style="padding: 8px; color: #999;">Puan</td>
                        @foreach ($establishments as $place)
                            <td style="padding: 8px; text-align: center;">⭐ {{ $place->rating ?? '-' }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td style="padding: 8px; color: #999;">Fiyat</td>
                        @foreach ($establishments as $place)
                            <td style="padding: 8px; text-align: center;">{{ str_repeat('₼', $place->price_range) }}</td>
                        @endforeach
                    </tr>
                    <tr style="background: #f9f9f9;">
                        <td style="padding: 8px; color: #999;">Semt</td>
                        @foreach ($establishments as $place)
                            <td style="padding: 8px; text-align: center;">📍 {{ $place->location }}</td>
                        @endforeach
                    </tr>
                    <tr>
                        <td style="padding: 8px; color: #999;">Ruh Hali</td>
                        @foreach ($establishments as $place)
                            <td style="padding: 8px; text-align: center;">🎭 {{ $place->mood }}</td>
                        @endforeach
                    </tr>
                    @if ($establishments->contains(fn($p) => isset($p->distance_km)))
                        <tr style="background: #f9f9f9;">
                            <td style="padding: 8px; color: #999;">Mesafe</td>
                            @foreach ($establishments as $place)
                                <td style="padding: 8px; text-align: center;">
                                    {{ isset($place->distance_km) ? '🚶 ' . $place->distance_km . ' km' : '-' }}
                                </td>
                            @endforeach
                        </tr>
                    @endif
                    <tr>
                        <td style="padding: 8px; color: #999; vertical-align: top;">Özellikler</td>
                        @foreach ($establishments as $place)
                            <td style="padding: 8px; text-align: center; font-size: 12px;">
                                @forelse ($place->tags as $tag)
                                    {{ $tag->emoji }} {{ $tag->name }}<br>
                                @empty
                                    -
                                @endforelse
                            </td>
                        @endforeach
                    </tr>
                    <tr style="background: #f9f9f9;">
                        <td style="padding: 8px;"></td>
                        @foreach ($establishments as $place)
                            <td style="padding: 8px; text-align: center;">
                                <a href="/establishments/{{ $place->id }}" class="btn">Detaylar</a>
                            </td>
                        @endforeach
                    </tr>
                </table>
            </div>
        @endif
    </div>
@endsection

