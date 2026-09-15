@extends('layouts.app')

@section('title', 'Sürpriz Bana - BakuMeet')

@section('content')
    <div style="padding-top: 16px;">
        <p class="heading" style="font-size: var(--text-title); margin-bottom: 16px;">
            <i class="ti ti-dice" style="color: var(--color-accent); font-size: 18px;" aria-hidden="true"></i> Sürpriz bana
        </p>

        @if (!$establishment)
            <div class="bk-card" style="padding: 28px 20px; text-align: center;">
                <p style="font-size: var(--text-secondary); color: var(--color-text-secondary);">Şu an önerecek bir mekan bulunamadı.</p>
            </div>
        @else
            <div class="bk-card" style="margin-bottom: 16px;">
                @if ($establishment->primaryPhoto)
                    <img src="{{ $establishment->primaryPhoto->url() }}" alt="{{ $establishment->name }}" style="width: 100%; height: 200px; object-fit: cover;">
                @elseif ($establishment->image)
                    <img src="{{ $establishment->image }}" alt="{{ $establishment->name }}" style="width: 100%; height: 200px; object-fit: cover;">
                @else
                    <div class="bk-photo-placeholder" style="width: 100%; height: 200px;">
                        <i class="ti {{ $establishment->type === 'restaurant' ? 'ti-tools-kitchen-2' : 'ti-coffee' }}" style="font-size: 36px;" aria-hidden="true"></i>
                    </div>
                @endif

                <div style="padding: 16px; text-align: center;">
                    <p class="heading" style="font-size: 18px; margin-bottom: 8px;">{{ $establishment->name }}</p>

                    <div style="display: flex; gap: 6px; justify-content: center; flex-wrap: wrap; margin-bottom: 10px;">
                        <span class="bk-chip">{{ $establishment->type === 'restaurant' ? 'Restoran' : 'Kafe' }}</span>
                        <span class="bk-chip">{{ $establishment->location }}</span>
                        <span class="bk-chip">{{ $establishment->mood }}</span>
                        @if ($establishment->price_range)
                            <span class="bk-chip">{{ str_repeat('₼', $establishment->price_range) }}</span>
                        @endif
                    </div>

                    <div style="display: flex; align-items: center; justify-content: center; gap: 4px; margin-bottom: 12px;">
                        <i class="ti ti-star" style="color: var(--color-accent); font-size: 14px;" aria-hidden="true"></i>
                        <span style="font-size: var(--text-secondary); color: var(--color-text);">{{ $establishment->rating ?? 'Henüz puanlanmamış' }}</span>
                    </div>

                    @if ($establishment->description)
                        <p style="font-size: var(--text-secondary); color: var(--color-text-muted); margin-bottom: 14px;">{{ Str::limit($establishment->description, 150) }}</p>
                    @endif

                    <a href="/establishments/{{ $establishment->id }}" class="bk-btn-primary" style="display: inline-flex;">Detaylar</a>
                </div>
            </div>

            <a href="/surprise" class="bk-btn-secondary" style="width: 100%; display: flex;">
                <i class="ti ti-dice" aria-hidden="true"></i>Tekrar dene
            </a>
        @endif
    </div>
@endsection
