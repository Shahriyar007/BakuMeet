@extends('layouts.app')

@section('title', 'Sürpriz Bana - BakuMeet')

@section('content')
    <div>
        <h2>🎲 Sürpriz Bana</h2>

        @if (!$establishment)
            <div class="card" style="background-color: #fff3cd; border-left: 4px solid #f39c12;">
                <p>Şu an önerecek bir mekan bulunamadı.</p>
            </div>
        @else
            <div class="card">
                <div style="text-align: center; margin-bottom: 15px;">
		@if ($establishment->primaryPhoto)
    <img src="{{ $establishment->primaryPhoto->url() }}" alt="{{ $establishment->name }}" style="width: 100%; max-height: 250px; border-radius: 8px; object-fit: cover;">
@elseif ($establishment->image)
    <img src="{{ $establishment->image }}" alt="{{ $establishment->name }}" style="width: 100%; max-height: 250px; border-radius: 8px; object-fit: cover;">
                    @else
                        <div style="width: 100%; height: 180px; border-radius: 8px; background-color: {{ $establishment->type === 'restaurant' ? '#fce4e4' : '#e4f7e9' }}; display: flex; align-items: center; justify-content: center; font-size: 56px;">
                            {{ $establishment->type === 'restaurant' ? '🍽️' : '☕' }}
                        </div>
                    @endif
                </div>

                <h3 style="text-align: center;">{{ $establishment->name }}</h3>

                <p style="text-align: center; margin: 10px 0;">
                    <span class="badge {{ $establishment->type }}">
                        @if ($establishment->type === 'restaurant')
                            🍽️ Restoran
                        @else
                            ☕ Kafe
                        @endif
                    </span>
                    <span class="badge">📍 {{ $establishment->location }}</span>
                    <span class="badge">🎭 {{ $establishment->mood }}</span>
                    <span class="badge">{{ str_repeat('₼', $establishment->price_range) }}</span>
                </p>

                <p style="text-align: center;"><span class="rating">⭐ {{ $establishment->rating ?? 'Henüz puanlanmamış' }}</span></p>

                @if ($establishment->description)
                    <p style="margin: 15px 0;">{{ Str::limit($establishment->description, 150) }}</p>
                @endif

                <div style="text-align: center; margin-top: 15px;">
                    <a href="/establishments/{{ $establishment->id }}" class="btn">Detaylar</a>
                </div>
            </div>

            <div style="text-align: center; margin-top: 15px;">
                <a href="/surprise" style="padding: 12px 20px; background-color: #3498db; color: white; border-radius: 4px; text-decoration: none; display: inline-block;">
                    🎲 Tekrar Dene
                </a>
            </div>
        @endif
    </div>
@endsection
