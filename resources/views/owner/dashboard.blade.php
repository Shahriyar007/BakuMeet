@extends('layouts.owner')

@section('title', 'Panel')

@section('content')
    <h1>Merhaba, {{ $account->name }}</h1>

    @if ($account->isPending())
        <div style="background: #fff8e1; padding: 16px; border-radius: 6px;">
            <p><strong>Başvurunuz inceleniyor.</strong></p>
            <p>Onaylandığında bu sayfadan işletmenizi ekleyebileceksiniz.</p>
        </div>
    @elseif (! $establishment)
        <div style="background: #e6f4ff; padding: 16px; border-radius: 6px;">
            <p>Hesabınız onaylandı. Henüz bir işletme eklemediniz.</p>
            <a href="{{ route('owner.establishments.create') }}" style="display: inline-block; margin-top: 8px; padding: 10px 20px; background: #222; color: white; border-radius: 4px; text-decoration: none;">+ İşletme Ekle</a>
        </div>
    @else
        <div style="background: white; padding: 16px; border-radius: 6px;">
            <h2>{{ $establishment->name }}</h2>

            @if ($establishment->status === 'pending')
                <p style="background: #fff8e1; padding: 8px; border-radius: 4px;">⏳ Onay bekleniyor</p>
            @elseif ($establishment->status === 'approved')
                <p style="background: #e6ffed; padding: 8px; border-radius: 4px;">✅ Yayında</p>
            @elseif ($establishment->status === 'rejected')
                <div style="background: #ffe6e6; padding: 8px; border-radius: 4px;">
                    <p style="margin: 0;">❌ Reddedildi</p>
                    @if ($establishment->rejection_reason)
                        <p style="margin: 4px 0 0; font-size: 14px;"><strong>Sebep:</strong> {{ $establishment->rejection_reason }}</p>
                    @endif
                </div>
            @endif

            @if ($establishment->status === 'approved')
                <div style="display: flex; gap: 16px; margin: 12px 0; padding: 12px; background: #f5f5f5; border-radius: 4px; text-align: center;">
                    <div style="flex: 1;">
                        <div style="font-size: 18px; font-weight: bold;">⭐ {{ $establishment->rating ?? '-' }}</div>
                        <div style="font-size: 11px; color: #999;">Puan</div>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: 18px; font-weight: bold;">💬 {{ $establishment->reviews_count }}</div>
                        <div style="font-size: 11px; color: #999;">Yorum</div>
                    </div>
                    <div style="flex: 1;">
                        <div style="font-size: 18px; font-weight: bold;">❤️ {{ $establishment->favorited_by_count }}</div>
                        <div style="font-size: 11px; color: #999;">Favori</div>
                    </div>
                </div>
            @endif

            <p><strong>Tür:</strong> {{ $establishment->type === 'cafe' ? 'Kafe' : 'Restoran' }}</p>
            <p><strong>Mood:</strong> {{ $establishment->mood }}</p>
            <p><strong>Konum:</strong> {{ $establishment->location }}</p>
            <p><strong>Fiyat Aralığı:</strong> {{ str_repeat('₼', $establishment->price_range) }}</p>

            @if ($establishment->description)
                <p><strong>Açıklama:</strong><br>{{ $establishment->description }}</p>
            @endif

            @if ($establishment->latitude && $establishment->longitude)
                <p><strong>Koordinatlar:</strong> {{ $establishment->latitude }}, {{ $establishment->longitude }}</p>
            @endif

           @if ($establishment->tags->isNotEmpty())
                <p><strong>Etiketler:</strong> {{ $establishment->tags->pluck('name')->join(', ') }}</p>
            @endif

            @if ($establishment->opening_hours)
                <p><strong>Çalışma Saatleri:</strong></p>
                <ul style="margin: 0 0 12px; padding-left: 20px;">
                    @php
                        $dayLabels = ['monday' => 'Pazartesi', 'tuesday' => 'Salı', 'wednesday' => 'Çarşamba', 'thursday' => 'Perşembe', 'friday' => 'Cuma', 'saturday' => 'Cumartesi', 'sunday' => 'Pazar'];
                    @endphp
                    @foreach ($dayLabels as $key => $label)
                        @php $day = $establishment->opening_hours[$key] ?? null; @endphp
                        <li>
                            {{ $label }}:
                            @if (! $day || ($day['closed'] ?? false))
                                Kapalı
                            @else
                                {{ $day['open'] }} - {{ $day['close'] }}
                            @endif
                        </li>
                    @endforeach
                </ul>
            @endif

            <div style="display: flex; gap: 8px; margin-top: 8px; flex-wrap: wrap;">
                <a href="{{ route('owner.establishments.edit') }}" style="display: inline-block; padding: 10px 20px; background: #222; color: white; border-radius: 4px; text-decoration: none;">Düzenle</a>
                @if ($establishment->status === 'approved')
		<a href="{{ url('/establishments/'.$establishment->id) }}" target="_blank" style="display: inline-block; padding: 10px 20px; background: #3498db; color: white; border-radius: 4px; text-decoration: none;">👁 Profili Gör</a>
                @endif
            </div>
        </div>
    @endif
@endsection
